<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    //reset request
    public function ResetPassword(ResetRequest $request){
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);
        $emailcheck=DB::table("password_reset_tokens")->where("email",$email)->first();
        $pincheck=DB::table("password_reset_tokens")->where("token",$token)->first();
        if(!$emailcheck){
            return response([
                'message'=>'Email not found'
                ],401);
        }
        if(!$pincheck){
            return response([
                'message'=>'Pin not found'
                ],401);
        }
        //update password user table
        DB::table('users')->where('email',$email)->update(['password'=>$password]);
        //delete the email entry in password_resets
        DB::table('password_reset_tokens')->where('email',$email)->delete();
        //return a message
        return response([
            'message' =>'Password Change Successfully'
            ]);
    }
}
