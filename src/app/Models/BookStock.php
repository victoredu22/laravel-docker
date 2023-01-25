<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookStock extends Model
{
  protected $table = "book_stock";
  protected $primaryKey = "idStockBook";

  protected $fillable = [
    'idBook',
    'count',
  ];

  /**
   * Metodo que disminuye en uno el stock del libro que fue pedido segun su id
   * 
   * @return update
   */
  public function updateStock($request)
  {
    $BookStock = BookStock::find($request->idBook);
    $BookStock->count--;
    $BookStock->save();

    return $BookStock;
  }

  public function getBook($idBook)
  {
    $bookStock = BookStock::find($idBook);
    return $bookStock;
  }
}
