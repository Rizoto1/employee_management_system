<?php

namespace App\Models;

use Framework\Core\Model;

class Absence extends Model
{
    protected ?int $id = null;
    protected int $employeeId;
    protected int $absenceTypeId;
    protected string $startDate;
    protected ?string $endDate;
    protected int $statusId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getAbsenceTypeId(): int
    {
        return $this->absenceTypeId;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
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

    public function setAbsenceTypeId(int $absenceTypeId): void
    {
        $this->absenceTypeId = $absenceTypeId;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }
}