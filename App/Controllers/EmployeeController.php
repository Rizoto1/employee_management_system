<?php

namespace App\Controllers;

use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\StatusType;
use App\Models\User;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use http\Exception\RuntimeException;


class EmployeeController extends BaseController
{
    public function authorize(Request $request, string $action): bool
    {
        return $this->user->isLoggedIn() and !($this->user->isAdmin());
    }

    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function showAbsences(Request $request): Response
    {
        $name = $request->value('name');
        $absences = [];
        $absenceTypes = AbsenceType::getAll();
        if (strcmp($name, $this->user->getName()) !== 0) {
            return $this->html(['error' => "You can only view your own absences.", 'absences' => $absences, 'absenceTypes' => $absenceTypes]);
        }

        $users = User::getAll('`username` = ?', [$name]);
        if(empty($users)) {
            return $this->html(['error' => "User not found.", 'absences' => $absences, 'absenceTypes' => $absenceTypes]);
        }

        $user = $users[0];
        $employeeId = $user->getEmployeeId();
        $employee = Employee::getOne($employeeId);

        $date = date('Y-m');
        [$year, $month] = explode('-', $date);
        $absences = Absence::getAll("`employeeId` = ? AND YEAR(`startDate`) = ? AND MONTH(`startDate`) = ?",
            [$employee->getId(), $year, $month], 'startDate DESC');
        $absenceDays = 0;

        foreach ($absences as $a) {
            $start = new \DateTime($a->getStartDate());
            if ($a->getEndDate() === null) {
                $end = new \DateTime();
            } else {
                $end = new \DateTime($a->getEndDate());
            }
            $absenceDays += $start->diff($end)->days + 1;
        }

        return $this->html(['absences' => $absences, 'absenceTypes' => $absenceTypes, 'employee' => $employee, 'absenceDays' => $absenceDays]);
    }

    public function showAttendances(Request $request): Response
    {
        $name = $request->value('name');
        $attendances = [];
        $statusTypes = StatusType::getAll();
        if (strcmp($name, $this->user->getName()) !== 0) {
            return $this->html(['error' => "You can only view your own absences.", 'attendances' => $attendances, 'statusTypes' => $statusTypes]);
        }

        $users = User::getAll('`username` = ?', [$name]);
        if(empty($users)) {
            return $this->html(['error' => "User not found.", 'attendances' => $attendances, 'statusTypes' => $statusTypes]);
        }

        $user = $users[0];
        $employeeId = $user->getEmployeeId();
        $employee = Employee::getOne($employeeId);

        $date = date('Y-m');
        [$year, $month] = explode('-', $date);
        $attendance = Attendance::getAll("`employeeId` = ? AND YEAR(`checkInTime`) = ? AND MONTH(`checkInTime`) = ?",
            [$employee->getId(), $year, $month], 'checkInTime DESC');

        $attendanceDays = 0;
        $attendanceHours = 0;
        foreach ($attendance as $a) {
            if ($a->getCheckOutTime() !== null) {
                $start = new \DateTime($a->getCheckInTime());
                $end = new \DateTime($a->getCheckOutTime());
                $attendanceHours += ($end->getTimestamp() - $start->getTimestamp()) / 3600;
                $attendanceDays += 1;
            }
        }

        return $this->html(['attendances' => $attendance, 'statusTypes' => $statusTypes, 'employee' => $employee, 'attendanceDays' => $attendanceDays, 'attendanceHours' => $attendanceHours]);
    }

    public function addAbsence(Request $request): Response
    {
        $absenceTypes = AbsenceType::getAll();
        if (!$request->isPost()) {
            return $this->html(['absenceTypes' => $absenceTypes]);
        }

        try {
            $name = $request->value('name');
            if (strcmp($name, $this->user->getName()) !== 0) {
                return $this->html(['error' => "You can only add absences for yourself.", 'absenceTypes' => $absenceTypes]);
            }

            $users = User::getAll('`username` = ?', [$name]);
            if(empty($users)) {
                return $this->html(['error' => "User not found.", 'absenceTypes' => $absenceTypes]);
            }

            $user = $users[0];
            $employeeId = $user->getEmployeeId();
            $values = $request->post();
            $valuesCount = count($values);
            if ($valuesCount < 4) {
                return $this->html(['error' => "Please fill in all required fields!", 'absenceTypes' => $absenceTypes]);
            }

            foreach($values as $value) {
                if ($this->specialChars($value) || $value === '') {
                    return $this->html(['error' => "Invalid input: special characters are not allowed.", 'absenceTypes' => $absenceTypes]);
                }
            }

            $absence = new Absence();
            $absence->setEmployeeId($employeeId);
            $absence->setAbsenceTypeId((int)$request->post('absenceTypeId'));
            $absence->setStartDate($request->post('startDate'));
            if ($request->post('endDate')) {
                $endDate = new \DateTime($request->post('endDate'));
                $startDate = new \DateTime($request->post('startDate'));
                if ($endDate < $startDate) {
                    return $this->html(['error' => "End date cannot be earlier than start date.", 'absenceTypes' => $absenceTypes]);
                }
                $absence->setEndDate($request->post('endDate'));
            }
            $absence->save();

            return $this->redirect($this->url("employee.showAbsences", ['name' => $name]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function editAbsence(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');
            $absence = Absence::getOne($id);
            if (is_null($absence)) {
                throw new HttpException(404);
            }

            $employee = Employee::getOne($absence->getEmployeeId());
            if (is_null($absence)) {
                throw new HttpException(404);
            }

            $absenceType = AbsenceType::getOne($absence->getAbsenceTypeId());

            return $this->html(['error' => $request->value('error'), 'absence' => $absence, 'employee' => $employee,'absenceType' => $absenceType]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function updateAbsence(Request $request): Response
    {
        if (!$request->isPost()) {
            return $this->redirect($this->url("employee.index"));
        }

        try {
            $id = (int)$request->post('id');

            $absence = Absence::getOne($id);
            if (is_null($absence)) {
                throw new HttpException(404);
            }

            $employee = Employee::getOne($absence->getEmployeeId());
            $absenceType = AbsenceType::getOne($absence->getAbsenceTypeId());
            $startDate = new \DateTime($absence->getStartDate());
            $endDate = new \DateTime($request->post('endDate'));

            foreach($request->post() as $value) {
                if ($this->specialChars($value)  || $value === '') {
                    return $this->redirect($this->url("employee.editAbsence",
                        ['error' => 'Invalid input: special character are not allowed.',
                            'id' => $id, 'employee' => $employee,'absenceType' => $absenceType
                        ]));
                }
            }

            if ($endDate < $startDate) {
                return $this->redirect($this->url("employee.editAbsence",
                    ['error' => 'End date cannot be earlier than start date.',
                    'id' => $id, 'employee' => $employee,'absenceType' => $absenceType
                ]));
            }

            $absence->setEndDate($endDate->format('Y-m-d'));
            $absence->save();

            return $this->redirect($this->url("employee.editAbsence", ['id' => $id, 'employee' => $employee,'absenceType' => $absenceType]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function addAttendance (Request $request): Response
    {
        $statusTypes = StatusType::getAll();
        if (!$request->isPost()) {
            return $this->html(['statusTypes' => $statusTypes]);
        }

        try {
            $name = $request->value('name');
            if (strcmp($name, $this->user->getName()) !== 0) {
                return $this->html(['error' => "You can only add attendances for yourself."]);
            }

            $users = User::getAll('`username` = ?', [$name]);
            if(empty($users)) {
                return $this->html(['error' => "User not found."]);
            }

            $user = $users[0];
            $employeeId = $user->getEmployeeId();

            foreach($request->post() as $value) {
                if ($this->specialChars($value) || $value === '') {
                    return $this->html(['error' => "Invalid input: special characters are not allowed.", 'statusTypes' => $statusTypes]);
                }
            }

            $attendance = new Attendance();
            $attendance->setEmployeeId($employeeId);
            $attendance->setStatusId((int)$request->post('statusTypeId'));
            $attendance->setCheckInTime($request->post('checkInTime'));
            $attendance->save();

            return $this->redirect($this->url("employee.showAttendances", ['name' => $name]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function editAttendance(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            $attendance = Attendance::getOne($id);
            if (is_null($attendance)) {
                throw new HttpException(404);
            }

            $employee = Employee::getOne($attendance->getEmployeeId());
            if (is_null($attendance)) {
                throw new HttpException(404);
            }

            $statusType = StatusType::getOne($attendance->getStatusId());

            return $this->html(['error' => $request->value('error'), 'attendance' => $attendance, 'employee' => $employee, 'statusType' => $statusType]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function updateAttendance(Request $request): Response
    {
        if (!$request->isPost()) {
            return $this->redirect($this->url("employee.index"));
        }

        try {
            $id = (int)$request->post('id');

            $attendance = Attendance::getOne($id);
            if (is_null($attendance)) {
                throw new HttpException(404);
            }

            $employee = Employee::getOne($attendance->getEmployeeId());
            $statusType = StatusType::getOne($attendance->getStatusId());
            $checkInTime = new \DateTime($attendance->getCheckInTime());
            $checkOutTime = new \DateTime($request->value('checkOutTime'));

            foreach($request->post() as $value) {
                if ($this->specialChars($value) || $value === '') {
                    return $this->redirect($this->url("employee.editAttendance",
                        ['error' => 'Invalid input: special characters are not allowed.',
                            'id' => $id, 'employee' => $employee,'statusType' => $statusType
                        ]));
                }
            }

            if ($checkOutTime < $checkInTime) {
                return $this->redirect($this->url("employee.editAttendance",
                    ['error' => 'Check out time cannot be earlier than check in time.',
                        'id' => $id, 'employee' => $employee,'statusType' => $statusType
                    ]));
            }

            $attendance->setCheckOutTime($checkOutTime->format('Y-m-d H:i:s'));
            $attendance->save();

            return $this->redirect($this->url("employee.editAttendance", ['id' => $id, 'employee' => $employee, 'statusType' => $statusType]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function editUser(Request $request): Response
    {
        try {
            $name = $request->value('name');
            if (strcmp($name, $this->user->getName()) !== 0) {
                return $this->html(['error' => "You can only edit your own profile."]);
            }

            $users = User::getAll('`username` = ?', [$name]);
            if(empty($users)) {
                return $this->html(['error' => "User not found."]);
            }

            $user = $users[0];
            $employeeId = $user->getEmployeeId();
            $employee = Employee::getOne($employeeId);

            return $this->html(['user' => $user, 'employee' => $employee, 'error' => $request->value('error')]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function updateUser(Request $request): Response
    {
        if (!$request->isPost()) {
            return $this->redirect($this->url("employee.index"));
        }

        try {
            $id = (int)$request->post('id');

            $user = User::getOne($id);
            if (is_null($user)) {
                throw new HttpException(404);
            }

            foreach($request->post() as $value) {
                if ($this->specialChars($value) || $value === '') {
                    return $this->redirect($this->url("employee.editUser",
                        ['error' => 'Input cannot contain special characters.',
                            'name' => $user->getName()
                        ]));
                }
            }

            $user->setUsername($request->post('username'));
            $password = $request->post('password');
            if (!empty($password)) {
                $user->setPassword($request->post('password'));
            }
            $user->save();

            return $this->redirect($this->url("auth.logout"));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function filterStatistics(Request $request): Response
    {
        try {
            $data = $request->json();
            if (!is_object($data)) {
                return $this->json([]);
            }

            $date = $data->date ?? null;
            if ($date === null || $date === '') {
                return $this->json(['absences' => Absence::getAll("`employeeId` = ?", [$data->employeeId]),
                    'attendances' => Attendance::getAll("`employeeId` = ?", [$data->employeeId])]);
            }

            [$year, $month] = explode('-', $date);
            $absence = Absence::getAll("`employeeId` = ? AND YEAR(`startDate`) = ? AND MONTH(`startDate`) = ?",
                [$data->employeeId, $year, $month]);
            $attendance = Attendance::getAll("`employeeId` = ? AND YEAR(`checkInTime`) = ? AND MONTH(`checkInTime`) = ?",
                [$data->employeeId, $year, $month]);

            $absenceDays = 0;
            $attendanceDays = 0;
            $attendanceHours = 0;

            foreach ($absence as $a) {
                $start = new \DateTime($a->getStartDate());
                if ($a->getEndDate() === null) {
                    $end = new \DateTime();
                } else {
                    $end = new \DateTime($a->getEndDate());
                }
                $absenceDays += $start->diff($end)->days + 1;
            }

            foreach ($attendance as $a) {
                if ($a->getCheckOutTime() !== null) {
                    $start = new \DateTime($a->getCheckInTime());
                    $end = new \DateTime($a->getCheckOutTime());
                    $attendanceHours += ($end->getTimestamp() - $start->getTimestamp()) / 3600;
                    $attendanceDays += 1;
                }
            }

            return $this->json([
                'absences' => $absence,
                'attendances' => $attendance,
                'attendanceDays' => $attendanceDays,
                'attendanceHours' => $attendanceHours,
                'absenceDays' => $absenceDays,
                'absenceTypes' => AbsenceType::getAll(),
                'statusTypes' => StatusType::getAll()
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    private function specialChars($str) {
        return preg_match('/[^a-zA-Z0-9@.,:\- ]/', $str) > 0;
    }
}
