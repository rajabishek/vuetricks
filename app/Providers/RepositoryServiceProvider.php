<?php

namespace Vuetricks\Providers;

use Vuetricks\User;
use Vuetricks\Repositories\UserRepositoryInterface;
use Vuetricks\Repositories\Eloquent\UserRepository;
use Vuetricks\Repositories\TrickRepositoryInterface;
use Vuetricks\Repositories\Eloquent\TrickRepository;
use Vuetricks\Repositories\TagRepositoryInterface;
use Vuetricks\Repositories\Eloquent\TagRepository;
use Vuetricks\Repositories\CategoryRepositoryInterface;
use Vuetricks\Repositories\Eloquent\CategoryRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TrickRepositoryInterface::class, TrickRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UserRepositoryInterface::class,
            TrickRepositoryInterface::class,
            TagRepositoryInterface::class,
            CategoryRepositoryInterface::class,
        ];
    }
}
