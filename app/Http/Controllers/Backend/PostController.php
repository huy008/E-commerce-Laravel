<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Models\Post;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdatePostRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostRequest;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;

class PostController extends Controller
{
     protected $PostService;
     protected $PostRepository;
     protected $nestedset;
     protected $language;
     public function __construct(PostService $PostService, PostRepository $PostRepository)
     {
          $this->PostService = $PostService;
          $this->PostRepository = $PostRepository;
          $this->nestedset = new Nestedsetbie([
               'table' => 'post_catalogues',
               'foreignkey' => 'post_catalogue_id',
               'language_id' =>  1,
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {
          $posts = $this->PostService->paginate($request);
          $config = [
               'js' => [
                    '/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.post.post.index';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'posts', 'dropdown'));
     }

     public function create()
     {
          $config = [
               'js' => [
                    '/backend/plugins/ckfinder_2/ckfinder.js',
                    '/backend/plugins/ckeditor/ckeditor.js',
                    '/backend/library/finder.js',
                    '/backend/library/seo.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $dropdown = $this->nestedset->dropdown();
          $config['method'] = 'create';
          $template = 'backend.post.post.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
     }

     public function store(Request $request)
     {
          if ($this->PostService->create($request)) {
               return redirect()->route('post.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('post.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          $post = $this->PostRepository->getPostById($id,$this->currentLanguage());
          $config = [
               'js' => [
                    '/backend/plugins/ckfinder_2/ckfinder.js',
                    '/backend/plugins/ckeditor/ckeditor.js',
                    '/backend/library/finder.js',
                    '/backend/library/seo.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $config['method'] = 'update';
          $template = 'backend.post.post.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', 'post', 'dropdown'));
     }

     public function update($id, Request $request)
     {
          if ($this->PostService->update($id, $request)) {
               return redirect()->route('post.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('post.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          $post = $this->PostRepository->findById($id);
          $template = 'backend.post.post.delete';
          return view('backend.dashboard.layout', compact('template', 'post'));
     }

     public function destroy(Request $request, $id)
     {

          if ($this->PostService->destroy($id)) {
               return redirect()->route('post.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('post.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
