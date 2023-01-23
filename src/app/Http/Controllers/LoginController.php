<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Student;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class LoginController extends Controller
{
  protected $user;
  protected $alumno;
  public function __construct()
  {
    $this->user = new User();
    $this->alumno = new Student();
  }


  public function imagenLogin()
  {

    $public = public_path();
    $url = $public . '\storage' . '\imgInicio.jpg';

    return response()->json([
      'ok' => true,
      'url' => $url
    ]);
  }
  /**
   * Metodo que verfica las credenciales segun los parametros
   *
   * @param numeroDocumento,password
   */
  public function login(Request $request)
  {
    $credentials = request(['dni', 'password']);
    $jwt_token = null;

    if (!$jwt_token = FacadesJWTAuth::attempt($credentials)) {
      return response()->json([
        'success' => false,
        'message' => 'Usuario Incorrecto',
      ]);
    }

    $token = $this->respondWithToken($jwt_token);

    return response()->json([
      'success' => true,
      'token' => $token,
    ]);
  }

  public function register(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'dni' => 'required',
      'email' => 'required',
      'password' => 'required',
    ]);


    if ($validator->fails()) {
      return response()->json($validator->errors()->toJson(), 400);
    }

    $user = $this->user->createUser($request);

    $token = FacadesJWTAuth::fromUser($user);

    return response()->json(compact('user', 'token'), 201);
  }
  public function getUsuario(Request $request)
  {
    dd("hola");
  }


  public function getAuthUser(Request $request)
  {
    $this->validate($request, [
      'token' => 'required'
    ]);

    $user = FacadesJWTAuth::authenticate($request->token);

    return response()->json(['user' => $user]);
  }

  /**
   * Get the token array structure.
   *
   * @param string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      //'expires_in' => auth()->factory()->getTTL() * 60,
      'user' => auth()->user(),
    ]);
  }
}
