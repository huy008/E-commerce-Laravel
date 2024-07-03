<?php

namespace App\Services;

use Exception;
use App\Classes\Nestedsetbie;
use App\Models\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\AttributeServiceInterface;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;

/**
 * Class PostService
 * @package App\Services
 */
class AttributeService extends BaseService implements AttributeServiceInterface
{
     protected $attributeRepository;
     protected $nestedset;
     protected $routerRepository;

     public function __construct(AttributeRepository $attributeRepository, RouterRepository $routerRepository)
     {
          $this->attributeRepository = $attributeRepository;
          $this->routerRepository = $routerRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'attributes',
               'foreignkey' => 'attribute_id',
               'language_id' =>  1,
          ]);
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $attribute =
               $this->attributeRepository->pagination(
                    [
                         'attributes.id',
                         'attributes.publish',
                         'attributes.image',
                         'tb2.name',
                         'tb2.canonical'
                    ],
                    $condition,
                    [
                         ['attribute_language as tb2', 'tb2.attribute_id', '=', 'attributes.id'],
                    ],
                    $perPage,
               ['attribute_catalogues'],
                    ['attributes.id', 'asc'],
               );
          return $attribute;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
     
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $payload["user_id"] = Auth::id();
               $attribute = $this->attributeRepository->create($payload);
       

               if ($attribute->id > 0) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['attribute_id'] = $attribute->id;
                    $language = $this->attributeRepository->createTranslatePivot($attribute, $payloadLanguage);
                    $catalogue = $this->catalogue($request);
                    $attribute->attribute_catalogues()->sync($catalogue);
                    $router = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $attribute->id,
                         'controllers' => 'App\Http\Controllers\AttributeController'
                    ];
                    $this->routerRepository->create($router);
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
     private function catalogue($request)
     {
          return array_unique(array_merge($request->input('catalogue'), [$request->attribute_catalogue_id]));
     }
     public function update($id, $request)
     {
          DB::beginTransaction();
          try {
               $attribute = $this->attributeRepository->findById($id);
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $flag = $this->attributeRepository->update($id, $payload);
               if ($flag == true) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['attribute_id'] = $id;
                    $attribute->languages()->detach($payloadLanguage['language_id'], $id);
                    $response = $this->attributeRepository->createTranslatePivot($attribute, $payloadLanguage);

                    $payloadRouter = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $attribute->id,
                         'controllers' => 'App\Http\Controllers\Frontend\AttributeController'
                    ];
                    $condition = [
                         ['module_id', '=', $id],
                         ['controllers', '=', 'App\Http\Controllers\Frontend\attributeController']
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
               $attribute = $this->attributeRepository->destroy($id);
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
               $Post = $this->attributeRepository->update($post['modelId'], $payload);

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
               $Post = $this->attributeRepository->updateByWhereIn('id', $post['id'], $payload);

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
