<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\DetailStudent;
use Faker\Generator as Faker;

$factory->define(DetailStudent::class, function (Faker $faker) {
  $gender = $faker->randomElement($array = array('male', 'female', 'mixed'));

  return [
    'idStudent' => $faker->numberBetween($min = 0, $max = 5),
    'firstName' => $faker->name($gender),
    'lastName' => $faker->name($gender),
  ];
});
