<?php

namespace App\Services;

use Exception;
use App\Classes\Nestedsetbie;
use App\Models\{Module};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\{Module}ServiceInterface;
use App\Repositories\Interfaces\{Module}RepositoryInterface as {Module}Repository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;

/**
 * Class PostService
 * @package App\Services
 */
class {Module}Service extends BaseService implements {Module}ServiceInterface
{
     protected ${module}Repository;
     protected $nestedset;
     protected $routerRepository;

     public function __construct({Module}Repository ${module}Repository, RouterRepository $routerRepository)
     {
          $this->{module}Repository = ${module}Repository;
          $this->routerRepository = $routerRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => '{tableName}',
               'foreignkey' => '{foreignKey}',
               'language_id' =>  1,
          ]);
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          ${module} =
               $this->{module}Repository->pagination(
                    [
                         '{tableName}.id',
                         '{tableName}.publish',
                         '{tableName}.image',
                         'tb2.name',
                         'tb2.canonical'
                    ],
                    $condition,
                    [
                         ['{relationTableName} as tb2', 'tb2.{foreignKey}', '=', '{tableName}.id'],
                    ],
                    $perPage,
                    [],
                    ['{tableName}.id', 'asc'],
               );
          return ${module};
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $payload["user_id"] = Auth::id();
               ${module} = $this->{module}Repository->create($payload);
               if (${module}->id > 0) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['{foreignKey}'] = ${module}->id;
                    $language = $this->{module}Repository->createTranslatePivot(${module}, $payloadLanguage);

                    $router = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => ${module}->id,
                         'controllers' => 'App\Http\Controllers\Frontend\{Module}Controller'
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
               ${module} = $this->{module}Repository->findById($id);
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $flag = $this->{module}Repository->update($id, $payload);
               if ($flag == true) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['{foreignKey}'] = $id;
                    ${module}->languages()->detach($payloadLanguage['language_id'], $id);
                    $response = $this->{module}Repository->createTranslatePivot(${module}, $payloadLanguage);

                    $payloadRouter = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => ${module}->id,
                         'controllers' => 'App\Http\Controllers\Frontend\{Module}Controller'
                    ];
                    $condition = [
                         ['module_id', '=', $id],
                         ['controllers', '=', 'App\Http\Controllers\Frontend\{module}Controller']
                    ];
                    $router = $this->routerRepository->findByCondition($condition);
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
               ${module} = $this->{module}Repository->destroy($id);
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
               $Post = $this->{module}Repository->update($post['modelId'], $payload);

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
               $Post = $this->{module}Repository->updateByWhereIn('id', $post['id'], $payload);

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
