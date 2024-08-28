<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\ProductCatalogue;
use App\Http\Controllers\FrontendController;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;


class FrontendCatalogueController extends FrontendController
{
     protected $productService;
     protected $productRepository;
     protected $productCatalogueService;
     protected $productCatalogueRepository;

     public function __construct(
          ProductService $productService,
          ProductRepository $productRepository,
          ProductCatalogueService $productCatalogueService,
          ProductCatalogueRepository $productCatalogueRepository
     ) {
          parent::__construct();
          $this->productService = $productService;
          $this->productRepository = $productRepository;
          $this->productCatalogueService = $productCatalogueService;
          $this->productCatalogueRepository = $productCatalogueRepository;
     }
   
}
