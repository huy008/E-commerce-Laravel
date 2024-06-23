<?php

namespace App\Services;

use Exception;

use App\Services\Interfaces\BaseServiceInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface as BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
     public function __construct(BaseRepository $BaseRepository)
     {
     }

     public function currentLanguage(){
          return 1;
     }
}
