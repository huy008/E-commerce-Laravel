<?php

namespace App\Repositories;

use App\Models\ProductVariantAttribute;
use App\Repositories\Interfaces\ProductVariantAttributeRepositoryInterface;

/**
 * Class PostService
 * @package App\Services
 */
class ProductVariantAttributeRepository extends BaseRepository implements ProductVariantAttributeRepositoryInterface
{
     protected $model;
     public function __construct(ProductVariantAttribute $model)
     {
          $this->model = $model;
     }
}
