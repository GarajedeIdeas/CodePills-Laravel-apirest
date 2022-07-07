<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //

    public function users(Request $request){

        if($request->has('active')){
            $users = User::where('active',true)->get();
        }else{
            $users = User::all();
        }


        return response()->json($users);
    }

    public function login(Request $request){

        $response = ["status"=>0,"msg"=>""];

        $data = json_decode($request->getContent());

        $user = User::where('email',$data->email)->first();

        if($user){

            if(Hash::check($data->password,$user->password)){

                $token = $user->createToken("example");

                $response["status"] = 1;
                $response["msg"] = $token->plainTextToken;

            }else{
                $response["msg"] = "Credenciales incorrectas.";
            }

        }else{
            $response["msg"] = "Usuario no encontrado.";
        }

        return response()->json($response);        
    }

}
