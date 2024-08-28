<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

/**
 * Class PostService
 * @package App\Services
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
     protected $model;
     public function __construct(Product $model)
     {
          $this->model = $model;
     }

     public function getProductById(int $id = 0, $language_id = 0)
     {
          return $this->model->select([
               'products.id',
               //  'products.parentid',
                'products.image',
               'products.album',
               'products.publish',
               'products.follow',
               'tb2.name',
               'tb2.description', 'tb2.content',
               'tb2.meta_title',
               'tb2.meta_description',
               'tb2.meta_keyword'
          ])
               ->join('product_language as tb2', 'tb2.product_id', '=', 'products.id')
               ->where('tb2.language_id', '=', $language_id)
               ->findOrFail($id);
     }
}
