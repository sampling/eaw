<?php

namespace App\Providers;

use App\Services\Map;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class MapServiceProvider
 * @package App\Providers
 */
class MapServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Package boot method
     */
    public function boot()
    {
       // $this->registerBladeExtensions();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMap();
        $this->registerFacade();
        $this->registerBindings();
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerMap()
    {
        $this->app->bind('map', function ($app) {
            return new Map($app);
        });
    }

    /**
     * Register the vault facade without the user having to add it to the app.php file.
     *
     * @return void
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Map', \App\Services\Map\Facades\Map::class);
        });
    }

    /**
     * Register service provider bindings
     */
    public function registerBindings()
    {
        $this->app->bind(
            \App\Repositories\Backend\Map\MapContract::class,
            \App\Repositories\Backend\Map\EloquentMapRepository::class
        );
    }

    /**
     * Register the blade extender to use new blade sections
     */
    protected function registerBladeExtensions()
    {
        /**
         * Role based blade extensions
         * Accepts either string of Role Name or Role ID
         */
        Blade::directive('role', function ($role) {
            return "<?php if (access()->hasRole{$role}): ?>";
        });

        /**
         * Accepts array of names or id's
         */
        Blade::directive('roles', function ($roles) {
            return "<?php if (access()->hasRoles{$roles}): ?>";
        });

        Blade::directive('needsroles', function ($roles) {
            return '<?php if (access()->hasRoles(' . $roles . ', true)): ?>';
        });

        /**
         * Permission based blade extensions
         * Accepts wither string of Permission Name or Permission ID
         */
        Blade::directive('permission', function ($permission) {
            return "<?php if (access()->allow{$permission}): ?>";
        });

        /**
         * Accepts array of names or id's
         */
        Blade::directive('permissions', function ($permissions) {
            return "<?php if (access()->allowMultiple{$permissions}): ?>";
        });

        Blade::directive('needspermissions', function ($permissions) {
            return '<?php if (access()->allowMultiple(' . $permissions . ', true)): ?>';
        });

        /**
         * Generic if closer to not interfere with built in blade
         */
        Blade::directive('endauth', function () {
            return '<?php endif; ?>';
        });
    }
}
