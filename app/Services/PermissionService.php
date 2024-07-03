<?php

namespace App\Services;

use Exception;
use App\Models\Permission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;

/**
 * Class UserService
 * @package App\Services
 */
class PermissionService implements PermissionServiceInterface
{
     protected $PermissionRepository;
     public function __construct(PermissionRepository $PermissionRepository)
     {
          $this->PermissionRepository = $PermissionRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $Permission =
               $this->PermissionRepository->pagination(['id', 'canonical', 'name'], $condition, [], $perPage, []);
          return $Permission;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->except(['_token', 'send']);
               $Permission = $this->PermissionRepository->create($payload);
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
               $user = $this->PermissionRepository->update($id, $payload);

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
               $user = $this->PermissionRepository->destroy($id);

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
