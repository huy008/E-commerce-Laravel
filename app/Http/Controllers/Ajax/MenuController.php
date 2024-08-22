<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;
use App\Services\Interfaces\MenuCatalogueServiceInterface as MenuCatalogueService;
use App\Services\Interfaces\MenuServiceInterface as MenuService;

class MenuController extends Controller
{
     protected $menuCatalogueRepository;
     protected $menuCatalogueService;
     protected $menuService;

     public function __construct(
          MenuCatalogueRepository $menuCatalogueRepository,
          MenuCatalogueService $menuCatalogueService,
          MenuService $menuService
     ) {
          $this->menuCatalogueRepository = $menuCatalogueRepository;
          $this->menuCatalogueService = $menuCatalogueService;
          $this->menuService = $menuService;
     }
     public function createCatalogue(Request $request)
     {
          if ($this->menuCatalogueService->create($request)) {
               return response()->json([
                    'code' => 0,
                    'message' => 'Tạo nhóm menu thành công!'
               ]);
          }
          return response()->json([
               'message' => 'Có vấn đề xảy ra, hãy thử lại',
               'code' => 1
          ]);
     }
     public function drag(Request $request)
     {
         $json = json_decode($request->string('json'),true);
         $menuCatalogueId =$request->string('menu_catalogue_id');
         $flag = $this->menuService->dragUpdate($menuCatalogueId,$json);
     }
}
