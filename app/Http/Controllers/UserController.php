<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Session;

class UserController extends Controller
{
    public function showLogin(){
       // Log::channel('custom-log')->info('custom log return');
        //if(Auth::user()){
        if(Cache::has('userMail')){
            // $userMail = Auth::user()->email;
            $userMail = Cache::get('userMail');
            Log::channel('custom-log')->info($userMail.'has logged in');
            return redirect('/');
        
         }
        
        return view('actions.login');
    }

    public function login(Request $request){
        $rules = [
            'email'=>'required|email',
            'password'=>'required|min:6', 
        ];

        $errorMessage = [
            'required'=>'Tidak Boleh Kosong',
            'email'=>'Format Email Salah',
            'min'=>'minimum 6 karakter'
        ];

        $this->validate($request, $rules, $errorMessage);

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            
            //Cache & Log
            // $userMail = Auth::user()->email;
            $userMail = Cache::remember('userMail', 3*60*60, function(){ //60 sec *60 min = 3h
                return Auth::user()->id;
            });
            // Log::channel('custom-log')->info($userMail.'has logged in');
            if (Cache::has('userMail')){
                Log::channel('custom-log')->info($userMail.'has logged in');
                return redirect('/');
            }
        }else{
            Log::channel('custom-log')->alert('Login Attempts fail from. ', [$request->email, $request->ip()]);
            Session::flash('message', "Credential not match");
            return back()->with(['credError'=>'message']);
        }
    }

    public function logout(){
        $userMail = Auth::user()->email;
        Log::channel('custom-log')->info($userMail.'has logged out');

        Cache::flush();
        session()->flush();
        Auth::logout();
        return redirect('login');
    }

    public function showRegister(){
        return view('actions.register');
    }

    public function storeRegistration(){

    }


}
