<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface BaseRepositoryInterface
{
      public function all(array $relations = []);
     public function findById(int $modelId, array $column,  array $relation );
     public function update(int $id = 0, array $payload = []);
     public function destroy(int $id = 0);
      public function pagination(array $column = ['*'] , array $conditions = [] ,array $join = [] ,int $perPage = 15, array $relations = [],  array $orderBy = [],array $rawQuery = []);
      public function updateByWhereIn(string $whereInField, array $whereIn = [], array $payload = []);
      public function createTranslatePivot($model ,array $payload = []);
      public function  createRelationPivot($model, array $payload = [], string $relation = '');
      public function findByCondition($condition = []);
      public function createBath(array $payload = []);
      public function updateOrInsert(array $payload = [], array $conditions = []);
}