<?php

use App\Models\Book;
use App\Models\Student;

use App\Models\BookStock;
use App\Models\Course;
use App\Models\Delivery;
use App\Models\StudentCourse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    factory('App\Models\Student'::class, 5)->create();
    factory('App\Models\DetailStudent'::class, 5)->create();
    factory('App\Models\Book'::class, 5)->create();
    factory('App\Models\Course'::class, 5)->create();

    factory('App\Models\Delivery'::class, 5)->create();
    factory('App\Models\BookStock'::class, 5)->create();
    factory('App\Models\CourseBooks'::class, 5)->create();
    factory('App\Models\StudentCourse'::class, 5)->create();
  }
}
