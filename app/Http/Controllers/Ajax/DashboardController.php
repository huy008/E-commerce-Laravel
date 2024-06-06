<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function changeStatus(Request $request)
    {
        $post = $request->input();
        $serviceInterface = '\App\Services\\' . ucfirst($post['model']) . 'Service';
        if (class_exists($serviceInterface)) {
            $serviceInstance = app($serviceInterface);
        }
        $flag = $serviceInstance->updateStatus($post);

        return response()->json(['flag' => $flag]);
    }

    public function changeStatusAll(Request $request)
    {
        $post = $request->input();
        $serviceInterface = '\App\Services\\' . ucfirst($post['model']) . 'Service';
        if (class_exists($serviceInterface)) {
            $serviceInstance = app($serviceInterface);
        }
        $flag = $serviceInstance->updateStatusAll($post);

        return response()->json(['flag' => $flag]);
    }
}