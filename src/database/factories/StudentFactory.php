<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Student;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Student::class, function (Faker $faker) {
  return [
    'email' => preg_replace('/@example\..*/', '@domain.com', $faker->unique()->safeEmail),
    'password' => '$2y$10$QZTEmaJL0PuE15gmoR0XBe2O420WRWDd0AEvdIY.qItel6varwTki',
    'dni' => $faker->numerify('#########'),
  ];
});
