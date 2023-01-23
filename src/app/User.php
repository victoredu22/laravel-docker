<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

//Añadimos la clase JWTSubject
use Tymon\JWTAuth\Contracts\JWTSubject;
use DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'tblStudent';
    protected $primaryKey = 'idStudent';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function createUser($request)
    {

        $insert = new User;
        $insert->dni = $request->dni;
        $insert->email = $request->email;
        $insert->password = Hash::make($request->password);
        $insert->save();

        return $insert;
    }
    /*
    Añadiremos estos dos métodos
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}