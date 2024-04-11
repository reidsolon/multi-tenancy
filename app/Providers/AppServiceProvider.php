<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->mergeBuilderMacros();
    }

    public function mergeBuilderMacros()
    {
        Builder::macro('orderByNullsLast', function ($column) {
            /** @var Builder $this */

            $column = $this->getGrammar()->wrap($column);

            return $this->orderByRaw("$column is null");
        });

        EloquentBuilder::macro('getOrPaginate', function () {
            /** @var EloquentBuilder $this */

            return $this->when(
                request()->filled('per_page') || request()->filled('limit'),
                fn($query) => $query->paginate(request()->input('limit')),
                fn($query) => $query->get()
            );
        });

        EloquentBuilder::macro('getOrSimplePaginate', function () {
            /** @var EloquentBuilder $this */

            return $this->when(
                request()->filled('per_page') || request()->filled('limit'),
                fn($query) => $query->simplePaginate(request()->input('limit')),
                fn($query) => $query->get()
            );
        });
    }
}
