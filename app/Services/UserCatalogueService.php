<?php

namespace App\Services;

use Exception;
use App\Models\UserCatalogue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\UserCatalogueServiceInterface;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserCatalogueService implements UserCatalogueServiceInterface
{
     protected $userCatalogueRepository;
     public function __construct(UserCatalogueRepository $userCatalogueRepository)
     {
          $this->userCatalogueRepository = $userCatalogueRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $userCatalogue =
          $this->userCatalogueRepository->pagination(['id', 'description', 'name', 'publish'], $condition, [], $perPage, ['users']);
          return $userCatalogue;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->except(['_token', 'send']);
               $userCatalogue = $this->userCatalogueRepository->create($payload);
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

               $user = $this->userCatalogueRepository->update($id, $payload);

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
               $user = $this->userCatalogueRepository->destroy($id);

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
               $user = $this->userCatalogueRepository->update($post['modelId'], $payload);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     public function updateStatusAll($post = []){
          DB::beginTransaction();
          try {
               $payload[$post['field']] =  $post['value'];
               $user = $this->userCatalogueRepository->updateByWhereIn('id',$post['id'], $payload);

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