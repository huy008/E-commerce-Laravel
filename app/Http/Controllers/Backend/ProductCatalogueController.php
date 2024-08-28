<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Models\ProductCatalogue;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateProductCatalogueRequest;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;

class ProductCatalogueController extends Controller
{
     protected $productCatalogueService;
     protected $productCatalogueRepository;
     protected $nestedset;
     protected $language;
     public function __construct(ProductCatalogueService $productCatalogueService, ProductCatalogueRepository $productCatalogueRepository)
     {
          $this->productCatalogueService = $productCatalogueService;
          $this->productCatalogueRepository = $productCatalogueRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'product_catalogues',
               'foreignkey' => 'product_catalogue_id',
               'language_id' =>  1,
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {
          $productCatalogues = $this->productCatalogueService->paginate($request);
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.product.catalogue.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'productCatalogues'));
     }


     public function create()
     {
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/plugins/ckeditor/ckeditor.js',
                    'http://127.0.0.1:8000/backend/library/finder.js',
                    'http://127.0.0.1:8000/backend/library/seo.js'
               ]
          ];
          $dropdown = $this->nestedset->dropdown();
          $config['method'] = 'create';
          $template = 'backend.product.catalogue.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
     }

     public function store(Request $request)
     {
          if ($this->productCatalogueService->create($request)) {
               return redirect()->route('product.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('product.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $this->language);
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/plugins/ckeditor/ckeditor.js',
                    'http://127.0.0.1:8000/backend/library/finder.js',
                    'http://127.0.0.1:8000/backend/library/seo.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.product.catalogue.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'productCatalogue', 'dropdown'));
     }

     public function update($id, Request $request)
     {
          if ($this->productCatalogueService->update($id, $request)) {
               return redirect()->route('product.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('product.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $this->language);
          $template = 'backend.product.catalogue.delete';
          return view('backend.dashboard.layout', compact('template', 'productCatalogue'));
     }

     public function destroy(Request $request, $id)
     {

          if ($this->productCatalogueService->destroy($id)) {
               return redirect()->route('product.catalogue.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('product.catalogue.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
