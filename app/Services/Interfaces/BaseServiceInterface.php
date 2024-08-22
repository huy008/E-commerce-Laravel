<?php

namespace App\Services\Interfaces;


/**
 * Class UserService
 * @package App\Services
 */
interface BaseServiceInterface
{
     public function currentLanguage();
     public function updateStatus($post = []);
}
