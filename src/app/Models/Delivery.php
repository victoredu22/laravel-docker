<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Delivery extends Model
{
  protected $table = "tblDelivery";
  protected $primaryKey = "idDelivery";

  /**
   * Metodo que busca todos los pedidos junto con el stock del libro
   * 
   * @return $get
   */
  public function getPedido()
  {
    $get = FacadesDB::table('tblDelivery')
      ->join('tblBookStock', 'tblDelivery.idBook', '=', 'tblBookStock.idBook')
      ->get();
    return $get;
  }
  /**
   * Metodo que busca todos los pedidos activos del sistema
   * 
   * @return $get
   */
  public function getDeliveryActives()
  {
    $get = FacadesDB::table('tblDelivery')
      ->join('tblBook', 'tblBook.idBook', 'tblDelivery.idBook')
      ->join('tblStudent', 'tblStudent.idStudent', 'tblDelivery.idStudent')
      ->join('tblDetailStudent', 'tblDetailStudent.idStudent', 'tblStudent.idStudent')
      ->select(
        'tblDelivery.idDelivery',
        'tblDelivery.idBook',
        'tblDelivery.idStudent',
        'tblDelivery.dateDelivery',
        'tblDelivery.stateDelivery',
        'tblStudent.idStudent',
        'tblDetailStudent.firstName',
        'tblDetailStudent.lastName',
        'tblBook.nameBook',
        'tblDelivery.created_at'
      )
      ->get();

    return $get;
  }
  /**
   * Consulta que trae los ultimos pedidos de la base datos en base de alumno y libros
   * los ordena segun la fecha de la creacion
   * 
   * @return get
   */
  public function getLastDelivery()
  {

    $get = FacadesDB::table('tblDelivery')
      ->join('tblBook', 'tblBook.idBook', 'tblDelivery.idBook')
      ->join('tblStudent', 'tblStudent.idStudent', 'tblDelivery.idStudent')
      ->join('tblDetailStudent', 'tblDetailStudent.idStudent', 'tblStudent.idStudent')
      ->select(
        'tblDelivery.idDelivery',
        'tblDelivery.idBook',
        'tblDelivery.idStudent',
        'tblDelivery.dateDelivery',
        'tblDelivery.stateDelivery',
        'tblStudent.idStudent',
        'tblDetailStudent.firstName',
        'tblDetailStudent.lastName',
        'tblBook.nameBook',
        'tblDelivery.created_at'
      )
      ->orderBy('created_at', 'DESC')
      ->get();

    return $get;
  }
  /**
   * Consulta que trae los ultimos pedidos de la base datos en base de alumno y libros
   * los ordena segun la fecha de la creacion
   * 
   * @return get
   */
  public function pedidosAll()
  {

    $get = FacadesDB::table('tblDelivery')
      ->join('tblBook', 'tblBook.idBook', 'tblDelivery.idBook')
      ->join('tblStudent', 'tblStudent.idStudent', 'tblDelivery.idStudent')
      ->join('tblDetailStudent', 'tblDetailStudent.idStudent', 'tblStudent.idStudent')
      ->leftJoin('tblStudentCourse', 'tblStudentCourse.idStudent', 'tblStudent.idStudent')
      ->leftJoin('tblCourse', 'tblStudentCourse.idCourse', 'tblCourse.idCourse')
      ->select(
        'tblDelivery.idDelivery',
        'tblDelivery.idBook',
        'tblDelivery.idStudent',
        'tblDelivery.dateDelivery',
        'tblDelivery.stateDelivery',
        'tblDelivery.dateDelivery',
        'tblStudent.idStudent',
        'tblDetailStudent.firstName',
        'tblDetailStudent.lastName',
        'tblBook.nameBook',
        'tblCourse.name',
        'tblStudentCourse.idCourse'
      );

    return $get;
  }
  /**
   * Metodo que busca el pedido segun el idLibro y el idALumno
   * 
   * @return get
   */
  public function getIdDelivery($idBook, $idStudent)
  {
    $get = FacadesDB::table('tblDelivery')
      ->where('idBook', $idBook)
      ->where('idStudent', $idStudent)
      ->where('stateDelivery', 1)
      ->get()
      ->first();
    return $get;
  }

  public function DeliveryMonth($fechaInicio, $fechaTermino)
  {
    $get = FacadesDB::table('tblDelivery')
      ->whereBetween('created_at', [$fechaInicio, $fechaTermino])
      ->get();

    return $get;
  }

  public function getDeliveryYears($año)
  {
    $get = FacadesDB::table('tblDelivery')
      ->where('dateDelivery', 'like', '%' . $año . '%')
      ->get();

    return $get;
  }
  public function getPedidosMensuales($fecha)
  {
    $get = FacadesDB::table('tblPedido')
      ->where('fechaPedido', 'like', '%' . $fecha . '%')
      ->where('activo', 1)
      ->get();

    return $get;
  }
  /**
   * Metodo que obiene datos del pedido segun el idAlumno
   * 
   * @return get
   */
  public function deliveryStudent($idStudent)
  {
    $get = FacadesDB::table('tblDelivery')
      ->where('idStudent', $idStudent)
      ->where('stateDelivery', 1)
      ->get();
    return $get;
  }

  /**
   * Metodo que crea un nuevo pedido
   * @return insert
   */
  public function createDeliverDate($request)
  {

    $libro = new Delivery;
    $libro->idBook = $request->idBook;
    $libro->idStudent = $request->idStudent;
    $libro->dateDelivery = $request->dateDelivery;
    $libro->stateDelivery = 1;
    $libro->save();
    return $libro;
  }

  public function getDelivery($idLibro)
  {
    $pedido = new Delivery;
    $pedido = Delivery::find($idLibro);
    return $pedido;
  }
  /**
   * Actualiza el estado del pedido
   * 
   * @return update pedido
   */
  public function updateState($request)
  {
    $delivery = Delivery::find($request->idDelivery);
    $delivery->stateDelivery = $request->stateDelivery;
    $delivery->save();

    return $delivery;
  }

  public function getPedidoAll($numeroPaginate)
  {
    $get = FacadesDB::table('tblPedido')->paginate($numeroPaginate);
    return $get;
  }
}
