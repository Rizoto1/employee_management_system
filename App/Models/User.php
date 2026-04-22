<?php

namespace App\Models;

use Framework\Core\IIdentity;
use Framework\Core\Model;

class User extends Model implements IIdentity
{
    protected ?int $id = null;
    protected string $username = '';
    protected string $password = '';
    protected ?int $employeeId = null;

    public function __construct(string $username = '', string $password = '', ?int $employeeId = null)
    {
        $this->username = $username;
        $this->setPassword($password);
        $this->employeeId = $employeeId;
    }

    public function getName(): string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?int
    {
        return $this->employeeId;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmployeeId(?int $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}