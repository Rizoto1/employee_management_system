<?php

namespace App\Models;

use Framework\Core\Model;

class Attendance extends Model
{
    protected ?int $id = null;
    protected int $employee_id = 0;
    protected string $checkInTime = '';
    protected string $checkOutTime = '';
    protected string $status = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): int
    {
        return $this->employee_id;
    }

    public function getCheckInTime(): string
    {
        return $this->checkInTime;
    }

    public function getCheckOutTime(): string
    {
        return $this->checkOutTime;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setEmployeeId(int $employeeId): void
    {
        $this->employeeID = $employeeId;
    }

    public function setCheckInTime(string $checkInTime): void
    {
        $this->checkInTime = $checkInTime;
    }

    public function setCheckOutTime(string $checkOutTime): void
    {
        $this->checkOutTime = $checkOutTime;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}