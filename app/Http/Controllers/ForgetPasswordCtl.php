<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request\ForgetRequest;
// use Illuminate\Http\Request\ResetRequest;
use App\Http\Requests\ForgetRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Mail\MailtrapSender;
use Illuminate\Support\Facades\Mail;


class ForgetPasswordCtl extends Controller
{
   public function forgetpassword(ForgetRequest $request){
            // dd('ForgetPassword Controller');
            $email = $request->input('email');
            
            if(User::where('email', $email)->doesntExist()){
                return response([
                    'message' => 'User dosn\'t exits!'
                ], 404);
            }

            $token = Str::random(10);
            
            try{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            // Mail::send(view: 'Mails.forget', ['token' => $token], function (Message $message) use ($email){

            //     $message->to($email);
            //     $message->subject(subject:'Reset your password');
            // });

            if(Mail::to('dipakchandore@gmail.com')->send(new MailtrapSender($token))){
                return response([
                    'message' => 'Check your email !'
                ]);
            }

            return response([
                'message' => 'Failed to send mail'
            ], 400);

        }catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function resetpassword(ResetRequest $request){
        //dd('Reset password is start');
        $token = $request->input('token');
        
        $token_value = DB::table('password_resets')->where('token', $token)->first();
        //dd($token_value);
        if (!$passwordResets = $token_value) {
           // dd($passwordResets);
            return response([
                'message' => 'Invalid token!'
            ],status: 400);
        }
        
        //** @var User $user */
         if(!$user = User::where('email', $passwordResets->email)->first()){
            //dd(User);
            return response([
                'message' => 'User dosn\'t exist!'
             ], status: 404);
         }

         $user->password = Hash::make($request->input(key:'password'));
         $user->save();
         dd($user);
         return response([
            'message' => 'successfully'
         ]);
    }
}