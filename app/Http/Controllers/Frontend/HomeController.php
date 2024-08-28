<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\ProductCatalogue;
use App\Http\Controllers\FrontendController;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueRepository;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;

class HomeController extends FrontendController
{
    protected $productService;
    protected $productRepository;
    protected $productCatalogueService;
    protected $productCatalogueRepository;
    protected $attributeCatalogueRepository;

    public function __construct(
        ProductService $productService,
        ProductRepository $productRepository,
        ProductCatalogueService $productCatalogueService,
        ProductCatalogueRepository $productCatalogueRepository,
        AttributeCatalogueRepository $attributeCatalogueRepository
    ) {
        parent::__construct();
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
    }
    public function index(Request $request)
    {
        $productCatalogues = ProductCatalogue::query()
            ->with('product_catalogue_language')
            ->with('products')
            ->get();
        $products = $this->productRepository->all();
        $template = 'frontend.homepage.home.index';
        return view('frontend.homepage.layout', compact(
            'template',
            'productCatalogues',
            'products'
        ));
    }

    public function showProductByCat($id)
    {
        $productCatalogues  = $this->productCatalogueRepository->all();
        $productCatalogue = $this->productCatalogueRepository->findById($id);
        $products = $productCatalogue
            ->select(['p.*'])
            ->join('product_catalogue_product as pcp', 'product_catalogues.id', '=', 'pcp.product_catalogue_id')
            ->join('products as p', 'pcp.product_id', '=',  'p.id')
            ->where('product_catalogues.id', $id)
            ->get();
        $template = 'frontend.homepage.home.index';
        return view('frontend.homepage.layout', compact(
            'template',
            'productCatalogues',
            'products'
        ));
    }
    public function detail($id)
    {
        $product = $this->productRepository->findById($id);
        $productCatalogues  = $this->productCatalogueRepository->all();

        $attributeCatalogues = $this->attributeCatalogueRepository->all();
     
       dd($attributeCatalogues[0]->languages()->with('attributes')->first());
        $template = 'frontend.component.detail';
        return view('frontend.homepage.layout', compact(
            'template',
            'product',
            'productCatalogues',
            'attributeCatalogues'
        ));
    }
}
