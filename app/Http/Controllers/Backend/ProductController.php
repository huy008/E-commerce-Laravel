<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;

class ProductController extends Controller
{
     protected $productService;
     protected $productRepository;
     protected $nestedset;
     protected $language;
     protected $attributeCatalogueRepository;
     public function __construct(ProductService $productService, ProductRepository $productRepository, AttributeCatalogueRepository $attributeCatalogueRepository)
     {
          $this->productService = $productService;
          $this->productRepository = $productRepository;
          $this->attributeCatalogueRepository = $attributeCatalogueRepository;
          $this->nestedset = new Nestedsetbie([
                 'table' => 'product_catalogues',
               'foreignkey' => 'product_catalogue_id',
               'language_id' =>  1,
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {
          $products = $this->productService->paginate($request);
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.product.product.index';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'products', 'dropdown'));
     }

     public function create()
     {
          $config = [
               'js' => [
                    'http://127.0.0.1:8000/backend/plugins/ckfinder_2/ckfinder.js',
                    'http://127.0.0.1:8000/backend/plugins/ckeditor/ckeditor.js',
                    'http://127.0.0.1:8000/backend/library/finder.js',
                    'http://127.0.0.1:8000/backend/library/library.js',
                    'http://127.0.0.1:8000/backend/plugins/nice-select/js/jquery.nice-select.min.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                    'http://127.0.0.1:8000/backend/library/variant.js',
                    'http://127.0.0.1:8000/backend/js/plugins/switchery/switchery.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                    'http://127.0.0.1:8000/backend/plugins/nice-select/css/nice-select.css',],
          ];
          $attributeCatalogue = $this->attributeCatalogueRepository->getAll($this->currentLanguage());
          $dropdown = $this->nestedset->dropdown();
          $config['method'] = 'create';
          $template = 'backend.product.product.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown', 'attributeCatalogue'));
     }

     public function store(Request $request)
     {
          if ($this->productService->create($request)) {
               return redirect()->route('product.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('product.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $product = $this->productRepository->getProductById($id, $this->currentLanguage());
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
          $attributeCatalogue = $this->attributeCatalogueRepository->getAll($this->currentLanguage());
          $config['method'] = 'update';
          $template = 'backend.product.product.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'product', 'dropdown', 'attributeCatalogue'));
     }

     public function update($id, Request $request)
     {
          if ($this->productService->update($id, $request)) {
               return redirect()->route('product.product.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('product.product.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $product = $this->productRepository->findById($id);
          $template = 'backend.product.product.delete';
          return view('backend.dashboard.layout', compact('template', 'product'));
     }

     public function destroy(Request $request, $id)
     {

          if ($this->productService->destroy($id)) {
               return redirect()->route('product.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('product.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
