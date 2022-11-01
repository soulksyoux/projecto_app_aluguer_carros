<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
   
    public function login(Request $request){
        $credenciais = $request->all(["email", "password"]); 
        $token = auth("api")->attempt($credenciais);
        
        if(empty($token)) {
            return response()->json(["erro" => "Login inválido"], 401);
        }

        return response()->json(["token" => $token], 200);


    }
    public function logout(){
        auth("api")->logout();
        return response()->json(["msg" => "Logout com sucesso!"]);
    }
    public function refresh(){
        $token = auth("api")->refresh();
        return response()->json(["token" => $token]);
    }

    public function me(){
        return response()->json(auth()->user(), 200);
    }
}
