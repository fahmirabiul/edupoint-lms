<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): User
    {
        return User::find($id);
    }
}
