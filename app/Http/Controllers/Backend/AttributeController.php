<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Models\Attribute;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAttributeRequest;
use App\Services\Interfaces\AttributeServiceInterface as AttributeService;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeRepository;

class AttributeController extends Controller
{
     protected $attributeService;
     protected $attributeRepository;
     protected $nestedset;
     protected $language;
     public function __construct(AttributeService $attributeService, AttributeRepository $attributeRepository)
     {
          $this->attributeService = $attributeService;
          $this->attributeRepository = $attributeRepository;
          $this->nestedset = new Nestedsetbie([
                 'table' => 'attribute_catalogues',
               'foreignkey' => 'attribute_catalogue_id',
               'language_id' =>  1,
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {
          $attributes = $this->attributeService->paginate($request);
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.attribute.attribute.index';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'attributes', 'dropdown'));
     }

     public function create()
     {
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/plugins/ckeditor/ckeditor.js',
                    'http://127.0.0.1:8000/backend/library/finder.js',
                    'http://127.0.0.1:8000/backend/library/seo.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $dropdown = $this->nestedset->dropdown();
          $config['method'] = 'create';
          $template = 'backend.attribute.attribute.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
     }

     public function store(Request $request)
     {
          if ($this->attributeService->create($request)) {
               return redirect()->route('attribute.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('attribute.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $attribute = $this->attributeRepository->getattributeById($id, $this->currentLanguage());
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/plugins/ckeditor/ckeditor.js',
                    'http://127.0.0.1:8000/backend/library/finder.js',
                    'http://127.0.0.1:8000/backend/library/seo.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $config['method'] = 'update';
          $template = 'backend.attribute.attribute.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'attribute', 'dropdown'));
     }

     public function update($id, Request $request)
     {
          if ($this->attributeService->update($id, $request)) {
               return redirect()->route('attribute.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('attribute.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $attribute = $this->attributeRepository->findById($id);
          $template = 'backend.attribute.attribute.delete';
          return view('backend.dashboard.layout', compact('template', 'attribute'));
     }

     public function destroy(Request $request, $id)
     {

          if ($this->attributeService->destroy($id)) {
               return redirect()->route('attribute.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('attribute.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
