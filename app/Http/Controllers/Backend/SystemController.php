<?php

namespace App\Http\Controllers\Backend;

use App\classes\System;
use App\Models\Generate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateGenerateRequest;
use App\Services\Interfaces\SystemServiceInterface as SystemService;
use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;

class SystemController extends Controller
{
     protected $systemLibrary;
     protected $systemService;
     protected $systemRepository;
     protected $languageId;
     public function __construct(System $systemLibrary, SystemService $systemService,SystemRepository $systemRepository)
     {
          $this->systemLibrary = $systemLibrary;
          $this->systemService = $systemService;
          $this->languageId = 1;
          $this->systemRepository = $systemRepository;
     }
     public function index(Request $request)
     {
         $systemConfig = $this->systemLibrary->config();
         $systems =convert_array($this->systemRepository->all(),'keyword','content');
          $config = [
               'js' =>[
                    'http://127.0.0.1:8000/backend/plugins/ckeditor/ckeditor.js',
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/library/finder.js'
               ]
          ];
          $template = 'backend.system.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'systemConfig', 'systems'));
     }

     public function store(Request $request)
     {
          if ($this->systemService->save($request,$this->languageId)) {
               return redirect()->route('system.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('system.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }
}
