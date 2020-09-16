<?php

namespace App\Repositories;

use App\User;

class UserRepository extends EloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return User::class;
    }
}
