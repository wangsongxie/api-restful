<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth' ,  ['except' => ['authenticate']]);
    }
    public function index()
    {
    }

    public function authenticate(Request $request)
    {
        $cr = $request->only("mobile" ,'password') ;
        try {
            if( !$token = JWTAuth::attempt($cr))
            {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $exception) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
}
