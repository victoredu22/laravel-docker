<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

namespace Database\Factories;

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {

  $title = $this->faker->sentence(2);

  $gender = $faker->randomElement($array = array('male', 'female', 'mixed'));

  return [
    'nameBook' => $faker->paragraph(1),
    'author' => $faker->name($gender),
    'detail' => $faker->paragraph(2),
    'state' =>  $faker->paragraph(1),
    'count' =>  $faker->numberBetween($min = 0, $max = 5),
    'destiny' => $faker->paragraph(2)
  ];
});
