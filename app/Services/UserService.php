<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface
{
     protected $userRepository;
     public function __construct(UserRepository $userRepository)
     {
          $this->userRepository = $userRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          return $this->userRepository->pagination(['id', 'email', 'phone', 'address', 'name', 'publish', 'image'], $condition, [], $perPage);
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->except(['_token', 'send', 're_password']);
               $carbonDate = Carbon::createFromFormat('Y-m-d', $payload['birthday']);
               $payload['birthday'] = $carbonDate->format('Y-m-d H:i:s');
               $payload['password'] = Hash::make($payload['password']);

               $user = $this->userRepository->create($payload);

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
               $carbonDate = Carbon::createFromFormat('Y-m-d', $payload['birthday']);
               $payload['birthday'] = $carbonDate->format('Y-m-d H:i:s');

               $user = $this->userRepository->update($id, $payload);

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


               $user = $this->userRepository->destroy($id);

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
               $user = $this->userRepository->update($post['modelId'], $payload);

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
               $user = $this->userRepository->updateByWhereIn('id', $post['id'], $payload);

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
