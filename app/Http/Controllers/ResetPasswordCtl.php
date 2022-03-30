<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordCtl extends Controller
{
  public function resetpassword(Request $request){
        dd('ResetPassword Route');
dd('A');
        $token = $request->input('token');
        dd('B');
        $token_value = DB::table('password_resets')->where('token', $token)->first();
        if (!$passwordResets = $token_value) {

            return response([
                'message' => 'Invalid token!'
            ],status: 400);
        }

        //** @var User $user */
         if(!$user = User::where('email', $passwordResets->email)->frisr()){
             return response([
                'message' => 'User dosn\'t exist!'
             ], status: 404);
         }

         $user->password = Hash::make($request->input(key:'password'));
         $user->save();

         return reponse([
            'message' => 'success'
         ]);
    }
}