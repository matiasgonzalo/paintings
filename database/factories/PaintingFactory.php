<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Painting;
use Faker\Generator as Faker;

$factory->define(Painting::class, function (Faker $faker) {
    return [
        'name'      => $this->faker->name,
        'code'      => $this->faker->regexify('[A-Za-z0-9]{250}'),
        'painter'   => $this->faker->name,
        'country'   => $this->faker->country,
        'date'      => $this->faker->date('Y-m-d'),
        'style'     => $this->faker->word,
        'width'     => $this->faker->numberBetween(1, 10000),
        'hight'     => $this->faker->numberBetween(1, 10000)
    ];
});
