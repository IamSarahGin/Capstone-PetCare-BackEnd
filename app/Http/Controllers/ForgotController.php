<?php

namespace App\Http\Controllers;
use App\Mail\ForgetMail;
use App\Http\Requests\ForgetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotController extends Controller
{
    //Forget password
    public function ForgetPassword(ForgetRequest $request){
        //get the email address
        $email = $request->email;
        //checl if email add does not exist
        if(DB::table("users")->where("email", $email)->doesntExist()){
            return response([
                'message' => 'Invalid Email'
                
                ],401);
        }
        //if email exists
        //generate a pin code
        $token=rand(10,1000000);
        try{
            //insert to password reset
            DB::table('password_reset_tokens')->insert([
                'email'=>$email,
                'token'=>$token
                ]);
                //send mail using forget mail
                Mail::to($email)->send(new ForgetMail($token));
                return response([
                    'message'=>'Reset password mail sent to mail'
                    ],200);
        }catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
