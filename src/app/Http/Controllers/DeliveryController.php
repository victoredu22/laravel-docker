<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\BookStock;
use App\Models\Course;
use App\Models\Delivery;
use App\Models\StudentCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use \stdClass;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Exception;


class DeliveryController extends Controller
{
  protected $delivery;
  protected $book;
  protected $bookStock;
  protected $studenCourse;
  protected $course;

  public function __construct()
  {
    $this->delivery = new Delivery();
    $this->book = new Book();
    $this->bookStock = new BookStock();
    $this->studenCourse = new StudentCourse();
    $this->course = new Course();
  }
  /**
   * Metodo que crea pedidos de alumnos y libros que hayan solicitado,
   * parametros idLibro, idAlumno, fechaEntrega
   * Ademas disminuye en la tabla stock de acuardo al pedido que se hizo
   *
   */
  public function create(Request $request)
  {
    $reglas = array(
      "idBook" => "required",
      "idStudent" => "required",
      "dateDelivery" => "required",
    );
    $msgValidacion = array(
      "required" => "es un campo obligatorio.",
    );
    $validador = FacadesValidator::make($request->all(), $reglas, $msgValidacion);
    if ($validador->fails()) {
      return response()
        ->json([
          'ok' => false,
          "msg" => "validacionError",
          "errores" => $validador->errors(),
        ]);
    }

    $delivery = $this->delivery->getIdDelivery($request->idBook, $request->idStudent);
    if ($delivery) {
      return response()
        ->json([
          'ok' => false,
          'msg' => "libroEncontrado",
        ]);
    }

    $Book = $this->bookStock->getBook($request->idBook);
    if ($Book->count = 0) {
      return response()
        ->json([
          'ok' => false,
          'msg' => 'libroSinStock',
        ]);
    }

    $this->bookStock->updateStock($request);
    $delivery = $this->delivery->createDeliverDate($request);
    $delivery = $this->delivery->getDelivery($delivery->idDelivery);
    $book = $this->book->getBookId($delivery->idBook);
    $studenCourse = $this->studenCourse->getStudentById($delivery->idStudent);
    $course = $this->course->getCursoById($studenCourse->idCourse);


    return response()
      ->json([
        'ok' => true,
        'pedido' => $delivery,
        'libro' => $book,
        'curso' => $course,
      ]);
  }


  public function index(Request $request)
  {
    $url = explode('/', $request->path());
    if (end($url) === 'mostRecent') {
      $Delivery = $this->delivery->getLastDelivery();

      return response()->json([
        'ok' => true,
        'getPedido' => $Delivery,
      ]);
    }

    if (end($url) === 'month') {
      $date = Carbon::now();

      $DateStart = $date->startOfMonth()->format('Y-m-d');
      $DateLast = $date->endOfMonth()->format('Y-m-d');
      $Delivery = $this->delivery->DeliveryMonth($DateStart, $DateLast);
      return response()->json([
        'ok' => true,
        'getPedidos' => $Delivery,
      ]);
    }

    if ($request->idStudent) {
      $delivery = $this->delivery->deliveryStudent($request->idStudent);

      return response()->json([
        'ok' => true,
        'totalPedido' => count($delivery->toArray()),
        'pedidoAlumno' => $delivery,
      ]);
    }


    switch ($request) {
      case $request->buscador != null:
        $data = $this->buscadorPedido($request);
        break;
      case $request->idStudent != null:
        $data = $this->alumnoPedido($request);
        break;
      default:
        $data = $this->delivery->pedidosAll();
        break;
    }

    $getPedidos = $data->paginate(5);

    return response()->json([
      'ok' => true,
      'request' => $request->all(),
      'pagination' => [
        'total' => $getPedidos->total(),
        'current_page' => $getPedidos->currentPage(),
        'per_page' => $getPedidos->perPage(),
        'last_page' => $getPedidos->lastPage(),
        'from' => $getPedidos->firstItem(),
        'to' => $getPedidos->lastPage(),
      ],
      'getPedidos' => $getPedidos,
    ]);
  }

  public function buscadorPedido($request)
  {

    switch ($request) {
      case count($request->idCursos) > 0:
        $seleccion = 'idCursos';
        break;
      case $request->idAlumno != "undefined":
        $seleccion = 'alumnos';
        break;
      default:
        $seleccion = null;
        break;
    }


    $buscador = [
      "idCursos" => $this->delivery->pedidosAll()
        ->whereIn('tblAlumnoCurso.idCurso', $request->idCursos)
        ->where('nameBook', 'LIKE', '%' . $request->buscador . '%'),
      "alumnos" => $this->delivery->pedidosAll($request)
        ->where('nameBook', 'LIKE', '%' . $request->buscador . '%')
        ->where('tblDelivery.idStudent', $request->idAlumno),
    ];

    return $seleccion != null
      ? $buscador[$seleccion]
      : $this->delivery->pedidosAll()
      ->where('nameBook', 'LIKE', '%' . $request->buscador . '%');
  }
  //Ultima bbusqueda
  public function alumnoPedido($request)
  {
    return $this->delivery->pedidosAll()
      ->where('tblDelivery.idStudent', $request->idAlumno);
  }


  /**
   * Busca 
   * 
   * @author victor curilao
   */
  /*   public function searchPedidoCursoLibro(Request $request)
  {

    $idCursos = $request->idCursos;

    $getPedidos = $this->Pedido->getPedidoCursoLibro($idCursos, $request->buscador)->paginate(5);

    return response()->json([
      'ok' => true,
      'pagination' => [
        'total' => $getPedidos->total(),
        'current_page' => $getPedidos->currentPage(),
        'per_page' => $getPedidos->perPage(),
        'last_page' => $getPedidos->lastPage(),
        'from' => $getPedidos->firstItem(),
        'to' => $getPedidos->lastPage()
      ],
      'getPedidos' => $getPedidos
    ]);
  } */
  /*   public function searchPedidoAlumno($idAlumno)
  {

    $getPedidos = $this->Pedido->getPedidoByAlumno($idAlumno)->paginate(5);
    return response()->json([
      'ok' => true,
      'pagination' => [
        'total' => $getPedidos->total(),
        'current_page' => $getPedidos->currentPage(),
        'per_page' => $getPedidos->perPage(),
        'last_page' => $getPedidos->lastPage(),
        'from' => $getPedidos->firstItem(),
        'to' => $getPedidos->lastPage()
      ],
      'getPedidos' => $getPedidos
    ]);
  } */




  /**
   * Metodo que obtiene los pedido segun el IdAlumno
   *
   * @author Victor Curilao
   */
  /*   public function infoPedidoAlumno($idAlumno)
  {
    $pedidoAlumno = $this->Pedido->getPedidoAlumno($idAlumno);
    $totalPedidos = count($pedidoAlumno);

    return response()->json([
      'ok' => true,
      'totalPedido' => $totalPedidos,
      'pedidoAlumno' => $pedidoAlumno,
    ]);
  } */
  /**
   * Metodos que muestra los ultimos pedidos que estan activos
   * asociando libros y alumnos
   *
   * @author Victor Curilao
   */

  /**
   * Metodo que nos trae todos los libros pendientes de acuerdo a la llamada de este
   *
   * @author Victor Curilao
   */
  public function deliveryPending()
  {
    try {

      $date = Carbon::now();
      $dateToday = $date->format('Y-m-d');
      $delivery = $this->delivery->getDeliveryActives();

      $filterDate = $delivery->map(function ($elem, $key) use ($dateToday) {
        $dateDelivery = explode(" ", $elem->dateDelivery);
        $dateDelivery = $dateDelivery[0];
        return (Carbon::parse($dateDelivery)->lt($dateToday) == true) ? $elem : null;
      });

      $studentNotNull = $filterDate->filter(function ($elem, $key) {
        return $elem != null;
      })->values()->all();

      return response()->json([
        'ok' => true,
        'listStudents' => $studentNotNull,
      ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }
  public function porcentDeliveryMonth()
  {
    try {

      $date = Carbon::now();
      $year = $date->year;

      $month = array(
        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
      );

      $monthNumbers = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

      $deliveryYears = $this->delivery->getDeliveryYears($year);

      $sumDelivery = count($deliveryYears);

      $totalDeliveryYears = collect($monthNumbers)->map(function ($elem, $key) use ($year, $sumDelivery) {

        $startDay = Carbon::parse($year . '-' . $elem)->startOfMonth()->format('Y-m-d');
        $endDay = Carbon::parse($year . '-' . $elem)->endOfMonth()->format('Y-m-d');

        return count($this->delivery->DeliveryMonth($startDay, $endDay));
      });


      $yearsBook = collect($month)->map(function ($elem, $keyMes) use ($totalDeliveryYears) {
        $book = new stdClass;
        $book->mes = $elem;
        $book->porcent = $totalDeliveryYears->filter(function ($elemPedido, $keyPedido) use ($keyMes) {
          return $keyMes === $keyPedido;
        })->values()->first();

        return $book;
      });
      return response()->json([
        'ok' => true,
        'deliveryYears' => $yearsBook,
      ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }

  /**
   * Metodo que actualiza el estado del pedido segun el idLibro y idALumno
   *
   * @author Victor Curilao
   */
  public function update(Request $request)
  {

    try {
      $delivery = $this->delivery->updateState($request);

      return response()
        ->json([
          'ok' => true,
          'msg' => "estadoActualizado",
          'delivery' => $delivery,
        ]);
    } catch (Exception $e) {
      return response()
        ->json([
          'error' => $e->getMessage()
        ], 422);
    }
  }
}
