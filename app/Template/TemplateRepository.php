<?php

namespace App\Repositories;

use App\Models\{Module};
use App\Repositories\Interfaces\{Module}RepositoryInterface;

/**
 * Class PostService
 * @package App\Services
 */
class {Module}Repository extends BaseRepository implements {Module}RepositoryInterface
{
     protected $model;
     public function __construct({Module} $model)
     {
          $this->model = $model;
     }

     public function get{Module}ById(int $id = 0, $language_id = 0)
     {
          return $this->model->select([
               '{tableName}.id',
               //  '{tableName}.parentid',
                '{tableName}.image',
               '{tableName}.icon',
               '{tableName}.album',
               '{tableName}.publish',
               '{tableName}.follow',
               'tb2.name',
               'tb2.description', 'tb2.content',
               'tb2.meta_title',
               'tb2.meta_description',
               'tb2.meta_keyword'
          ])
               ->join('{pivotTableName} as tb2', 'tb2.{foreignKey}', '=', '{tableName}.id')
               ->where('tb2.language_id', '=', $language_id)
               ->findOrFail($id);
     }
}
