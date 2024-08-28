<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;

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
     public function updateOrInsert(array $payload = [], array $conditions = [])
     {
          return $this->model->updateOrInsert($conditions, $payload);
     }

     public function findByCondition($condition = [], $flag = false, $relation = [])
     {
          $query = $this->model->newQuery();
          $query->where($condition[0], $condition[1], $condition[2]);
          $query->with($relation);
          return ($flag == false) ? $query->first() : $query->get();
     }

     public function update(int $id = 0, array $payload = [])
     {
          $model = $this->findById($id);
          $model->fill($payload);
          $model->save();
         
          return $model;
     }

     public function destroy(int $id = 0)
     {
          return $this->findById($id)->delete();
     }

     public function forceDelete(int $id = 0)
     {
          return $this->findById($id)->forceDelete();
     }
     public function forceDeleteByCondition(array $conditions=[])
     {
          $query = $this->model->newQuery();
          foreach ($conditions as $key => $value) {
               $query->where($value[0], $value[1], $value[2]);
          }
          return $query->forceDelete();
     }

     public function updateByWhereIn(string $whereInField, array $whereIn = [], array $payload = [])
     {
          return $this->model->whereIn($whereInField, $whereIn)->update($payload);
     }
     public function updateByWhere(array $conditions, array $payload = [])
     {
          $query = $this->model->newQuery();
          foreach ($conditions as $key => $value) {
               $query->where($value[0],$value[1],$value[2]);
          }
          return $query->update($payload);
     }

     public function createTranslatePivot($model, array $payload = [])
     {
          return $model->languages()->attach($model->id, $payload);
     }

     public function  createRelationPivot($model, array $payload = [], string $relation = '')
     {
          return $model->{$relation}()->attach($model->id, $payload);
     }
}
