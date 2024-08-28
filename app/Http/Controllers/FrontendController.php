<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class FrontendController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
    }
}
