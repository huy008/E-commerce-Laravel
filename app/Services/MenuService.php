<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\MenuServiceInterface;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;

/**
 * Class MenuService
 * @package App\Services
 */
class MenuService extends BaseService implements MenuServiceInterface
{
     protected $menuRepository;
     protected $menuCatalogueRepository;
     protected $nestedset;
     public function __construct(MenuRepository $menuRepository,MenuCatalogueRepository $menuCatalogueRepository)
     {
          $this->menuRepository = $menuRepository;
          $this->menuCatalogueRepository = $menuCatalogueRepository;
     }

     public function paginate($request)
     {
          return [];
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {

               $payload = $request->only(['menu', 'menu_catalogue_id','id']);
               if (count($payload['menu']['name'])) {
                    foreach ($payload['menu']['name'] as $key => $value) {
                         $menuId = $payload['menu']['id'][$key];
                         $menuArray = [
                              'menu_catalogue_id' => $payload['menu_catalogue_id'],
                              'order' => $payload['menu']['order'][$key],
                              'user_id' => Auth::id()
                         ];
                         if ($menuId == 0) {
                              $menuSave = $this->menuRepository->create($menuArray);
                         } else {
                              $menuSave = $this->menuRepository->update($menuId, $menuArray);
                              if ($menuSave->tight - $menuSave->left > 1) {
                                   $this->menuRepository->updateByWhere(
                                        [
                                             ['left', '>', $menuSave->left],
                                             ['right', '>', $menuSave->right],
                                        ],
                                        [
                                             'menu_catalogue_id' => $payload['menu_catalogue_id']
                                        ]
                                   );
                              }
                         }
                         if ($menuSave->id > 0) {
                              $menuSave->languages()->detach([1, $menuSave->id]);
                              $payloadLanguage = [
                                   'language_id' => 1,
                                   'name' => $value,
                                   'canonical' => $payload['menu']['canonical'][$key],
                              ];
                              $data = $this->menuRepository->createRelationPivot($menuSave, $payloadLanguage, 'languages');
                         }
                    }
                    $this->nestedset = new Nestedsetbie([
                         'table' => 'menus',
                         'foreignkey' => 'menu_id',
                         'isMenu' => TRUE,
                         'language_id' => "1"
                    ]);
                    $this->nestedset->Get('id ASC', 'order ASC');
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

     public function saveChildren($request, $menu)
     {
          DB::beginTransaction();
          try {
               $payload = $request->only(['menu']);
               if (count($payload['menu']['name'])) {
                    foreach ($payload['menu']['name'] as $key => $value) {
                         $menuId = $payload['menu']['id'][$key];
                         $menuArray = [
                              'menu_catalogue_id' => $menu->menu_catalogue_id,
                              'parentid' => $menu->id,
                              'order' => $payload['menu']['order'][$key],
                              'user_id' => Auth::id()
                         ];
                         $menuSave = ($menuId == 0) ?  $this->menuRepository->create($menuArray) : $this->menuRepository->update($menuId, $menuArray);

                         if ($menuSave->id > 0) {
                              $menuSave->languages()->detach([1, $menuSave->id]);
                              $payloadLanguage = [
                                   'language_id' => 1,
                                   'name' => $value,
                                   'canonical' => $payload['menu']['canonical'][$key],
                              ];
                              $data = $this->menuRepository->createRelationPivot($menuSave, $payloadLanguage, 'languages');
                         }
                    }
                    $this->nestedset = new Nestedsetbie([
                         'table' => 'menus',
                         'foreignkey' => 'menu_id',
                         'isMenu' => TRUE,
                         'language_id' => "1"
                    ]);
                    $this->nestedset->Get('id ASC', 'order ASC');
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

     public function update($id, $request)
     {
          DB::beginTransaction();
          try {
               $menu = $this->menuRepository->findById($id);

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
               $menu = $this->menuRepository->forceDeleteByCondition([
                    ['menu_catalogue_id','=',$id],
               ]);
               $menuCatalogue = $this->menuCatalogueRepository->forceDelete($id);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     public function dragUpdate($menuCatalogueId = 0, $json = [], $parentId = 0)
     {
          if (count($json)) {
               foreach ($json as $key => $value) {
                    $update = [
                         'order' => count($json) - $key,
                         'parentid' => $parentId,
                    ];
                    $menu = $this->menuRepository->update($value['id'], $update);
                    if (isset($value['children'])  && count($value['children'])) {
                         $this->dragUpdate($menuCatalogueId, $value['children'], $value['id']);
                    }
               }
          }
          $this->nestedset = new Nestedsetbie([
               'table' => 'menus',
               'foreignkey' => 'menu_id',
               'isMenu' => TRUE,
               'language_id' => "1"
          ]);
          $this->nestedset->Get('id ASC', 'order ASC');
          $this->nestedset->Recursive(0, $this->nestedset->Set());
          $this->nestedset->Action();
     }


     public function getAndConvertMenu($menu = null, $language = 1): array
     {
          $menuList = $this->menuRepository->findByCondition(
               ['parentid', '=', $menu->id],
               true,
               ['languages' => function ($query) {
                    $query->where('language_id', 1);
               }]
          );
          return $this->covertMenu($menuList);
     }

     public function covertMenu($menuList = null)
     {
          $temp = [];
          $fields = ['name', 'canonical', 'id', 'order'];
          if (count($menuList)) {
               foreach ($menuList as $key => $val) {
                    foreach ($fields as $field) {
                         if ($field == 'name' || $field == 'canonical') {
                              $temp[$field][] = $val->languages->first()->pivot->{$field};
                         } else {
                              $temp[$field][] = $val->{$field};
                         }
                    }
               }
          }
          return $temp;
     }
}
