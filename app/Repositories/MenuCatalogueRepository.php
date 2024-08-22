<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\MenuCatalogue;
use App\Repositories\Interfaces\MenuCatalogueRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class MenuCatalogueRepository extends BaseRepository implements MenuCatalogueRepositoryInterface
{
     protected $model;
     public function __construct(MenuCatalogue $model)
     {
          $this->model = $model;
     }
}
