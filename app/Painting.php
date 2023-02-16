<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Painting extends Model
{
    protected $fillable = [
        'code', 'name', 'painter', 'country', 'date', 'style', 'width', 'hight'
    ];

    protected $casts = [
        'id'    => 'string',
        'width' => 'integer',
        'hight' => 'integer'
    ];
}
