<?php

namespace App\Http\Controllers;

use App\Http\Traits\Api;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Api;

    public function create(Request $request)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $validate = Validator::make($request->all(), [
                'firstname' => ['required', 'string'],
                'lastname' => ['required', 'string'],
                'username' => ['required', 'string', 'unique:App\Models\User,username'],
                'password' => ['required', 'string', 'min_digits:8'],
                'type' => ['in:0,1'],
                'confirm_password' => ['required', 'same:password'],
            ]);

            if ($validate->fails()) {
                return $this->FailedResponse(100, $validate->errors());
            }

            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'type' => $request->type ?: 0,
            ]);

            return $this->SuccessResponse([
                'registered' => true,
                'user' => $user
            ]);
        }
        else {
            return $this->FailedResponse(500);
        }
    }

    public function edit(Request $request)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $validate = Validator::make($request->all(), [
                'id' => ['required', 'exists:App\Models\User,id'],
                'firstname' => ['string'],
                'lastname' => ['string'],
                'username' => ['string', 'unique:App\Models\User,username'],
                'password' => ['string', 'min_digits:8'],
                'type' => ['in:0,1'],
            ]);

            if ($validate->fails()) {
                return $this->FailedResponse(100, $validate->errors());
            }

            $user = User::find($request->id);

            if ($request->firstname)
                $user->firstname = $request->firstname;

            if ($request->lastname)
                $user->lastname = $request->lastname;

            if ($request->username)
                $user->username = $request->username;

            if ($request->password)
                $user->password = Hash::make($request->password);

            if ($request->type)
                $user->type = $request->type;

            $user = $user->save();

            return $this->SuccessResponse([
                'updated' => true,
                'user' => $user
            ]);
        }
        else {
            return $this->FailedResponse(500);
        }
    }

    public function delete(Request $request)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $deleted = User::where('id', $request->id)->delete();

            return $this->SuccessResponse([
                'deleted' => (bool)$deleted
            ]);
        }
        else {
            return $this->FailedResponse(500);
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $user = User::where('id', $id)->first();

            if ($user) {
                return $this->SuccessResponse([
                    'user' => $user,
                ]);
            }
            else {
                return $this->FailedResponse(103);
            }
        }
        else {
            return $this->FailedResponse(500);
        }
    }

    public function list(Request $request)
    {
        if ($request->user()->tokenCan('type-admin')) {
            $users = User::simplePaginate(20);

            return $this->SuccessResponse([
                'count' => User::count(),
                'users' => $users,
            ]);
        }
        else {
            return $this->FailedResponse(500);
        }
    }
}
