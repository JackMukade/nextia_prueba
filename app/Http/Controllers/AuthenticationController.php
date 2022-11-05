<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller {

    protected $user;
   
    public function __construct() { $this->user = new UserRepository(); }

    public function login(LoginRequest $request) {

        $credentials = $request->only('email', 'password'); #Toma los inputs
        $token       = Auth::attempt($credentials); #Intenta conectar
        if (!$token) { return response()->json(['response' => false], 401); } #Si no puede marca error
        $user        = Auth::user(); #Toma el usuario conectado 

        return response()->json(['response' => true, 'user' => $user, 'token' => $token ]);

    }
    
    public function create(RegisterRequest $request){

        $data     = $request->all();
        $create   = $this->user->create($data); #Crea el usuario y toma el token
        $response = (count($create) > 0 ) ? true : false; #si tiene datos fue un exito
       
        return response()->json(['response' => true, 'user' => $create], 200);
    }

    public function logout() {

        Auth::logout();
        return response()->json(['response' => true], 200 );

    }

    public function refresh() {

        return response()->json(['response' => true, 'user' => Auth::user(), 'token' => Auth::refresh()], 200);
        
    }

}