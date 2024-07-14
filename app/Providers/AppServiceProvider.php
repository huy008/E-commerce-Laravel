<?php

namespace App\Providers;

use Illuminate\Cache\Repository;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public $services = [
        'App\Services\Interfaces\BaseServiceInterface' => 'App\Services\BaseService',

        'App\Services\Interfaces\UserServiceInterface' => 'App\Services\UserService',

        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',

        'App\Services\Interfaces\UserCatalogueServiceInterface' => 'App\Services\UserCatalogueService',

        'App\Services\Interfaces\LanguageServiceInterface' => 'App\Services\LanguageService',

        'App\Services\Interfaces\PostCatalogueServiceInterface' => 'App\Services\PostCatalogueService',



        'App\Services\Interfaces\PostServiceInterface' => 'App\Services\PostService',

        'App\Services\Interfaces\PermissionServiceInterface' => 'App\Services\PermissionService',

        'App\Services\Interfaces\GenerateServiceInterface' => 'App\Services\GenerateService',

        'App\Services\Interfaces\AttributeCatalogueServiceInterface' => 'App\Services\AttributeCatalogueService',
        'App\Services\Interfaces\AttributeServiceInterface' => 'App\Services\AttributeService',
        
        'App\Services\Interfaces\ProductCatalogueServiceInterface' => 'App\Services\ProductCatalogueService',
        'App\Services\Interfaces\ProductServiceInterface' => 'App\Services\ProductService',
        'App\Services\Interfaces\SystemServiceInterface' => 'App\Services\SystemService',
    ];

    public function register(): void
    {
        foreach ($this->services as $key => $value) {
            $this->app->bind($key, $value);
        }
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
