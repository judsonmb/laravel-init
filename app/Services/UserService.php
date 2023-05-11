<?php 

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser(array $data)
    {
        $newUser = new User();
        $newUser->name = $data['name'];
        $newUser->email = $data['email'];
        $newUser->password = bcrypt($data['password']);
        $newUser->save();
    }

    public function readUser(int $id)
    {
        return User::where('id', $id)
                ->with('orders')
                ->get();
    }

    public function updateUser(array $data, User $user)
    {
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->password = isset($data['password']) 
                            ? bcrypt($data['password']) 
                            : $user->password;
        $user->save();
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        if ($user == auth()->user()) {
            auth()->user()->token()->revoke();
        }
    }
}