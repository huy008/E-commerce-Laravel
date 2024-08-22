<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\PostServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;

/**
 * Class PostService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
     protected $postRepository;

     public function __construct(PostRepository $postRepository)
     {
          $this->postRepository = $postRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $condition['where'] = [
               ['tb2.language_id', '=', $this->currentLanguage()]
          ];
          $perPage = $request->integer('perpage');
          $Post = $this->postRepository->pagination(
               [
                    'posts.id',
                    'posts.publish',
                    'posts.image',
                    'posts.follow',
                    'tb2.canonical',
                    'tb2.name'
               ],
               $condition,
               [
                    ['post_language as tb2', 'tb2.post_id', '=', 'posts.id'],
                    ['post_catalogue_post as tb3', 'posts.id', '=', 'tb3.post_id']
               ],
               $perPage,
              
               [],
               $this->whereRaw($request)
          );
          return $Post;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
             
               $payload = $request->only(['follow', 'publish', 'image', 'post_catalogue_id','album']);
               $payload["user_id"] = Auth::id();
               $payload["album"] = json_encode($payload["album"]);
               $post = $this->postRepository->create($payload);
               if ($post->id > 0) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['post_id'] = $post->id;
           
                    $language = $this->postRepository->createTranslatePivot($post, $payloadLanguage);
                    $catalogue = $this->catalogue($request);
                    $post->post_catalogues()->sync($catalogue);
               }

               DB::commit();

               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     public function update($id, $request)
     {
          DB::beginTransaction();
          try {
               $post = $this->postRepository->findById($id);
               $payload = $request->only(['parentid', 'follow', 'publish', 'image','album']);
               $payload["album"] = json_encode($payload["album"]);
               $flag = $this->postRepository->update($id, $payload);
               if ($flag == true) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['post_id'] = $id;
                    $post->languages()->detach($payloadLanguage['language_id'], $id);
                    $response = $this->postRepository->createTranslatePivot($post, $payloadLanguage);
                    $catalogue = $this->catalogue($request);
                    $post->post_catalogues()->sync($catalogue);
               }
               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     public function destroy($id)
     {
          DB::beginTransaction();
          try {
               $post = $this->postRepository->destroy($id);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     public function updateStatus($post = [])
     {
          DB::beginTransaction();
          try {
               $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);
               $Post = $this->postRepository->update($post['modelId'], $payload);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     public function updateStatusAll($post = [])
     {
          DB::beginTransaction();
          try {
               $payload[$post['field']] =  $post['value'];
               $Post = $this->postRepository->updateByWhereIn('id', $post['id'], $payload);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     private function catalogue($request)
     {
          return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
     }

     private function whereRaw($request)
     {
          $rawCondition = [];
          if ($request->integer('post_catalogue_id') > 0) {
               $rawCondition['whereRaw'] = [
                    [
                         'tb3.post_catalogue_id IN (
                         SELECT id
                         FROM post_catalogues
                         WHERE  `left` >= (SELECT `left` FROM post_catalogues as pc WHERE pc.id = ?)
                          AND `right` <= (SELECT `right` FROM post_catalogues as pc WHERE pc.id = ?)
                         )',
                         [$request->integer('post_catalogue_id'), $request->integer('post_catalogue_id')]
                    ]
               ];
          }
          return $rawCondition;
     }
}
