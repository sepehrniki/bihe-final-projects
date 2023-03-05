<?php

namespace App\Http\Controllers;

use App\Http\Traits\Api;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use Api;

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return $this->FailedResponse(100, $validate->errors());
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return $this->FailedResponse(101);
        }
        elseif (!Hash::check($request->password, $user->password)) {
            return $this->FailedResponse(102);
        }

        $type = match ($user->type) {
            0 => 'user',
            1 => 'admin',
        };
        $token = $user->createToken('API', ["type-{$type}"])->plainTextToken;

        return $this->SuccessResponse([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->SuccessResponse([
            'logout' => true
        ]);
    }
}
