<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CourseBooks;
use Faker\Generator as Faker;

$factory->define(CourseBooks::class, function (Faker $faker) {
  return [
    'idCourse' => $faker->unique(true)->numberBetween(1, 5),
    'idBook' => $faker->unique(true)->numberBetween(1, 2),
    'active' => $faker->numberBetween(1, 5)
  ];
});
