<?php

use Illuminate\Support\Facades\Route;

Route::prefix('oauth')->group(function () {
        Route::post('/login', 'AuthController@login');
});

Route::middleware(['auth:api', 'role:OWNER', 'verify_header_key'])->group(function () {
        Route::get('paintings/{painting}', 'PaintingController@show')
                ->name('api.v1.paintings.show');

        Route::get('paintings', 'PaintingController@index')
                ->name('api.v1.paintings.index');

        Route::post('paintings', 'PaintingController@store')
                ->name('api.v1.paintings.store');

        Route::patch('paintings/{painting}', 'PaintingController@update')
                ->name('api.v1.paintings.update');

        Route::delete('paintings/{painting}', 'PaintingController@destroy')
                ->name('api.v1.paintings.destroy');
});

Route::middleware(['auth:api', 'verify_header_key'])->group(function () {
        Route::get('users/{user}', 'UserController@show')
                ->name('api.v1.users.show');

        Route::get('users', 'UserController@index')
                ->name('api.v1.users.index');

        Route::post('users', 'UserController@store')
                ->name('api.v1.users.store');
});
