<?php
namespace App\Services;

use OAuth2\Storage\Pdo;

class MyPdo extends Pdo
{
    public function __construct($connection, $config = array())
    {
        parent::__construct($connection, $config);
    }

    protected function checkPassword($user, $password): bool
    {
        return password_verify($password, $user['password']);
    }
}