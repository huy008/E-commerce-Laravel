<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Models\{ModuleTemplate};
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\Update{ModuleTemplate}Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\{ModuleTemplate}ServiceInterface as {ModuleTemplate}Service;
use App\Repositories\Interfaces\{ModuleTemplate}RepositoryInterface as {ModuleTemplate}Repository;

class {ModuleTemplate}Controller extends Controller
{
     protected ${moduleTemplate}Service;
     protected ${moduleTemplate}Repository;
     protected $nestedset;
     protected $language;
     public function __construct({ModuleTemplate}Service ${moduleTemplate}Service, {ModuleTemplate}Repository ${moduleTemplate}Repository)
     {
          $this->{moduleTemplate}Service = ${moduleTemplate}Service;
          $this->{moduleTemplate}Repository = ${moduleTemplate}Repository;
          $this->nestedset = new Nestedsetbie([
               'table' => '{tableName}',
               'foreignkey' => '{foreignKey}',
               'language_id' =>  1,
          ]);
          $this->language = $this->currentLanguage();
     }
     public function index(Request $request)
     {
          ${moduleTemplate}s = $this->{moduleTemplate}Service->paginate($request);
          $config = [
               'js' => [
                    '/backend/js/plugins/switchery/switchery.js',
                    'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
               ],
               'css' => ['https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'],
          ];
          $template = 'backend.{moduleView}.index';
          return view('backend.dashboard.layout', compact('template', 'config', '{moduleTemplate}s'));
     }

     public function create()
     {
          $config = [
               'js' => [
                    '/backend/plugins/ckfinder_2/ckfinder.js',
                    '/backend/plugins/ckeditor/ckeditor.js',
                    '/backend/library/finder.js',
                    '/backend/library/seo.js'
               ]
          ];
          $dropdown = $this->nestedset->dropdown();
          $config['method'] = 'create';
          $template = 'backend.{moduleView}.create';
          return view('backend.dashboard.layout', compact('template', 'config', 'dropdown'));
     }

     public function store(Request $request)
     {
          if ($this->{moduleTemplate}Service->create($request)) {
               return redirect()->route('{moduleView}.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('{moduleView}.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function edit($id)
     {
          ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, $this->language);
          $config = [
               'js' => [
                    '/backend/plugins/ckfinder_2/ckfinder.js',
                    '/backend/plugins/ckeditor/ckeditor.js',
                    '/backend/library/finder.js',
                    '/backend/library/seo.js'
               ]
          ];
          $config['method'] = 'update';
          $template = 'backend.{moduleView}.create';
          $dropdown = $this->nestedset->dropdown();
          return view('backend.dashboard.layout', compact('template', 'config', '{moduleTemplate}', 'dropdown'));
     }

     public function update($id, Request $request)
     {
          if ($this->{moduleTemplate}Service->update($id, $request)) {
               return redirect()->route('{moduleView}.index')->with('success', 'Thêm mới bản ghi thành công');
          }
          return redirect()->route('{moduleView}.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
     }

     public function delete($id)
     {
          ${moduleTemplate} = $this->{moduleTemplate}Repository->get{ModuleTemplate}ById($id, $this->language);
          $template = 'backend.{moduleView}.delete';
          return view('backend.dashboard.layout', compact('template', '{moduleTemplate}'));
     }

     public function destroy(Request $request, $id)
     {

          if ($this->{moduleTemplate}Service->destroy($id)) {
               return redirect()->route('{moduleView}.index')->with('success', 'Xoa bản ghi thành công');
          }
          return redirect()->route('{moduleView}.index')->with('error', 'Xoa bản ghi không thành công. Hãy thử lại');
     }
}
