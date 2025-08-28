<?php

namespace App;

class Profile
{
    public string $username;
    public bool $isAdmin = false;

    public function __construct(string $u, bool $isAdmin = false)
    {
        $this->username = $u;
        $this->isAdmin = $isAdmin;
    }

    public function __toString(): string
    {
        return "User: {$this->username}, Role: " . ($this->isAdmin ? "Admin" : "User");
    }
}