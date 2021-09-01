<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create(array_merge($request->all(), [
            "password" => bcrypt($request->password)
        ]));

        $role = Role::where('name', 'developer')->first();
        User::where('id',$user->id)->first()->assignRole($role);


        $success = [
            'token' => $user->createToken('MyAppToken')->plainTextToken,
            'name' => $user->name
        ];

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            $user = auth()->user();

            $success = [
                'token' => $user->createToken('MyApp')->plainTextToken,
                'name' => $user->name
            ];
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User successfully signed out']);
    }
}
