<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BookStock;
use Illuminate\Support\Facades\DB as FacadesDB;


class Book extends Model
{
  protected $table = "tblBook";
  protected $primaryKey = "idBook";
  /**
   * Metodo con el metodo find que me trae la info del libro segun el id
   * 
   * @return get
   */
  public function getBookId($idBook)
  {
    $Book = new Book;
    $Book = Book::find($idBook);
    return $Book;
  }
  /**
   * Metodo que trae todos los libros que se encuentran en el sistema
   * 
   * @return get
   */
  public function getBooks()
  {
    $get = FacadesDB::table('tblBook')
      ->join('tblBookStock', 'tblBook.idBook', '=', 'tblBookStock.idBook')
      ->select('tblBook.idBook', 'tblBook.nameBook', 'tblBook.author', 'tblBook.detail', 'tblBook.state', 'tblBookStock.count', 'tblBook.destiny')
      ->get();
    return $get;
  }
  /**
   * Metodo que trae informacion del libro segun el id
   * 
   * @return get
   */
  public function findBookId($request)
  {
    $get = FacadesDB::table('tblBook')
      ->join('tblBookStock', 'tblBook.idBook', '=', 'tblBookStock.idBook')
      ->select('tblBook.idBook', 'tblBook.nameBook', 'tblBook.author', 'tblBook.detail', 'tblBook.state', 'tblBookStock.count')
      ->where('tblBook.idBook', $request->idBook)
      ->first();
    return $get;
  }


  /**
   * Metodo que actualiza los libros segun el idLibro
   * Actializa en dos tablas en tblLibros y tblBookStock
   * 
   */
  public function updateBook($request)
  {
    $Book = Book::find($request->idBook);
    $Book->nameBook = $request->name;
    $Book->author = $request->author;
    $Book->destiny = $request->destiny;
    $Book->save();

    $libroStock = BookStock::find($request->idBook);
    $libroStock->count = $request->count;
    $libroStock->save();

    return $Book;
  }

  /**
   * Metodo que crea libros y ademas crea el stock de este en su tabla
   * 
   * @return insert
   */
  public function createBooks($request)
  {
    $Book = new Book;
    $Book->nameBook = $request->name;
    $Book->author = $request->author;
    $Book->destiny = $request->destiny;
    $Book->state = $request->state;
    $Book->save();


    $libroStock = new BookStock;
    $libroStock->idBook = $Book->idBook;
    $libroStock->count = $request->count;
    $libroStock->save();

    return $Book;
  }
}
