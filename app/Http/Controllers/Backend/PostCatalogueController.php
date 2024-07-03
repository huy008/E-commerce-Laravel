<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Models\PostCatalogue;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;

class PostCatalogueController extends Controller
{
     protected $PostCatalogueService;
     protected $PostCatalogueRepository;
     protected $nestedset;
     protected $language;
     public function __construct(PostCatalogueService $PostCatalogueService, PostCatalogueRepository $PostCatalogueRepository)
     {
          $this->PostCatalogueService = $PostCatalogueService;
          $this->PostCatalogueRepository = $PostCatalogueRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'post_catalogues',
               'foreignkey' => 'post_catalogue_id',
               'language_id' =>  1,
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {    
          $postCatalogues = $this->PostCatalogueService->paginate($request);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.post.catalogue.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'postCatalogues'));
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
          $template = 'backend.post.catalogue.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
     }

     public function store(Request $request)
     {
          if ($this->PostCatalogueService->create($request)) {
               return redirect()->route('post.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('post.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $postCatalogue = $this->PostCatalogueRepository->getPostCatalogueById($id, $this->language);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend//plugins/ckfinder_2/ckfinder.js',
                    '/ecommerce/ecommerce/public/backend//plugins/ckeditor/ckeditor.js',
                    '/ecommerce/ecommerce/public/backend//library/finder.js',
                    '/ecommerce/ecommerce/public/backend//library/seo.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.post.catalogue.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'postCatalogue', 'dropdown'));
     }

     public function update($id, Request $request)
     {
          if ($this->PostCatalogueService->update($id, $request)) {
               return redirect()->route('post.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('post.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $postCatalogue = $this->PostCatalogueRepository->getPostCatalogueById($id, $this->language);
          $template = 'backend.post.catalogue.delete';
          return view('backend.dashboard.layout', compact('template', 'postCatalogue'));
     }

     public function destroy(DeletePostCatalogueRequest $request, $id)
     {

          if ($this->PostCatalogueService->destroy($id)) {
               return redirect()->route('post.catalogue.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('post.catalogue.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
