<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/tenants';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $this->mapWebRoutes();
            $this->mapApiRoutes();
            $this->mapUserRoutes();
            $this->mapAdminRoutes();
        });
    }

    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    protected function mapAdminRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('admin')
                ->domain($domain)
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));
        }
    }

    protected function mapUserRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('user')
                ->domain($domain)
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/user.php'));
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains', []);
    }
}
