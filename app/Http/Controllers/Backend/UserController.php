<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;
    public function __construct(UserService $userService, ProvinceRepository $provinceRepository, UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        $users = $this->userService->paginate($request);
        $config = [
            'js' => [
                '/ecommerce/ecommerce/public/backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $template = 'backend.user.user.index';
        return view('backend.dashboard.layout', compact('template', 'config', 'users'));
    }

    public function create()
    {

        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                '/ecommerce/ecommerce/public/backend/plugins/ckfinder_2/ckfinder.js',
                '/ecommerce/ecommerce/public/backend/library/finder.js',        '/ecommerce/ecommerce/public/backend/library/location.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $config['method'] = 'create';
        $provinces = $this->provinceRepository->all();
        $template = 'backend.user.user.create';
        return view('backend.dashboard.layout', compact('template', 'provinces', 'config'));
    }

    public function store(StoreRequest $request)
    {
        if ($this->userService->create($request)) {
            return redirect()->route('user.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('user.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',                  '/ecommerce/ecommerce/public/backend/library/location.js',
                '/ecommerce/ecommerce/public/backend/plugins/ckfinder_2/ckfinder.js',
                '/ecommerce/ecommerce/public/backend/library/finder.js'
            ],
            'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
        ];
        $config['method'] = 'update';
        $provinces = $this->provinceRepository->all();
        $template = 'backend.user.user.create';
        return view('backend.dashboard.layout', compact('template', 'provinces', 'config', 'user'));
    }

    public function update($id, UpdateUserRequest $request)
    {
        if ($this->userService->update($id, $request)) {
            return redirect()->route('user.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('user.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $user = $this->userRepository->findById($id);
        $template = 'backend.user.user.delete';
        return view('backend.dashboard.layout', compact('template', 'user'));
    }

    public function destroy($id)
    {
        if ($this->userService->destroy($id)) {
            return redirect()->route('user.index')->with('success', 'Xoa bản ghi thành công');
        }
        return redirect()->route('user.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
    }
}
