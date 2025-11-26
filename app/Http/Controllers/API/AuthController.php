<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email'=>[
                'required',
                'email',
            ],
            'password'=>'required'
        ]);

        if($validation->fails())
        {
            return response([
                "status"=> 422,
                "message"=>$validation->errors()->first(),
                "errors"=>$validation->errors(),
            ],422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $role = $user->getRoleNames()->first();
            $token = $user->createToken('AppName')->plainTextToken;

            return response([
                'status' => 200,
                'message' => 'Login successfully',
                'user' => $user,
                'role' => $role,
                'token' => $token,
            ],200);
        }

        return response([
            'status' => 422,
            'message' => 'User Not Found'
        ],422);

    }

    public function getMyProfile(Request $request)
    {
        $currentuser = $request->user();

        $user = User::find($currentuser->id);
        if(isset($user))
        {
            $response = [
                "status"=>200,
                "message"=>"Profile Fetched Successfully",
                "user"=>$user
            ];
        }else{
            $response = [
                "status"=>422,
                "message"=>"User Not Found"
            ];
        }

        return response($response,$response['status']);
    }
}
