<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index(){
        return view('auth/login');
    }
    public function login(Request $request){
        //dd($request->all());
        if(Auth::attempt([
            'email'=>$request->email,
        'password'=>$request->password]) ){
            $user= User::where('email',$request->email)->first();

            if($user->isAdmin()){

                return redirect()->route('dashboard');
            }else{
                return redirect()->route('/');
            }
           // 

        }

//return redirect()->back();
    }


    public function registerindex(){

        return view('auth/register');
    }
}
