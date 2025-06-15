<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;

class ProfileController extends Controller
{
     public function image(UserRequest $request)
    {
         $user = User::findOrFail($request->user()->id);

          if(!is_null($user->image)){

            Storage::disk('public')->delete($user->image);
        }

        $user->image= $request->file('image')->storePublicly('images', 'public');

        $user->save();

        return $user;
    }


      /**
     * Display the specified information of the token bearer resource.
     */
    public function show(Request $request)
    {
         return $request->user();
    }

}