<?php

namespace App\Http\Controllers\Backend;

use App\classes\System;
use App\Models\Generate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreRequest;
// use App\Http\Requests\UpdateGenerateRequest;


class SystemController extends Controller
{
     protected $systemLibrary;
     public function __construct(System $systemLibrary)
     {
          $this->systemLibrary = $systemLibrary;
     }
     public function index(Request $request)
     {
         $system = $this->systemLibrary->config();
          $config = [
          ];
          $template = 'backend.system.index';
          return view('backend.dashboard.layout', compact('template', 'config', 'system'));
     }

   
}
