<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('admin');
        return response([
            'message' => 'create account success',
            'token' => $token->plainTextToken,
        ]);
    }



     // login api
    public function login(Request $request)
    {
 
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        $matchPassword = Hash::check($request->password, $user->password);

        if (!$user || !$matchPassword) {
            return response()->json([
                'message' => "email or password invalid"
            ]);
        }

        return response([
            'message' => 'create account success',
            'token' => $user->createToken('admin')->plainTextToken,
        ]);

    }
 

    // logout api
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => "logout success",
        ]);
    }


    //me
    public function me()
    {
        return response([
            'user_id' => Auth()->user()->id,
            'name' => Auth()->user()->name,
            'email' => Auth()->user()->email,
        ]);
    }
}