<?php

namespace App\Http\Controllers\Backend;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdatePermissionRequest;
use App\Services\Interfaces\PermissionServiceInterface as PermissionService;
use App\Repositories\Interfaces\PermissionRepositoryInterface as PermissionRepository;

class PermissionController extends Controller
{
     protected $PermissionService;
     protected $PermissionRepository;
     public function __construct(PermissionService $PermissionService, PermissionRepository $PermissionRepository)
     {
          $this->PermissionService = $PermissionService;
          $this->PermissionRepository = $PermissionRepository;
     }
     public function index(Request $request)
     {
          $Permissions = $this->PermissionService->paginate($request);
          $config = [
               'js' => [
                    '/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.permission.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'Permissions'));
     }

     public function create()
     {

          $config = [
               'js' => [
                    '/backend/plugins/ckfinder_2/ckfinder.js',
                    '/backend/library/finder.js'
               ]
          ];
          $config['method'] = 'create';
          $template = 'backend.permission.create';
          return view('backend.dashboard.layout', compact('template', 'config'));
     }

     public function store(Request $request)
     {
          if ($this->PermissionService->create($request)) {
               return redirect()->route('Permission.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('Permission.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $Permission = $this->PermissionRepository->findById($id);
          $config = [
               'js' => [
                    '/backend/plugins/ckfinder_2/ckfinder.js',
                    '/backend/library/finder.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.permission.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'Permission'));
     }

     public function update($id, Request $request)
     {
          if ($this->PermissionService->update($id, $request)) {
               return redirect()->route('Permission.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('Permission.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $Permission = $this->PermissionRepository->findById($id);
          $template = 'backend.permission.delete';
          return view('backend.dashboard.layout', compact('template', 'Permission'));
     }

     public function destroy($id)
     {
          if ($this->PermissionService->destroy($id)) {
               return redirect()->route('Permission.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('Permission.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
