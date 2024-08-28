<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
   {
      $config = [
         'js' => [
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.js',
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.tooltip.min.js',
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.spline.js',
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.resize.js',
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.pie.js',
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.symbol.js',
            'http://127.0.0.1:8000/backend/js/plugins/flot/jquery.flot.time.js',
            'http://127.0.0.1:8000/backend/js/plugins/peity/jquery.peity.min.js',
            'http://127.0.0.1:8000/backend/js/demo/peity-demo.js',
            'http://127.0.0.1:8000/backend/js/inspinia.js',
            'http://127.0.0.1:8000/backend/js/plugins/pace/pace.min.js',
            'http://127.0.0.1:8000/backend/js/plugins/jquery-ui/jquery-ui.min.js',
            'http://127.0.0.1:8000/backend/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
            'http://127.0.0.1:8000/backend/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
            
            'http://127.0.0.1:8000/backend/js/plugins/easypiechart/jquery.easypiechart.js',
            'http://127.0.0.1:8000/backend/js/plugins/sparkline/jquery.sparkline.min.js',
            'http://127.0.0.1:8000/backend/js/demo/sparkline-demo.js',
         ]
      ];
      $template = 'backend.dashboard.home.index';
      return view('backend.dashboard.layout', compact('template', 'config'));
   }
}
