<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{   
     /**
     * Log in using the specified resource 
     */
    public function login(UserRequest $request)
    {

    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([ 
            'email' => ['The  credentials are incorrect.'],
        ]);
    }
 
    $response = [
        'user' => $user,
        'token' => $user->createToken($request->email)->plainTextToken
    ];


    return response($response, 200) ;

    }
    


     //Log out functionalities
     public function logout(UserRequest $request)
    {
        $request->user()->tokens()->delete();
        
         $response = ['message' => 'Logout'];

        return response($response, 200) ;

    }
}
