<?php

namespace App\Services;

use Exception;
use App\Models\Language;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\LanguageServiceInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;

/**
 * Class UserService
 * @package App\Services
 */
class LanguageService implements LanguageServiceInterface
{
     protected $LanguageRepository;
     public function __construct(LanguageRepository $LanguageRepository)
     {
          $this->LanguageRepository = $LanguageRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $Language =
               $this->LanguageRepository->pagination(['id', 'canonical', 'name', 'description', 'image'], $condition, [], $perPage, []);
          return $Language;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->except(['_token', 'send']);
               $payload['user_id'] = Auth::id();
               $Language = $this->LanguageRepository->create($payload);
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

               $user = $this->LanguageRepository->update($id, $payload);

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
               $user = $this->LanguageRepository->destroy($id);

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
               $user = $this->LanguageRepository->update($post['modelId'], $payload);

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
               $user = $this->LanguageRepository->updateByWhereIn('id', $post['id'], $payload);

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
