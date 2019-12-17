<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Exception;
use App\User;

use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try{
            $googleUser = Socialite::driver('google')->user();
            $registeredUser = User::where('email', $googleUser->email)->first();

            if($registeredUser){
                Auth::loginUsingId($registeredUser->id);
            }else {
                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->password = bcrypt('default');
                $user->save();
                Auth::loginUsingId($user->id);

                // call Auth()->user()->attributeName . e.g Auth()->user()->name will get name from google account, avail: name, photo, email, id, 
            }
            return redirect()->to('/');
        }
        catch(Exception $e){
            return $e;
        }
    }
}
