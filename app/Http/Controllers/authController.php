<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class authController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'data'=>'required|max:255',
            'password'=>'required|min:6',

        ]);

        $user=User::where('email',$request->data)->orWhere('name',$request->data)->first();
        if(  $user && Hash::check($request->password,$user->password)){

            $device_name=$request->post('device_name',$request->userAgent());
            $token=$user->createToken($device_name);
            return response()->json([
                'token'=>$token->plainTextToken ,
                'user'=>$user,
                'status'=>201
            ]);
        }
        return response()->json([
            'massage'=> 'userName OR Passworf Faild',
            'status'=>401

        ],401);

    }

    public function register(Request $request){

        $request->validate([
            'name'=>'required|string|between:2,100',
            'sex'=>[
                'required',
                Rule::in(['male','female']),
            ],
            'country'=>'required|string|between:2,50',
            'date'=>'required|date_format:m-d-Y',
            'email'=>'required|string|email|max:255|unique:users,email',
            'password'=>'required|min:6',
        ]);

        $data=$request->except('password');
        $password=Hash::make($request->password);
        $data['password']=$password;

        $user=User::create($data);
        if($user) {
            return response()->json([
                'user' => $user,
                'status'=>200
            ]);
        }

        return response()->json([
            'message' => 'failed',
        ], 404);
    }

    public function logout($token=null){

        $user=Auth::guard('sanctum')->user();






//        $user->currentAccessToken()->delate();
//        return response()->json(['message' => 'User successfully signed out']);


        if($token===null){
//            $user->currentAccessToken()->delate();
//            return response()->json(['message' => 'User successfully signed out vvv']);
            $user->tokens()->delete();
            return response()->json(['message' => 'User successfully signed out','status'=>200]);
        }else{
            $user->tokens()->where('id', $token)->delete();
            return response()->json(['message' => 'User successfully signed out vvv','status'=>200]);
        }
//        $PersonalAccessToken=  PersonalAccessToken::findToken($token);
//         if(
//             $user->id == $PersonalAccessToken->tokenable_id
//             && get_class($user)== $PersonalAccessToken->tokenable_type
//         ) {
//             $PersonalAccessToken->delete();
//             return response()->json(['message' => 'User successfully signed out']);
//          }
    }
}
