<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    function register(Request $request){
        //return User::create($request->all());
        
        $data = $request->validate([
            'name' => 'required|string|max:225',
            'email' => 'required|email|max:225',
            'password' => 'required|string',
            'phone_number' => 'required|string',
            'gender' => 'required|string',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' =>  $data['email'],
            'password' =>  Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'gender' => $data['gender'],
        ]);

        $token = $user->createToken('API Token')->plainTextToken;
        $code = 200;
        
        return response()->json([
                'statuse' =>'Success',
                'message' =>'Successfull registered',
                'data' => $token,
        ], $code);

    }

    function login(Request $request){
        dd('test');
    }

    function me(Request $request){

    }

    // function resetpassword(Request $request){
    //     dd('testReset');
    // }
}