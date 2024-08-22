<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\MenuCatalogueServiceInterface;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;

/**
 * Class MenuCatalogueService
 * @package App\Services
 */
class MenuCatalogueService extends BaseService implements MenuCatalogueServiceInterface
{
     protected $menuCatalogueRepository;

     public function __construct(MenuCatalogueRepository $menuCatalogueRepository)
     {
          $this->menuCatalogueRepository = $menuCatalogueRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $menuCatalogue =
               $this->menuCatalogueRepository->pagination(['id', 'keyword','publish', 'name'], $condition, [], $perPage, []);
          return $menuCatalogue;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {
             
              $payload = $request->only(['name','keyword']);
              $menuCatalogue = $this->menuCatalogueRepository->create($payload);
               DB::commit();
               return [
                    'name' => $menuCatalogue->name,
                    'id' =>$menuCatalogue->id,
               ];
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
               $menu = $this->menuCatalogueRepository->findById($id);
            
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
               $menu = $this->menuCatalogueRepository->destroy($id);

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
