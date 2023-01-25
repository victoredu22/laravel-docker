<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StudentCourse;
use Faker\Generator as Faker;

$factory->define(StudentCourse::class, function (Faker $faker) {
  return [
    'idStudent' => $faker->unique(true)->numberBetween(1, 5),
    'idCourse' => $faker->unique(true)->numberBetween(1, 5)
  ];
});
