<?php

namespace App\Services\Interfaces;


/**
 * Class UserService
 * @package App\Services
 */
interface GenerateServiceInterface
{
     public function paginate($condition);
     public function create($request);
     public function update($id, $request);
     public function destroy($id);
}
