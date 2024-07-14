<?php

namespace App\Services;

use Exception;
use App\Models\System;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\SystemServiceInterface;
use App\Repositories\Interfaces\SystemRepositoryInterface as SystemRepository;

/**
 * Class SystemService
 * @package App\Services
 */
class SystemService implements SystemServiceInterface
{
     protected $systemRepository;
     public function __construct(SystemRepository $systemRepository)
     {
          $this->systemRepository = $systemRepository;
     }


     public function save($request,$languageId)
     {
          DB::beginTransaction();
          try {
               $config = $request->input('config');
               $payload=[];
              if(count($config)){
               foreach($config as $key => $value){
                    $payload = [
                         'keyword' => $key,
                         'content' => $value,
                         'language_id' => $languageId,
                         'user_id'=>Auth::id()
                    ];
                    $condition = ['keyword' => $key];
                    $system = $this->systemRepository->updateOrInsert($payload,$condition);
               }
              }
               

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
