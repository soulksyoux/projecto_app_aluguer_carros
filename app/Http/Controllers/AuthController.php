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

        return response()->json(["msg" => "Login com sucesso!"], 200);


    }
    public function logout(){
        echo "logout";
    }
    public function refresh(){
        echo "refresh";
    }
    public function me(){
        echo "me";
    }
}
