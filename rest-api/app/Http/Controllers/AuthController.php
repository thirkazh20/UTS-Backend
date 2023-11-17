<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{
    //Membuat fitur register
    public function register(Request $request)
    {
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        //Membuat User baru
        $user = User::create($input);

        $data = [
            'message' => 'User is created succsessfully'
        ];

        return response()->json($data, 200);
    }

    //Membuat fitur login
    public function login(Request $request)
    {
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = User::where('email', $input['email'])->first();

        $isLoginSuccessfully = ($input['email'] == $user->email &&
            Hash::check($input['password'], $user->password));

        if ($isLoginSuccessfully) {
            //Membuat token
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong'
            ];

            return response()->json($data, 401);
        }
    }
}
