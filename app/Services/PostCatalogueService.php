<?php

namespace App\Services;

use Exception;
use App\Classes\Nestedsetbie;
use App\Models\PostCatalogue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;

/**
 * Class PostService
 * @package App\Services
 */
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
     protected $postCatalogueRepository;
     protected $nestedset;
     protected $routerRepository;

     public function __construct(PostCatalogueRepository $postCatalogueRepository, RouterRepository $routerRepository)
     {
          $this->postCatalogueRepository = $postCatalogueRepository;
          $this->routerRepository= $routerRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'post_catalogues',
               'foreignkey' => 'post_catalogue_id',
               'language_id' =>  1,
          ]);
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $PostCatalogue =
               $this->postCatalogueRepository->pagination(
                    [
                         'post_catalogues.id',
                         'post_catalogues.publish',
                         'post_catalogues.image',
                         'post_catalogues.level',
                         'tb2.name',
                         'tb2.canonical'
                    ],
                    $condition,
               [
                    ['post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=', 'post_catalogues.id'],
               ],
                    $perPage,
                    [],
                    ['post_catalogues.left', 'asc'],
               );
          return $PostCatalogue;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $payload["user_id"] = Auth::id();
               $postCatalogue = $this->postCatalogueRepository->create($payload);
               if ($postCatalogue->id > 0) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;
                    $language = $this->postCatalogueRepository->createTranslatePivot($postCatalogue, $payloadLanguage);

                    $router = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $postCatalogue->id,
                         'controllers' => 'App\Http\Controllers\Frontend\PostCatalogueController'
                    ];
                    $this->routerRepository->create($router);
               }
               $this->nestedset->Get('level ASC', 'order ASC');
               $this->nestedset->Recursive(0, $this->nestedset->Set());
               $this->nestedset->Action();
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
               $postCatalogue=$this->postCatalogueRepository->findById($id);
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $flag = $this->postCatalogueRepository->update($id,$payload);
               if($flag == true) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['post_catalogue_id'] = $id;
                    $postCatalogue->languages()->detach($payloadLanguage['language_id'],$id);
                    $response = $this->postCatalogueRepository->createTranslatePivot($postCatalogue, $payloadLanguage);

                    $payloadRouter = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $postCatalogue->id,
                         'controllers' => 'App\Http\Controllers\Frontend\PostCatalogueController'
                    ];
                    $condition = [
                         ['module_id','=',$id],
                         ['controllers' ,'=', 'App\Http\Controllers\Frontend\PostCatalogueController']
                    ];
                    $router= $this->routerRepository->findByCondition($condition);
                    $this->routerRepository->update($router->id);

               $this->nestedset->Get('level ASC', 'order ASC');
               $this->nestedset->Recursive(0, $this->nestedset->Set());
               $this->nestedset->Action();
                  
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
               $postCatalogue = $this->postCatalogueRepository->destroy($id);
               $this->nestedset->Get('level ASC', 'order ASC');
               $this->nestedset->Recursive(0, $this->nestedset->Set());
               $this->nestedset->Action();
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
               $Post = $this->postCatalogueRepository->update($post['modelId'], $payload);

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
               $Post = $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }
}
