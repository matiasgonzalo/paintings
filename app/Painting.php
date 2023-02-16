<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Painting extends Model
{
    static $allowedFilters = ['name', 'painter', 'country', 'date', 'day', 'month', 'year', 'style', 'width', 'hight'];
    static $allowedSorts = ['name', 'painter', 'date', 'style', 'country'];

    protected $fillable = [
        'code', 'name', 'painter', 'country', 'date', 'style', 'width', 'hight'
    ];

    protected $casts = [
        'id'    => 'string',
        'width' => 'integer',
        'hight' => 'integer'
    ];

    public function scopeYear(Builder $query, $year)
    {
        $query->whereYear('date', $year);
    }

    public function scopeMonth(Builder $query, $month)
    {
        $query->whereMonth('date', $month);
    }

    public function scopeDay(Builder $query, $day)
    {
        $query->whereDay('date', $day);
    }

    public function scopeDate(Builder $query, $date)
    {
        $query->where('date', $date);
    }

    public function scopeWidth(Builder $query, $width)
    {
        $query->where('width', $width);
    }

    public function scopeHight(Builder $query, $hight)
    {
        $query->where('hight', $hight);
    }

    public function scopeCountry(Builder $query, $country)
    {
        $query->where('country', 'LIKE', '%' . $country . '%');
    }

    public function scopePainter(Builder $query, $painter)
    {
        $query->where('painter', 'LIKE', '%' . $painter . '%');
    }

    public function scopeName(Builder $query, $name)
    {
        $query->where('name', 'LIKE', '%' . $name . '%');
    }

    public function scopeStyle(Builder $query, $style)
    {
        $query->where('style', $style);
    }
}
