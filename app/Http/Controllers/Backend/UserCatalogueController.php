<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\UserCatalogue;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateUserCatalogueRequest;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Services\Interfaces\UserCatalogueServiceInterface as UserCatalogueService;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface as UserCatalogueRepository;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;
    protected $userCatalogueRepository;
    protected $permissionRepository;
    public function __construct(UserCatalogueService $userCatalogueService, UserCatalogueRepository $userCatalogueRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
        $this->permissionRepository = $permissionRepository;
    }
    public function index(Request $request)
    {
        $userCatalogues = $this->userCatalogueService->paginate($request);
        $config = [
            'js' => [
                '/ecommerce/ecommerce/public/backend//js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $template = 'backend.user.userCatalogue.index';
        return view('backend.dashboard.layout', compact('template', 'config', 'userCatalogues'));
    }

    public function create()
    {

        $config['method'] = 'create';
        $template = 'backend.user.userCatalogue.create';
        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    public function store(Request $request)
    {
        if ($this->userCatalogueService->create($request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $userCatalogue = $this->userCatalogueRepository->findById($id);

        $config['method'] = 'update';
        $template = 'backend.user.userCatalogue.create';
        return view('backend.dashboard.layout', compact('template', 'config', 'userCatalogue'));
    }

    public function update($id, Request $request)
    {
        if ($this->userCatalogueService->update($id, $request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $userCatalogue = $this->userCatalogueRepository->findById($id);
        $template = 'backend.user.userCatalogue.delete';
        return view('backend.dashboard.layout', compact('template', 'userCatalogue'));
    }

    public function destroy($id)
    {
        if ($this->userCatalogueService->destroy($id)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Xoa bản ghi thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
    }

    public function permission(){
        $permission = $this->permissionRepository->all();
        $userCatalogues = $this->userCatalogueRepository->all(['permissions']);
        $template = 'backend.user.userCatalogue.permission';
        return view('backend.dashboard.layout', compact('template', 'permission', 'userCatalogues'));

    }


    public function updatePermission(Request $request)
    {
        if ($this->userCatalogueService->setPermission($request)) {
            return redirect()->route('user.catalogue.index')->with('success', 'Xoa bản ghi thành công');
        }
        return redirect()->route('user.catalogue.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
    }
}