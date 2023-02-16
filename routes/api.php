<?php

use Illuminate\Http\Request;

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
