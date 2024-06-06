<?php

namespace App\Services;

use Exception;
use App\Models\PostCatalogue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;

/**
 * Class PostService
 * @package App\Services
 */
class PostCatalogueService implements PostCatalogueServiceInterface
{
     protected $PostCatalogueRepository;
     public function __construct(PostCatalogueRepository $PostCatalogueRepository)
     {
          $this->PostCatalogueRepository = $PostCatalogueRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $PostCatalogue =
               $this->PostCatalogueRepository->pagination(['id', 'description', 'name', 'publish'], $condition, [], $perPage, []);
          return $PostCatalogue;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->except(['_token', 'send']);
               $PostCatalogue = $this->PostCatalogueRepository->create($payload);
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
               $payload = $request->except(['_token', 'send']);

               $Post = $this->PostCatalogueRepository->update($id, $payload);

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
               $Post = $this->PostCatalogueRepository->destroy($id);

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
               $Post = $this->PostCatalogueRepository->update($post['modelId'], $payload);

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
               $Post = $this->PostCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);

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
