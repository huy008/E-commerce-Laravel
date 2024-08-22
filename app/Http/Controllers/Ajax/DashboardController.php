<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function getMenu(Request $request)
    {
        $model = $request->input('model');

        $repoInterface = '\App\Repositories\\' . ucfirst($model) . 'Repository';
        if (class_exists($repoInterface)) {
            $repoInstance= app($repoInterface);
        }
        $agruments = $this->paginationAgrument($model);
        $object = $repoInstance->pagination(...array_values($agruments));
     
       return response()->json($object);
    }

    private function paginationAgrument(string $model = ''): array
    {
        $model = Str::snake($model);
        $join = [
            [$model . '_language as tb2', 'tb2.' . $model . '_id', '=', $model . 's.id'],
        ];
        if (strpos($model, '_catalogue') === false) {
            $join[] = ['' . $model . '_catalogue_' . $model . ' as tb3', '' . $model . 's.id', '=', 'tb3.'.$model . '_id'];
        }
        return [
            'column' => ['id', 'name','canonical'],
            'condition' => [
                'where' => [
                    ['tb2.language_id', '=', 1],
                ]
            ],
            'join' => $join,
            'perpage' => 3,
            'relations' => [],
            // 'extend' => [
            //     'path' => $model . '.index',
            //     'groupBy' => ['id', 'name']
            // ],
            'orderBy' => [$model . 's.id', 'DESC'],
        ];
    }
}
