<?php

namespace App\Services\Interfaces;


/**
 * Class UserService
 * @package App\Services
 */
interface MenuServiceInterface
{
     public function paginate($condition);
     public function create($request);
     public function update($id, $request);
     public function destroy($id);
     public function dragUpdate($menuCatalogueId = 0, $json = [], $parentId = 0);
     public function getAndConvertMenu($menu = null, $language = 1): array;
}
