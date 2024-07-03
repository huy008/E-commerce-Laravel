<?php

namespace App\Http\Controllers\Backend;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateLanguageRequest;
use App\Services\Interfaces\LanguageServiceInterface as LanguageService;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;

class LanguageController extends Controller
{
     protected $LanguageService;
     protected $LanguageRepository;
     public function __construct(LanguageService $LanguageService, LanguageRepository $LanguageRepository)
     {
          $this->LanguageService = $LanguageService;
          $this->LanguageRepository = $LanguageRepository;
     }
     public function index(Request $request)
     {
          $languages = $this->LanguageService->paginate($request);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.language.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'languages'));
     }

     public function create()
     {

          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//plugins/ckfinder_2/ckfinder.js',
                    '/ecommerce/ecommerce/public/backend//library/finder.js'
               ]
          ];
          $config['method'] = 'create';
          $template = 'backend.language.create';
          return view('backend.dashboard.layout', compact('template', 'config'));
     }

     public function store(Request $request)
     {
          if ($this->LanguageService->create($request)) {
               return redirect()->route('language.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('language.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $language = $this->LanguageRepository->findById($id);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//plugins/ckfinder_2/ckfinder.js',
                    '/ecommerce/ecommerce/public/backend//library/finder.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.language.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'language'));
     }

     public function update($id, Request $request)
     {
          if ($this->LanguageService->update($id, $request)) {
               return redirect()->route('language.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('language.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $language = $this->LanguageRepository->findById($id);
          $template = 'backend.language.delete';
          return view('backend.dashboard.layout', compact('template', 'language'));
     }

     public function destroy($id)
     {
          if ($this->LanguageService->destroy($id)) {
               return redirect()->route('language.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('language.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
