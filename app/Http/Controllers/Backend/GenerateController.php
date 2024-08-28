<?php

namespace App\Http\Controllers\Backend;

use App\Models\Generate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateGenerateRequest;
use App\Services\Interfaces\GenerateServiceInterface as GenerateService;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;

class GenerateController extends Controller
{
     protected $GenerateService;
     protected $GenerateRepository;
     public function __construct(GenerateService $GenerateService, GenerateRepository $GenerateRepository)
     {
          $this->GenerateService = $GenerateService;
          $this->GenerateRepository = $GenerateRepository;
     }
     public function index(Request $request)
     {
          $generates = $this->GenerateService->paginate($request);
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.generate.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'generates'));
     }

     public function create()
     {

          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/library/finder.js'
               ]
          ];
          $config['method'] = 'create';
          $template = 'backend.generate.create';
          return view('backend.dashboard.layout', compact('template', 'config'));
     }

     public function store(Request $request)
     {
          if ($this->GenerateService->create($request)) {
               return redirect()->route('generate.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('generate.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $generate = $this->GenerateRepository->findById($id);
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/library/finder.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.generate.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'generate'));
     }

     public function update($id, Request $request)
     {
          if ($this->GenerateService->update($id, $request)) {
               return redirect()->route('generate.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('generate.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $Generate = $this->GenerateRepository->findById($id);
          $template = 'backend.generate.delete';
          return view('backend.dashboard.layout', compact('template', 'Generate'));
     }

     public function destroy($id)
     {
          if ($this->GenerateService->destroy($id)) {
               return redirect()->route('generate.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('generate.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
