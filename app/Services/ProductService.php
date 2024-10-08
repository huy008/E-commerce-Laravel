<?php

namespace App\Services;

use Exception;
use App\Classes\Nestedsetbie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\ProductServiceInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\ProductVariantLanguageRepositoryInterface as ProductVariantLanguageRepository;
use App\Repositories\Interfaces\ProductVariantAttributeRepositoryInterface as ProductVariantAttributeRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;

/**
 * Class PostService
 * @package App\Services
 */
class ProductService extends BaseService implements ProductServiceInterface
{
     protected $productRepository;
     protected $nestedset;
     protected $routerRepository;
     protected $productVariantLanguageRepository;
     protected $productVariantAttributeRepository;
     public function __construct(ProductRepository $productRepository, RouterRepository $routerRepository, ProductVariantLanguageRepository $productVariantLanguageRepository, ProductVariantAttributeRepository $productVariantAttributeRepository)
     {
          $this->productRepository = $productRepository;
          $this->routerRepository = $routerRepository;
          $this->productVariantLanguageRepository = $productVariantLanguageRepository;
          $this->productVariantAttributeRepository = $productVariantAttributeRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'products',
               'foreignkey' => 'product_id',
               'language_id' =>  1,
          ]);
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $product =
               $this->productRepository->pagination(
                    [
                         'products.id',
                         'products.publish',
                         'products.image',
                         'tb2.name',
                         'tb2.canonical'
                    ],
                    $condition,
                    [
                         ['product_language as tb2', 'tb2.product_id', '=', 'products.id'],
                    ],
                    $perPage,
                    [],
                    ['products.id', 'asc'],
               );
          return $product;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->only(['parentid', 'follow', 'publish', 'image', 'product_catalogue_id']);
               $payload["user_id"] = Auth::id();
               $product = $this->productRepository->create($payload);
               if ($product->id > 0) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['product_id'] = $product->id;
                    $language = $this->productRepository->createTranslatePivot($product, $payloadLanguage);

                    $catalogue = $this->catalogue($request);
                    $product->product_catalogues()->sync($catalogue);

                    $this->createVariant($product, $request, 1);
               }
               // $this->nestedset->Get('level ASC', 'order ASC');
               // $this->nestedset->Recursive(0, $this->nestedset->Set());
               // $this->nestedset->Action();
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
          return array_unique(array_merge($request->input('catalogue') ?? [], [$request->product_catalogue_id]));
     }
     private function createVariant($product, $request, $languageId)
     {
          $payload = $request->only(['variant', 'attribute']);
          $variant = [];
          if (isset($payload['variant']['sku']) && count($payload['variant']['sku'])) {
               foreach ($payload['variant']['sku'] as $key => $val) {
                    $variant[] = [
                         'code' => ($payload['variant']['id'][$key]) ?? '',
                         'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                         'sku' => $val,
                         'price' => ($payload['variant']['price'][$key]) ?? '',
                         'barcode' => ($payload['variant']['barcode'][$key]) ?? '',
                         'file_name' => ($payload['variant']['file_name'][$key]) ?? '',
                         'file_url' => ($payload['variant']['file_url'][$key]) ?? '',
                         'album' => ($payload['variant']['album'][$key]) ?? '',
                         'user_id' => Auth::id()
                    ];
               }
               $variants = $product->product_variants()->createMany($variant);
               $variantsId = $variants->pluck('id');
               $productVariantLanguage = [];
               $variantAttributes = [];
               $attributeCombines = $this->comebineAttribute(array_values($payload['attribute']));
               if (count($variantsId)) {
                    foreach ($variantsId as $key => $val) {
                         $productVariantLanguage[] = [
                              'product_variant_id' => $val,
                              'language_id' => $languageId,
                              'name' => $payload['variant']['name'][$key]
                         ];
                         if (count($attributeCombines)) {
                              foreach ($attributeCombines[$key] as $attrId) {
                                             $variantAttributes[] = [
                                                  'product_variant_id' => $val,
                                                  'attribute_id' => $attrId,
                                             ];
                                   }
                              }
                         }
                    }
               // dd($variantAttributes);    
               $variantLanguage = $this->productVariantLanguageRepository->createBath($productVariantLanguage);
               $variantAttribute = $this->productVariantAttributeRepository->createBath($variantAttributes);
          }
     }

     private function comebineAttribute($attributes = [], $index = 0)
     {
          if ($index === count($attributes)) return [[]];
          $subCombines = $this->comebineAttribute($attributes, $index + 1);
          $combines = [];
          foreach ($attributes[$index] as $key => $val) {
               foreach ($subCombines as $keySub => $valSub) {
                    $combines[] = array_merge([$val], $valSub);
               }
          }
          return $combines;
     }

     public function update($id, $request)
     {
          DB::beginTransaction();
          try {
               $product = $this->productRepository->findById($id);
               $payload = $request->only(['parentid', 'follow', 'publish', 'image']);
               $flag = $this->productRepository->update($id, $payload);
               if ($flag == true) {
                    $payloadLanguage = $request->only(['name', 'description', 'content', 'meta_title', 'meta_keyword', 'meta_description', 'canonical']);
                    $payloadLanguage['language_id'] = $this->currentLanguage();
                    $payloadLanguage['product_id'] = $id;
                    $product->languages()->detach($payloadLanguage['language_id'], $id);
                    $response = $this->productRepository->createTranslatePivot($product, $payloadLanguage);

                    $payloadRouter = [
                         'canonical' => $payloadLanguage['canonical'],
                         'module_id' => $product->id,
                         'controllers' => 'App\Http\Controllers\Frontend\ProductController'
                    ];
                    $condition = [
                         ['module_id', '=', $id],
                         ['controllers', '=', 'App\Http\Controllers\Frontend\productController']
                    ];
                    $router = $this->routerRepository->findByCondition($condition);
                    $this->routerRepository->update($router->id);

                    // $this->nestedset->Get('level ASC', 'order ASC');
                    // $this->nestedset->Recursive(0, $this->nestedset->Set());
                    // $this->nestedset->Action();
                    $product->product_variants()->each(function($variant){
                         $variant->languages()->detach();
                         $variant->attributes()->detach();
                         $variant->delete();
                    });

                    $this->createVariant($product, $request, 1);
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
               $product = $this->productRepository->destroy($id);
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
               $Post = $this->productRepository->update($post['modelId'], $payload);

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
               $Post = $this->productRepository->updateByWhereIn('id', $post['id'], $payload);

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