<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Delivery;
use Faker\Generator as Faker;

$factory->define(Delivery::class, function (Faker $faker) {
  return [
    'idBook' => $faker->unique(true)->numberBetween(1, 5),
    'idStudent' => $faker->unique(true)->numberBetween(1, 4),
    'stateDelivery' => $faker->numberBetween(1, 3),
    'dateDelivery' => $faker->date(),
    'dateRetirement' => $faker->date()
  ];
});
