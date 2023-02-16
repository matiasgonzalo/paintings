<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Database\Query\Builder;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('allowedSorts', function($allowedSorts) {
            if (request()->filled('sort')) {
                $sortFields = explode(',', request()->input('sort'));

                foreach ($sortFields as $sortField) {
                    $sortDirection = Str::startsWith($sortField, '-') ? 'desc' : 'asc';

                    $sortField = Str::startsWith($sortField, '-') ? ltrim($sortField, '-') : $sortField;

                    abort_unless(in_array($sortField, $allowedSorts), 400);

                    $this->orderBy($sortField, $sortDirection);
                }
            }

            return $this;
        });
    }
}
