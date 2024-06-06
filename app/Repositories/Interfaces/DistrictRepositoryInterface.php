<?php

namespace App\Repositories\Interfaces;

/**
 * Interface UserServiceInterface
 * @package App\Services\Interfaces
 */
interface DistrictRepositoryInterface
{
     public function all();
     public function findByCondition(int $province_id);
     public function findById(int $modelId, array $column, array $relation);
}
