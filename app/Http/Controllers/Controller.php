<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected static $products_per_page;
    
    public function __construct()
    {
        self::$products_per_page = getOption('products_per_page');
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}