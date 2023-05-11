<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Models\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('user.is.admin');
    }

    public function create(CreateUserRequest $request)
    {
        (new UserService)->createUser($request->all());
        return response()->json(['message' => 'created successfully!'], 200);
    }

    public function read(Request $request, int $id)
    {
        $user = (new UserService)->readUser($id);
        return response()->json(['data' => $user], 200);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        (new UserService)->updateUser($request->all(), $user);
        return response()->json(['message' => 'updated successfully!'], 200);
    }

    public function delete(Request $request, User $user)
    {
        (new UserService)->deleteUser($user);
        return response()->json(['message' => 'deleted successfully!'], 200);
    }
}
