<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    //login
    public function login(Request $request){
        $validator = validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $token_validaty = 24 * 60;

        $this->guard()->factory()->setTTL($token_validaty);

        if(!$token = $this->guard()->attempt($validator->validated())){
            return response()->json(['error'=> 'Unauthorized'],401);
        }
        return $this->respondWithToken($token);
    }
    //register
    public function register(Request $request){
        $validator = validator::make($request->all(),[
            'name' => 'required|string|between:2,100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
        if($validator->fails()){
            return response()->json([
                $validator->errors()
            ],422);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password)
            ]
        ));

        return response()->json(['message'=> 'Successfully Create User','user'=> $user]);
    }
    //profile
    public function profile(){
        return response()->json($this->guard()->user());
    }
    //refresh
    public function refresh(){
        return $this->respondWithToken($this->guard()->refresh());
    }
    //logout
    public function logout(){
        $this->guard()->logout();
        return response()->json(['Message'=>'User Successfully logout']);
    }
    //guard
    public function guard(){
        return Auth::guard();
    }
    //responseWithToken
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }


}
