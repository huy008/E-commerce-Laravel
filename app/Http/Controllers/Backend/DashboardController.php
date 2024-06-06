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
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.tooltip.min.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.spline.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.resize.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.pie.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.symbol.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/flot/jquery.flot.time.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/peity/jquery.peity.min.js',
            '/ecommerce/ecommerce/public/backend/js/demo/peity-demo.js',
            '/ecommerce/ecommerce/public/backend/js/inspinia.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/pace/pace.min.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/jquery-ui/jquery-ui.min.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
            
            '/ecommerce/ecommerce/public/backend/js/plugins/easypiechart/jquery.easypiechart.js',
            '/ecommerce/ecommerce/public/backend/js/plugins/sparkline/jquery.sparkline.min.js',
            '/ecommerce/ecommerce/public/backend/js/demo/sparkline-demo.js',
         ]
      ];
      $template = 'backend.dashboard.home.index';
      return view('backend.dashboard.layout', compact('template', 'config'));
   }
}
