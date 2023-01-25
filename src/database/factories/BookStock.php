<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookStock;
use Faker\Generator as Faker;

$factory->define(BookStock::class, function (Faker $faker) {
  return [
    'idBook' => $faker->unique(true)->numberBetween(1, 5),
    'count' => $faker->numerify('#')
  ];
});
