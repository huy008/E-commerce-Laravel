<?php

namespace App\Services;

use Exception;
use App\Classes\Nestedsetbie;
use App\Models\ProductCatalogue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;

/**
 * Class PostService
 * @package App\Services
 */
class ProductCatalogueService extends BaseService implements ProductCatalogueServiceInterface
{
     protected $productCatalogueRepository;
     protected $nestedset;
     protected $routerRepository;

     public function __construct(ProductCatalogueRepository $productCatalogueRepository, RouterRepository $routerRepository)
     {
          $this->productCatalogueRepository = $productCatalogueRepository;
          $this->routerRepository = $routerRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'product_catalogues',
               'foreignkey' => 'product_catalogue_id',
               'language_id' =>  1,
          ]);
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $productCatalogue =
               $this->productCatalogueRepository->pagination(
                    [
                         'product_catalogues.id',
                         'product_catalogues.publish',
                         'product_catalogues.image',
                         'tb2.name',
                         'tb2.canonical'
                    ],
                    $condition,
                    [
                         ['product_catalogue_language as tb2', 'tb2.product_catalogue_id', '=', 'product_catalogues.id'],
                    ],
                    $perPage,
                    [],
                    ['product_catalogues.id', 'asc'],
               );
          return $productCatalogue;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $payload["user_id"] = Auth::id();
               $productCatalogue = $this->productCatalogueRepository->create($payload);
               if ($productCatalogue->id > 0) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['product_catalogue_id'] = $productCatalogue->id;
                    $language = $this->productCatalogueRepository->createTranslatePivot($productCatalogue, $payloadLanguage);

                    $router = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $productCatalogue->id,
                         'controllers' => 'App\Http\Controllers\Frontend\ProductCatalogueController'
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
               $productCatalogue = $this->productCatalogueRepository->findById($id);
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $flag = $this->productCatalogueRepository->update($id, $payload);
               if ($flag == true) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['product_catalogue_id'] = $id;
                    $productCatalogue->languages()->detach($payloadLanguage['language_id'], $id);
                    $response = $this->productCatalogueRepository->createTranslatePivot($productCatalogue, $payloadLanguage);

                    $payloadRouter = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $productCatalogue->id,
                         'controllers' => 'App\Http\Controllers\Frontend\ProductCatalogueController'
                    ];
                    $condition = [
                         ['module_id', '=', $id],
                         ['controllers', '=', 'App\Http\Controllers\Frontend\productCatalogueController']
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
               $productCatalogue = $this->productCatalogueRepository->destroy($id);
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
               $Post = $this->productCatalogueRepository->update($post['modelId'], $payload);

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
               $Post = $this->productCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);

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
