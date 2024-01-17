<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = $request->user();

            return response()->json([
                'token' => $user->createToken($request->name)->plainTextToken,
                'name' => $user->name,
                'email' => $user->email,
                'message' => 'Success'
            ], Response::HTTP_ACCEPTED);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        if($user){
            $user->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Succesfully logged out'
            ],Response::HTTP_ACCEPTED);

        }else{
            return response()->json([

            ],Response::HTTP_UNAUTHORIZED);
        }
    }


    public function register(Request $request){
        $user =new User([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'message' => 'User registered',
            'data'=>$user
        ], Response::HTTP_ACCEPTED);

    }
}
