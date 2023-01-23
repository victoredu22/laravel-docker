<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
}); */

Route::post('login', 'LoginController@login');
Route::post('register', 'LoginController@register');
Route::get('imagenLogin', 'LoginController@imagenLogin');



Route::post('ingresoContacto', 'ContactoController@insertContacto');

Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
  Route::get('loginLogeado', 'LoginController@loginLogeado');

  //nuevas rutas
  Route::get('course', 'CourseController@index');
  Route::get('course/{idCourse}/students', 'CourseController@show');
  Route::get('course/{idCourse}', 'CourseController@show');

  Route::get('students', 'StudentController@index');
  Route::get('students/{rut}', 'StudentController@show');

  Route::get('books', 'BooksController@index');
  Route::post('books', 'BooksController@create');
  Route::put('books', 'BooksController@updateLibro');
  Route::get('books/{idBooks}', 'BooksController@show');


  Route::post('delivery', 'DeliveryController@create');
  Route::get('delivery', 'DeliveryController@index');
  Route::put('delivery', 'DeliveryController@update');

  Route::get('delivery/mostRecent', 'DeliveryController@index');
  Route::get('delivery/month', 'DeliveryController@index');

  Route::get('delivery/porcent/month', 'DeliveryController@porcentDeliveryMonth');
  Route::get('delivery/pending', 'DeliveryController@deliveryPending');
  Route::get('delivery/student/{idAlumno}', 'DeliveryController@index');

  /////////
});
