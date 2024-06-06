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
          int $perPage = 10,
          array $relations = []
     ) {
          $query = $this->model->select($column)->where(function ($query) use ($condition) {
               if (isset($condition['keyword']) && !empty($condition['keyword']))
                    $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
          });

          if(isset($relations) && !empty($relations)){
               foreach($relations as $relation)
                    $query->withCount($relation);
          }
          
          if (!empty($join)) $query->join(...$join);
          return $query->paginate($perPage)
               ->withQueryString()
               ->withPath('http://localhost/ecommerce/ecommerce/public/language/index');
     }

     public function create(array $payload = [])
     {
          $model = $this->model->create($payload);
     }

     public function all()
     {
          return $this->model->all();
     }

     public function findById(int $modelId, array $column = ['*'], array $relation = [])
     {
          return $this->model->select($column)->with($relation)->findOrFail($modelId);
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
}