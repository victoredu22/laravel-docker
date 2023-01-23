<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Validator;
use \stdClass;

class BooksController extends Controller
{
  protected $books;

  public function __construct()
  {
    $this->books = new Book();
  }
  /**
   * Método que muestra todos los libros que se encuentran en el sistema
   *
   * @author Victor Curilao
   * */
  public function index()
  {
    try {
      $books = $this->books->getBooks();

      return response()
        ->json([
          'ok' => true,
          'libros' => $books
        ], 200);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e
        ], 422);
    }
  }
  /**
   * Metodo que crea un nuevo libro y ademas aumenta el stock
   * 
   * @author Victor Curilao
   */
  public function create(Request $request)
  {
    try {
      $reglas = array(
        "name" => "required",
        "count" => "required",
        "author" => "required",
        "course" => "required",
        "destiny" => "required"
      );
      $msgValidacion = array(
        "required" => "es un campo obligatorio."
      );
      $validador = FacadesValidator::make($request->all(), $reglas, $msgValidacion);
      if ($validador->fails()) {
        return response()
          ->json([
            'ok' => false,
            "msg" => "validacionError",
            "errores" => $validador->errors()
          ], 422);
      }

      $book = $this->books->createBooks($request);

      return response()
        ->json([
          'ok' => true,
          "msg" => "libroCreado",
          "libro" => $book,
          'cantidad' => $request->count
        ], 200);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }
  /**
   * Metodo que actualiza los parametros del libro
   * 
   * @author Victor Curilao
   */
  public function updateLibro(Request $request)
  {
    try {
      $reglas = array(
        "name" => "required",
        "count" => "required",
        "author" => "required",
        "destiny" => "required"
      );
      $msgValidacion = array(
        "required" => "es un campo obligatorio."
      );
      $validador = FacadesValidator::make($request->all(), $reglas, $msgValidacion);
      if ($validador->fails()) {
        return response()
          ->json([
            'ok' => false,
            "msg" => "validacionError",
            "errores" => $validador->errors()
          ]);
      }

      $updateBook = $this->books->updateBook($request);
      $getBook = $this->books->findBookId($request);

      if ($updateBook) {
        return response()
          ->json([
            'ok' => true,
            "msg" => "libroActualizado",
            "libro" => $getBook
          ]);
      }
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }

  /**
   * Informacion de los libros segun el id
   * 
   * @author Victor Curilao
   */
  public function show($idBook)
  {
    try {
      $request = new stdClass;
      $request->idBook = $idBook;

      $book = $this->books->findLibroId($request);

      return response()
        ->json([
          'ok' => true,
          'book' => $book
        ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }
}
