<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Services\MenuService;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MenuRepositoryInterface as MenuRepository;
use App\Services\Interfaces\MenuCatalogueServiceInterface as MenuCatalogueService;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface as MenuCatalogueRepository;

class MenuController extends Controller
{
    protected $menuService;
    protected $menuRepository;
    protected $menuCatalogueRepository;
    protected $menuCatalogueService;
    public function __construct(MenuCatalogueService $menuCatalogueService, MenuService $menuService, MenuRepository $menuRepository, MenuCatalogueRepository $menuCatalogueRepository)
    {
        $this->menuService = $menuService;
        $this->menuRepository = $menuRepository;
        $this->menuCatalogueRepository = $menuCatalogueRepository;
        $this->menuCatalogueService = $menuCatalogueService;
    }
    public function index(Request $request)
    {
        $menuCatalogues = $this->menuCatalogueService->paginate($request);
        $config = [
            'js' => [
                'http://127.0.0.1:8000/backend//js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $template = 'backend.menu.menu.index';
        return view('backend.dashboard.layout', compact('template', 'config', 'menuCatalogues'));
    }

    public function create()
    {

        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'http://127.0.0.1:8000/backend//plugins/ckfinder_2/ckfinder.js',
                'http://127.0.0.1:8000/backend//library/finder.js',
                'http://127.0.0.1:8000/backend//library/menu.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $config['method'] = 'create';
        $menuCatalogues = $this->menuCatalogueRepository->all();
        $template = 'backend.menu.menu.create';
        return view('backend.dashboard.layout', compact('template', 'config', 'menuCatalogues'));
    }


    public function store(Request $request)
    {
        if ($this->menuService->create($request)) {
            return redirect()->route('menu.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function children($id)
    {
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'http://127.0.0.1:8000/backend//plugins/ckfinder_2/ckfinder.js',
                'http://127.0.0.1:8000/backend//library/finder.js',
                'http://127.0.0.1:8000/backend//library/menu.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $config['method'] = 'create';
        $menu = $this->menuRepository->findById(
            $id,
            ['*'],
            ['languages' => function ($query) {
                $query->where('language_id', 1);
            }]
        );

        $menuList = $this->menuService->getAndConvertMenu($menu);
        $template = 'backend.menu.menu.children';
        return view('backend.dashboard.layout', compact('template', 'config', 'menuList', 'menu'));
    }


    public function saveChildren(Request $request, $id)
    {
        $menu = $this->menuRepository->findById($id);
        if ($this->menuService->saveChildren($request, $menu)) {
            return redirect()->route('menu.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $menus = $this->menuRepository->findByCondition(['menu_catalogue_id', '=', $id], TRUE, ['languages' => function ($query) {
            $query->where('language_id', 1);
        }]);

        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'http://127.0.0.1:8000/backend/js/plugins/nestable/jquery.nestable.js',
                'http://127.0.0.1:8000/backend//library/menu.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $config['method'] = 'create';
        $template = 'backend.menu.menu.show';
        return view('backend.dashboard.layout', compact('template', 'config', 'menus', 'id'));
    }

    public function editMenu($id)
    {
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'http://127.0.0.1:8000/backend//plugins/ckfinder_2/ckfinder.js',
                'http://127.0.0.1:8000/backend//library/finder.js',
                'http://127.0.0.1:8000/backend//library/menu.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $menus = $this->menuRepository->findByCondition(['menu_catalogue_id', '=', $id], TRUE, ['languages' => function ($query) {
            $query->where('language_id', 1);
        }]);
        $menuList = $this->menuService->covertMenu($menus);
        $menuCatalogues = $this->menuCatalogueRepository->all();
        $menuCatalogue = $this->menuCatalogueRepository->findById($id);
        $config['method'] = 'create';
        $template = 'backend.menu.menu.create';
        return view('backend.dashboard.layout', compact('template', 'config', 'menuList', 'menuCatalogues', 'menuCatalogue', 'id'));
    }
    public function delete($id)
    {
        $menuCatalogue = $this->menuCatalogueRepository->findById($id);
        $template = 'backend.menu.menu.delete';
        return view('backend.dashboard.layout', compact('template', 'menuCatalogue'));
    }

    public function destroy($id)
    {
        if ($this->menuService->destroy($id)) {
            return redirect()->route('menu.index')->with('success', 'Xoa bản ghi thành công');
        }
        return redirect()->route('menu.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
    }
}
