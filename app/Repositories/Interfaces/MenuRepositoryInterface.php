<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface MenuRepositoryInterface
{
     public function create(array $payload);
     public function findById(int $modelId, array $column = ['*'], array $relation = []);
     public function update(int $id = 0, array $payload = []);
     public function destroy(int $id = 0);
     public function pagination(array $column = ['*'], array $conditions = [], array $join = [], int $perPage = 15);
     public function updateByWhereIn(string $whereInField, array $whereIn = [], array $payload = []);
     public function findByCondition($condition = [], $flag = false, $relation = []);
     public function createTranslatePivot($model, array $payload = []);
     public function  createRelationPivot($model, array $payload = [], string $relation = '');
     public function updateByWhere(array $conditions, array $payload = []);
     public function forceDeleteByCondition(array $conditions = []);
     public function forceDelete(int $id = 0);
}
