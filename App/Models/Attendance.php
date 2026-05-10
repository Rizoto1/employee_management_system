<?php

namespace App\Models;

use Framework\Core\Model;

class Attendance extends Model
{
    protected ?int $id = null;
    protected int $employeeId = 0;
    protected string $checkInTime = '';
    protected ?string $checkOutTime = null;
    protected int $statusId = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getCheckInTime(): string
    {
        return $this->checkInTime;
    }

    public function getCheckOutTime(): ?string
    {
        return $this->checkOutTime;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setEmployeeId(int $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    public function setCheckInTime(string $checkInTime): void
    {
        $this->checkInTime = $checkInTime;
    }

    public function setCheckOutTime(string $checkOutTime): void
    {
        $this->checkOutTime = $checkOutTime;
    }

    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }
}