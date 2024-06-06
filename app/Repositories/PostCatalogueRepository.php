<?php

namespace App\Repositories;

use App\Models\PostCatalogue;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface;

/**
 * Class PostService
 * @package App\Services
 */
class PostCatalogueRepository extends BaseRepository implements PostCatalogueRepositoryInterface
{
     protected $model;
     public function __construct(PostCatalogue $model)
     {
          $this->model = $model;
     }
}
