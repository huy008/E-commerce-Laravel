<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface PostCatalogueRepositoryInterface
{
     public function create(array $payload);
     public function findById(int $modelId, array $column = ['*'], array $relation = []);
     public function update(int $id = 0, array $payload = []);
     public function destroy(int $id = 0);
     public function pagination(array $column = ['*'], array $conditions = [], array $join = [], int $perPage = 15);
     public function updateByWhereIn(string $whereInField, array $whereIn = [], array $payload = []);
     public function createTranslatePivot($model, array $payload = []);
     public function getPostCatalogueById(int $id = 0, $language_id = 0);
}
