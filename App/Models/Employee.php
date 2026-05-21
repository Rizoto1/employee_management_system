<?php

namespace App\Models;

use Framework\Core\Model;
use Framework\DB\Connection;

class Employee extends Model
{
    protected ?int $id = null;
    protected string $firstName = '';
    protected string $lastName = '';
    protected string $birthDate = '';
    protected string $address = '';
    protected string $email = '';
    protected string $phone = '';
    protected string $position = '';
    protected ?int $departmentId = null;
    protected string $hireDate = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function getDepartment(): ?Department
    {
        return Department::getOne($this->departmentId);
    }

    public function getHireDate(): string
    {
        return $this->hireDate;
    }

    public function getAge(): int
    {
        $birthDate = new \DateTime($this->birthDate);
        $age = (new \DateTime())->diff($birthDate)->y;
        return $age;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function setDepartmentId(?int $departmentId): void
    {
        $this->departmentId = $departmentId;
    }

    public function setDepartment(?string $name): void
    {
        $dep = Department::getAll('`name` LIKE ?', [$name]);
        if (!empty($dep)) {
            $this->departmentId = $dep[0]->getId();
        }
    }

    public function setHireDate(string $hireDate): void
    {
        $this->hireDate = $hireDate;
    }

    public function deleteRelated(): void
    {
        $id = $this->id;
        $con = Connection::getInstance();
        $stmt = $con->prepare("DELETE FROM users WHERE employeeId = :id");
        $stmt->execute(['id' => $id]);

        $stmt = $con->prepare("DELETE FROM absences WHERE employeeId = :id");
        $stmt->execute(['id' => $id]);

        $stmt = $con->prepare("DELETE FROM attendances WHERE employeeId = :id");
        $stmt->execute(['id' => $id]);
    }

    public function getEmployeeStatus(): string {
        $id = $this->id;
        $absences = Absence::getAll('`employeeId` LIKE ?', [$id], 'startDate DESC');
        $attendances = Attendance::getAll('`employeeId` LIKE ?', [$id], 'checkInTime DESC');

        $latestAbsence = !empty($absences) ? $absences[0] : null;
        $latestAttendance = !empty($attendances) ? $attendances[0] : null;

        $status = 'Absent';

        if ($latestAbsence && !$latestAbsence->getEndDate()) {
            $status = AbsenceType::getOne($latestAbsence->getAbsenceTypeId())->getName();
        } else if ($latestAttendance && !$latestAttendance->getCheckOutTime()) {
            $status = StatusType::getOne($latestAttendance->getStatusId())->getName();
        }

        return $status;
    }
}