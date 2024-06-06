<?php

namespace App\Http\Controllers\Backend;

use App\Models\PostCatalogue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdatePostCatalogueRequest;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;

class PostCatalogueController extends Controller
{
     protected $PostCatalogueService;
     protected $PostCatalogueRepository;
     public function __construct(PostCatalogueService $PostCatalogueService, PostCatalogueRepository $PostCatalogueRepository)
     {
          $this->PostCatalogueService = $PostCatalogueService;
          $this->PostCatalogueRepository = $PostCatalogueRepository;
     }
     public function index(Request $request)
     {
          $postCatalogues = $this->PostCatalogueService->paginate($request);
          $config = [
               'js' => [
                    '/ecommerce/ecommerce/public/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.post.catalogue.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'postCatalogues'));
     }

     public function create()
     {

          $config['method'] = 'create';
          $template = 'backend.post.catalogue.create';
          return view('backend.dashboard.layout', compact('template', 'config'));
     }

     public function store(Request $request)
     {
          if ($this->PostCatalogueService->create($request)) {
               return redirect()->route('Post.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('Post.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $postCatalogue = $this->PostCatalogueRepository->findById($id);

          $config['method'] = 'update';
          $template = 'backend.post.catalogue.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'postCatalogue'));
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
          $postCatalogue = $this->PostCatalogueRepository->findById($id);
          $template = 'backend.post.catalogue.delete';
          return view('backend.dashboard.layout', compact('template', 'postCatalogue'));
     }

     public function destroy($id)
     {
          if ($this->PostCatalogueService->destroy($id)) {
               return redirect()->route('post.catalogue.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('post.catalogue.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
