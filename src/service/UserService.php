<?php
namespace App\Service;

use App\Entity\User;

class UserService
{
    public function register(array $data): User
    {
        return User::toObject($data);
    }
}