<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Arr;

/**
 * Class UserService
 * @package App\Services
 */
class BaseRepository implements BaseRepositoryInterface
{
     protected $model;
     public function __construct(Model $model)
     {
          $this->model = $model;
     }

     public function pagination(
          array $column = ['*'],
          array $condition = [],
          array $join = [],
          int $perPage = 1,
          array $relations = [],
          array $orderBy = [],
          array $rawQuery = [],
     ) {
          $query = $this->model->select($column)->where(function ($query) use ($condition) {
               if (isset($condition['keyword']) && !empty($condition['keyword']))
                    $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
          });

          if (isset($rawQuery['whereRaw']) && count($rawQuery['whereRaw'])) {
               foreach ($rawQuery['whereRaw'] as $key => $val) {
                    $query->whereRaw($val[0], $val[1]);
               }
          }
          if (isset($join) && is_array($join) && count($join)) {
               foreach ($join as $key => $val) {
                    $query->join($val[0], $val[1], $val[2], $val[3]);
               }
          }

          if (isset($relations) && !empty($relations)) {
               foreach ($relations as $relation) {
                    $query->withCount($relation);
                    $query->with($relation);
               }
          }


          if (isset($orderBy) && is_array($orderBy) && count($orderBy)) {
               $query->orderBy($orderBy[0], $orderBy[1]);
          }
          return $query->paginate($perPage)
               ->withQueryString()
               ->withPath('http://localhost/ecommerce/ecommerce/public/language/index');
     }

     public function create(array $payload = [])
     {

          return  $this->model->create($payload);
     }
     public function createBath(array $payload = [])
     {
          return  $this->model->insert($payload);
     }

     public function all(array $relations = [])
     {
          return $this->model->with($relations)->get();
     }

     public function findById(int $modelId, array $column = ['*'], array $relation = [])
     {
          return $this->model->select($column)->with($relation)->findOrFail($modelId);
     }

     public function findByCondition( $condition=[])
     {
          $query=$this->model->newQuery();
         foreach ($condition as $key => $value){
               $query->where($value[0],$value[1],$value[2]);
         }
         return $query->first();
     }

     public function update(int $id = 0, array $payload = [])
     {
          $model = $this->findById($id);
          return $model->update($payload);
     }

     public function destroy(int $id = 0)
     {
          return $this->findById($id)->delete();
     }

     public function updateByWhereIn(string $whereInField, array $whereIn = [], array $payload = [])
     {
          return $this->model->whereIn($whereInField, $whereIn)->update($payload);
     }

     public function createTranslatePivot($model, array $payload = [])
     {
          return $model->languages()->attach($model->id, $payload);
     }

     public function  createRelationPivot($model, array $payload = [], string $relation = '')
     {
          return $model->post_catalogues()->attach($model->id, $payload);
     }
}
