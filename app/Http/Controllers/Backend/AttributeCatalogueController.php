<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Models\AttributeCatalogue;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateAttributeCatalogueRequest;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\AttributeCatalogueServiceInterface as AttributeCatalogueService;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;

class AttributeCatalogueController extends Controller
{
     protected $attributeCatalogueService;
     protected $attributeCatalogueRepository;
     protected $nestedset;
     protected $language;
     public function __construct(AttributeCatalogueService $attributeCatalogueService, AttributeCatalogueRepository $attributeCatalogueRepository)
     {
          $this->attributeCatalogueService = $attributeCatalogueService;
          $this->attributeCatalogueRepository = $attributeCatalogueRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'attribute_catalogues',
               'foreignkey' => 'attribute_catalogue_id',
          'language_id' =>  1
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {
          $attributeCatalogues = $this->attributeCatalogueService->paginate($request);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.attribute.catalogue.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'attributeCatalogues'));
     }

     public function create()
     {
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//plugins/ckfinder_2/ckfinder.js',
                    '/ecommerce/ecommerce/public/backend//plugins/ckeditor/ckeditor.js',
                    '/ecommerce/ecommerce/public/backend//library/finder.js',
                    '/ecommerce/ecommerce/public/backend//library/seo.js'
               ]
          ];
          $dropdown = $this->nestedset->dropdown();
          $config['method'] = 'create';
          $template = 'backend.attribute.catalogue.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
     }

     public function store(Request $request)
     {
          if ($this->attributeCatalogueService->create($request)) {
               return redirect()->route('attribute.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('attribute.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $attributeCatalogue = $this->attributeCatalogueRepository->getAttributeCatalogueById($id, $this->language);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//plugins/ckfinder_2/ckfinder.js',
                    '/ecommerce/ecommerce/public/backend//plugins/ckeditor/ckeditor.js',
                    '/ecommerce/ecommerce/public/backend//library/finder.js',
                    '/ecommerce/ecommerce/public/backend//library/seo.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.attribute.catalogue.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'attributeCatalogue', 'dropdown'));
     }

     public function update($id, Request $request)
     {
          if ($this->attributeCatalogueService->update($id, $request)) {
               return redirect()->route('attribute.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('attribute.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $attributeCatalogue = $this->attributeCatalogueRepository->getAttributeCatalogueById($id, $this->language);
          $template = 'backend.attribute.catalogue.delete';
          return view('backend.dashboard.layout', compact('template', 'attributeCatalogue'));
     }

     public function destroy(Request $request, $id)
     {

          if ($this->attributeCatalogueService->destroy($id)) {
               return redirect()->route('attribute.catalogue.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('attribute.catalogue.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
