<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;

$factory->define(Course::class, function (Faker $faker) {
  $courses = $faker->randomElement($array = array('primer', 'segundo', 'tercero', 'cuarto'));

  return [
    'name' => $faker->name($courses)
  ];
});
