<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
  protected $table = "delivery";
  protected $primaryKey = "idDelivery";
  protected $fillable = [
    'idBook',
    'idStudent',
    'stateDelivery',
    'dateDelivery',
    'dateRetirement'
  ];

  /**
   * Metodo que busca todos los pedidos activos del sistema
   * 
   * @return $get
   */
  public function getDeliveryActives()
  {
    $get = Delivery::select(
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
      ->join('tblBook', 'tblBook.idBook', 'tblDelivery.idBook')
      ->join('tblStudent', 'tblStudent.idStudent', 'tblDelivery.idStudent')
      ->join('tblDetailStudent', 'tblDetailStudent.idStudent', 'tblStudent.idStudent')
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

    $get = Delivery::select(
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
      ->join('tblBook', 'tblBook.idBook', 'tblDelivery.idBook')
      ->join('tblStudent', 'tblStudent.idStudent', 'tblDelivery.idStudent')
      ->join('tblDetailStudent', 'tblDetailStudent.idStudent', 'tblStudent.idStudent')
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

    $get = Delivery::select(
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
    )
      ->join('tblBook', 'tblBook.idBook', 'tblDelivery.idBook')
      ->join('tblStudent', 'tblStudent.idStudent', 'tblDelivery.idStudent')
      ->join('tblDetailStudent', 'tblDetailStudent.idStudent', 'tblStudent.idStudent')
      ->leftJoin('tblStudentCourse', 'tblStudentCourse.idStudent', 'tblStudent.idStudent')
      ->leftJoin('tblCourse', 'tblStudentCourse.idCourse', 'tblCourse.idCourse');

    return $get;
  }
  /**
   * Metodo que busca el pedido segun el idLibro y el idALumno
   * 
   * @return get
   */
  public function getIdDelivery($idBook, $idStudent)
  {
    $get = Delivery::first()
      ->where('idBook', $idBook)
      ->where('idStudent', $idStudent)
      ->where('stateDelivery', 1);
    return $get;
  }

  public function DeliveryMonth($fechaInicio, $fechaTermino)
  {
    $get = Delivery::whereBetween('created_at', [$fechaInicio, $fechaTermino])
      ->get();

    return $get;
  }

  public function getDeliveryYears($año)
  {
    $get = Delivery::where('dateDelivery', 'like', '%' . $año . '%')
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
    $get = Delivery::where('idStudent', $idStudent)
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
}
