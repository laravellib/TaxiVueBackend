<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\User;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->where('email_verified_at', '<>', NULL)->first();
        


        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            if(!$user) {
                return [
                    'message' => 'Je moet eerst je email adres bevestigen voordat je toegang hebt tot je account',
                   'verified' => "false"            
                ];                       
           }
           else{
            return response()->json(Auth::user(), 200);

           }

        }
        else{ 
   
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        }


    public function logout()
    {
        Auth::logout();
    }
}