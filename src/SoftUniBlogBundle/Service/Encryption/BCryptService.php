<?php


namespace SoftUniBlogBundle\Service\Encryption;


class BCryptService
{

    public function hash(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verify(string $password, string $hash)
    {
        return password_verify($password,$hash);
    }
}