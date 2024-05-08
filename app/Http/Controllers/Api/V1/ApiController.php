<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        User::create([
            'name'=>$request->name,
            'email'=> $request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json(["status"=>true,"message"=>"Registration Successful"]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where("email",$request->get('email'))->first();
        if (!empty($user)){
            if (Hash::check($request->get('password'), $user->password)){
                $token = $user->createToken('my-app-token')->plainTextToken;
                return response()->json(["status"=>true,"message"=>"Login Successful",'token'=>$token]);
            }
            return response()->json(["status"=>false,"message"=>"Wrong Password"]);
        }
        return response()->json(["status"=>false,"message"=>"Login Failed"]);
    }

    public function profile(): \Illuminate\Http\JsonResponse
    {
        $data = auth()->user();
        return response()->json(["status"=>true,'message'=>'با موفقیت وارد شدید',"user"=>$data]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(["status"=>true,"message"=>"Logout Successful"]);
    }



}
