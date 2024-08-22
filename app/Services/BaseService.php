<?php

namespace App\Services;

use Exception;

use Illuminate\Support\Facades\DB;
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

     public function updateStatus($post = [])
     {
          DB::beginTransaction();
          try {
               $model = lcfirst($post['model']).'Repository';
               $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);
               $Post = $this->{$model}->update($post['modelId'], $payload);
               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }
}
