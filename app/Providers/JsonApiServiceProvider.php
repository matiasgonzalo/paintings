<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

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

        Builder::macro('jsonPaginate', function() {
            return $this->paginate(
                        $perPage = request('page.size', 15),
                        $columns = ['*'],
                        $pageName = 'page[number]',
                        $page = request('page.number', 1)
                    )->appends(request()->only('sort', 'page.size'));
        });

        Builder::macro('allowedFilters', function($allowedFilters) {
            foreach (request('filter', []) as $filter => $value) {
                abort_unless(in_array($filter, $allowedFilters), 400);
                $this->{$filter}($value);
            }

            return $this;
        });

        Builder::macro('sparceFieldSet', function() {
            if (request()->filled('fields.paintings')) {
                $fields = explode(',', request('fields.paintings'));

                if (!in_array('id', $fields)) {
                    $fields[] = 'id';
                }

                return $this->addSelect($fields);
            }
            return $this;
        });
    }
}
