<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Iluminate\Http\Response;

class AuthController extends Controller
{
    //

    public function register(Request $request){

        $fields = $request-> validate([
             "name" => "required|string",
             "email" => "required|string|unique:users,email",
             "password" => "required|string|confirmed"
        ]);

        $user = User::create([
            "name"=> $fields["name"],
            "email"=> $fields["email"],
            "password"=> Hash::make($fields["password"])
        ]);

        $token = $user->createToken("myapptoken")->plainTextToken;

        $response = [
            "user" => $user,
            "token"=> $token
        ];


        return response($response, 201);


    }


    public function login(Request $request){

        $fields = $request->validate([
            "email"=> "required|string|email",
            "password" =>"required|string"
        ]);

        //get email
        $user = User::where("email", $fields["email"])->first();

        //Check password

        if(!$user || !Hash::check($fields["password"], $user->password)){

            return response([
                "message" => "Invalid Credentials"
            ],401);

        };


         $token = $user->createToken("")->plainTextToken;

         $response = [
            "user"=> $user,
            "token" => $token
         ];


            return response($response, 201);

    }






    public function logout(Request $request){


        $user = Auth::user();
        $user->tokens->each(function($token){
            $token->delete();
        });

       // auth('web')->logout();


            return [ 
                "message"=> "successfully logged out"
            ];

    }



}
