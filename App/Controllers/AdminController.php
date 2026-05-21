<?php

namespace App\Controllers;

use App\Models\Absence;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Department;
use App\Models\StatusType;
use App\Models\AbsenceType;
use App\Models\User;
use Framework\Core\BaseController;
use Framework\Http\HttpException;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class AdminController
 *
 * This controller manages admin-related actions within the application.It extends the base controller functionality
 * provided by BaseController.
 *
 * @package App\Controllers
 */
class AdminController extends BaseController
{
    /**
     * Authorizes actions in this controller.
     *
     * This method checks if the user is logged in, allowing or denying access to specific actions based
     * on the authentication state.
     *
     * @param string $action The name of the action to authorize.
     * @return bool Returns true if the user is logged in; false otherwise.
     */
    public function authorize(Request $request, string $action): bool
    {
        return $this->user->isLoggedIn() and $this->user->isAdmin();
    }

    /**
     * Displays the index page of the admin panel.
     *
     * This action requires authorization. It returns an HTML response for the admin dashboard or main page.
     *
     * @return Response Returns a response object containing the rendered HTML.
     */
    public function index(Request $request): Response
    {
        return $this->html();
    }

    public function addEmployee(Request $request): Response
    {
        if (!$request->isPost()) {
            return $this->html(['departments' => Department::getAll()]);
        }

        $employee = new Employee();
        $values = $request->post();
        $numberOfValues = count($values);

        if ($numberOfValues < 8) {
            return $this->html(['departments' => Department::getAll(), 'error' => 'Please fill in all required fields!']);
        }

        foreach ($values as $value) {
            if ($this->specialChars($value) || $value === '') {
                return $this->html(['departments' => Department::getAll(), 'error' => 'Invalid characters!']);
            }
        }

        $employee->setFirstName($request->post('firstName'));
        $employee->setLastName($request->post('lastName'));

        //email
        if (filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)) {
            $employee->setEmail($request->post('email'));
        } else {
            return $this->html(['departments' => Department::getAll(), 'error' => 'Invalid email format!']);
        }

        //phone
        if (is_numeric($request->post('phone'))) {
            $employee->setPhone($request->post('phone'));
        } else {
            return $this->html(['departments' => Department::getAll(), 'error' => 'Phone number must be numeric!']);
        }

        $employee->setAddress($request->post('address'));

        $employee->setBirthDate($request->post('birthDate'));
        if ($employee->getAge() < 18) {
            return $this->html(['departments' => Department::getAll(), 'error' => 'Employee must be at least 18 years old!']);
        }

        $employee->setDepartmentId($request->post('departmentId') !== '0' ? (int)$request->post('departmentId') : null);
        $employee->setPosition($request->post('position'));
        $employee->setHireDate($request->post('hireDate'));
        $employee->save();

        $employeeId = $employee->getId();
        $user = new User();
        $result = strtolower(substr($employee->getFirstName(), 0, 1) . $employee->getLastName());
        $user->setUsername($result);
        $user->setPassword($result);
        $user->setEmployeeId($employeeId);
        $user->save();

        return $this->html(['departments' => Department::getAll()]);
    }

    public function editEmployee(Request $request): Response
    {
        try {
            $id = $request->value('id');
            $user = User::getAll('`employeeId` LIKE ?', [$id])[0];

            if (is_null($user)) {
                throw new HttpException(404);
            }

            $date = date('Y-m');
            [$year, $month] = explode('-', $date);
            $absence = Absence::getAll("`employeeId` = ? AND YEAR(`startDate`) = ? AND MONTH(`startDate`) = ?",
                [$id, $year, $month]);
            $attendance = Attendance::getAll("`employeeId` = ? AND YEAR(`checkInTime`) = ? AND MONTH(`checkInTime`) = ?",
                [$id, $year, $month]);

            return $this->html(
                [
                    'error' => $request->value('error'),
                    'employee' => Employee::getOne($id),
                    'attendances' => $attendance,
                    'absences' => $absence,
                    'departments' => Department::getAll(),
                    'absenceTypes' => AbsenceType::getAll(),
                    'statusTypes' => StatusType::getAll(),
                    'employeeUser' => $user
                ]
            );
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function updateEmployee(Request $request): Response {
        if (!$request->isPost()) {
            return $this->redirect($this->url("admin.editEmployee",
                ['id' => $request->post('id'), 'error' => 'Invalid request method!']));
        }

        $employee = Employee::getOne((int)$request->post('id'));
        if (is_null($employee)) {
            throw new HttpException(404);
        }

        $values = $request->post();
        $numberOfValues = count($values);

        if ($numberOfValues < 8) {
            return $this->redirect($this->url("admin.editEmployee",
                ['id' => $request->post('id'), 'error' => 'Please fill in all required fields!']));
        }

        foreach ($values as $val) {
            if ($this->specialChars($val) || $val === '') {
                return $this->redirect($this->url("admin.editEmployee",
                    ['id' => $request->post('id'), 'error' => 'Invalid characters!']));
            }
        }

        $employee->setFirstName($request->post('firstName'));
        $employee->setLastName($request->post('lastName'));

        //email
        if (filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)) {
            $employee->setEmail($request->post('email'));
        } else {
            return $this->redirect($this->url("admin.editEmployee",
                ['id' => $request->post('id'), 'error' => 'Invalid email format!']));
        }

        //phone
        if (is_numeric($request->post('phone'))) {
            $employee->setPhone($request->post('phone'));
        } else {
            return $this->redirect($this->url("admin.editEmployee",
                ['id' => $request->post('id'), 'error' => 'Phone number must be numeric!']));
        }

        $employee->setAddress($request->post('address'));

        $employee->setBirthDate($request->post('birthDate'));
        if ($employee->getAge() < 18) {
            return $this->redirect($this->url("admin.editEmployee",
                ['id' => $request->post('id'), 'error' => 'Employee must be at least 18 years old!']));
        }

        $employee->setDepartmentId($request->post('departmentId') !== '0' ? (int)$request->post('departmentId') : null);
        $employee->setPosition($request->post('position'));
        $employee->setHireDate($request->post('hireDate'));

        $employee->save();

        return $this->redirect($this->url("admin.editEmployee",
            ['id' => $request->post('id')]));
    }

    public function deleteEmployee(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            $employee = Employee::getOne($id);
            if (is_null($employee)) {
                throw new HttpException(404);
            }

            $employee->deleteRelated();
            $employee->delete();

        } catch (Exception $e) {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url("admin.show"));
    }

    public function updateUser(Request $request): Response
    {
        try {
            if (!$request->isPost()) {
                $user = User::getOne((int)$request->value('id'));
                return $this->redirect($this->url("admin.editEmployee",
                    ['id' => $user->getEmployeeId()]));
            }

            $id = (int)$request->post('id');

            $user = User::getOne($id);
            if (is_null($user)) {
                throw new HttpException(404);
            }

            if (count($request->post()) < 2) {
                return $this->redirect($this->url("admin.editEmployee",
                    ['error' => 'Please fill in all required fields.', 'id' => $user->getEmployeeId()]));
            }

            foreach($request->post() as $value) {
                if ($this->specialChars($value) || $value === '') {
                    return $this->redirect($this->url("admin.editEmployee",
                        ['error' => 'Input cannot contain special characters.', 'id' => $user->getEmployeeId()]));
                }
            }

            $user->setUsername($request->post('username'));
            $user->setPassword($request->post('password'));
            $user->save();

            return $this->redirect($this->url("admin.editEmployee",
                ['id' => $user->getEmployeeId()]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function show(Request $request): Response
    {
        try {
            $page = (int)($request->value('page') ?? 1);
            if ($page < 1) {
                $page = 1;
            }
            $perPage = 20;
            $offset = ($page - 1) * $perPage;
            $employees = Employee::getAll(
                orderBy: 'id ASC',
                limit: $perPage,
                offset: $offset
            );
            $totalEmployees = count(Employee::getAll());
            $totalPages = ceil($totalEmployees / $perPage);
            $statuses = [];

            foreach ($employees as $employee) {
                $statuses[$employee->getId()] = $employee->getEmployeeStatus();
            }

            return $this->html(
                [
                    'employees' => $employees,
                    'statuses' => $statuses,
                    'currentPage' => $page,
                    'totalPages' => $totalPages
                ]
            );
        } catch (\Exception $e) {
            throw new \HttpException(500, "DB Error: " . $e->getMessage());
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
            if (is_null($employee)) {
                throw new HttpException(404);
            }

            $statusTypes = StatusType::getAll();

            return $this->html(['attendance' => $attendance, 'employee' => $employee, 'statusTypes' => $statusTypes, 'error' => $request->value('error')]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function updateAttendance(Request $request): Response
    {
        try {
            $id = (int)$request->post('id');

            $attendance = Attendance::getOne($id);
            if (is_null($attendance)) {
                throw new HttpException(404);
            }

            $values = $request->post();
            $numberOfValues = count($values);
            if ($numberOfValues < 3) {
                return $this->redirect($this->url("admin.editAttendance",
                    ['id' => $attendance->getId(), 'error' => 'Please fill in all required fields!']));
            }

            $checkInTime = $request->post('checkInTime');
            $checkOutTime = $request->post('checkOutTime');
            if (new \Datetime($checkInTime) > new \Datetime($checkOutTime)) {
                return $this->redirect($this->url("admin.editAttendance",
                    ['id' => $attendance->getId(), 'error' => 'Check-out time cannot be before check-in time!']));
            }

            $attendance->setCheckInTime($checkInTime);
            $attendance->setCheckOutTime($checkOutTime);
            $attendance->setStatusId($request->post('statusId'));
            $attendance->save();

            return $this->redirect($this->url("admin.editAttendance",
                ['id' => $attendance->getId()]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function deleteAttendance(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            $attendance = Attendance::getOne($id);
            if (is_null($attendance)) {
                throw new HttpException(404);
            }

            $attendance->delete();

        } catch (Exception $e) {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url("admin.editEmployee",
            ['id' => $attendance->getEmployeeId()]));
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
            if (is_null($employee)) {
                throw new HttpException(404);
            }

            $statusTypes = StatusType::getAll();
            $absenceTypes = AbsenceType::getAll();

            return $this->html(['absence' => $absence, 'employee' => $employee, 'statusTypes' => $statusTypes, 'absenceTypes' => $absenceTypes, 'error' => $request->value('error')]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function filterEmployees(Request $request): Response
    {
        try {
            $data = $request->json();

            $employees = Employee::getAll();
            $statuses = [];
            foreach ($employees as $employee) {
                $statuses[$employee->getId()] = $employee->getEmployeeStatus();
            }

            if (!is_object($data)) {
                return $this->json(['employees' => $employees,
                    'departments' => Department::getAll(),
                    'statuses' => $statuses]);
            }

            $filter = $data->filter ?? null;
            $filterValue = $data->filterValue ?? null;

            if ($filter === null || $filterValue === null || $filterValue === '') {
                return $this->json(['employees' => $employees,
                    'departments' => Department::getAll(),
                    'statuses' => $statuses]);
            }

            if ($filter === 'department') {
                $departments = Department::GetAll("`name` LIKE ?", ["%$filterValue%"]);
                if(empty($departments)) {
                    return $this->json(['employees' => $employees,
                                        'departments' => Department::getAll(),
                                        'statuses' => $statuses]);
                }

                $employees = [];
                foreach($departments as $department) {
                    $employees += Employee::getAll("`departmentId` = ?", [$department->getId()]);
                }
            } else {
                $employees = Employee::getAll("`$filter` LIKE ?", ["%$filterValue%"]);
            }

            $statuses = [];
            foreach ($employees as $employee) {
                $statuses[$employee->getId()] = $employee->getEmployeeStatus();
            }

            return $this->json(['employees' => $employees,
                                'departments' => Department::getAll(),
                                'statuses' => $statuses]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function updateAbsence(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            $absence = Absence::getOne($id);
            if (is_null($absence)) {
                throw new HttpException(404);
            }

            $values = $request->post();
            $numberOfValues = count($values);
            if ($numberOfValues < 3) {
                return $this->redirect($this->url("admin.editAbsence",
                    ['id' => $absence->getId(), 'error' => 'Please fill in all required fields!']));
            }

            $startDate = $request->post('startDate');
            $endDate = $request->post('endDate');
            if (new \Datetime($startDate) > new \Datetime($endDate)) {
                return $this->redirect($this->url("admin.editAbsence",
                    ['id' => $absence->getId(), 'error' => 'End date cannot be before start date!']));
            }

            $absence->setStartDate($startDate);
            $absence->setEndDate($endDate);
            $absence->setAbsenceTypeId($request->post('absenceId'));
            $absence->save();

            return $this->redirect($this->url("admin.editAbsence",
                ['id' => $absence->getId()]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    public function deleteAbsence(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');
            $absence = Absence::getOne($id);

            if (is_null($absence)) {
                throw new HttpException(404);
            }

            $absence->delete();

        } catch (Exception $e) {
            throw new HttpException(500, 'DB Error: ' . $e->getMessage());
        }

        return $this->redirect($this->url("admin.editEmployee", ['id' => $absence->getEmployeeId()]));

    }

    public function statistics(Request $request): Response
    {
        $employee = Employee::getOne($request->value('id'));
        if (is_null($employee)) {
            throw new HttpException(404);
        }

        $date = date('Y-m');
        [$year, $month] = explode('-', $date);

        $attendances = Attendance::getAll("`employeeId` = ? AND YEAR(`checkInTime`) = ? AND MONTH(`checkInTime`) = ?",
                                        [$employee->getId(), $year, $month]);
        $absences = Absence::getAll("`employeeId` = ? AND YEAR(`startDate`) = ? AND MONTH(`startDate`) = ?",
                                    [$employee->getId(), $year, $month]);
        $absenceTypes = AbsenceType::getAll();
        $statusTypes = StatusType::getAll();

        $absenceDays = 0;
        $attendanceDays = 0;
        $attendanceHours = 0;

        foreach ($absences as $a) {
            $start = new \DateTime($a->getStartDate());
            if ($a->getEndDate() === null) {
                $end = new \DateTime();
            } else {
                $end = new \DateTime($a->getEndDate());
            }
            $absenceDays += $start->diff($end)->days + 1;
        }

        foreach ($attendances as $a) {
            $start = new \DateTime($a->getCheckInTime());
            if ($a->getCheckOutTime() === null) {
                $end = new \DateTime();
            } else {
                $end = new \DateTime($a->getCheckOutTime());
            }
            $attendanceHours += ($end->getTimestamp() - $start->getTimestamp()) / 3600;
            $days = $start->diff($end)->days + 1;
            $attendanceDays += $days;
        }

        return $this->html(['employee' => $employee, 'attendances' => $attendances, 'absences' => $absences, 'absenceTypes' => $absenceTypes, 'statusTypes' => $statusTypes,
            'attendanceDays' => $attendanceDays, 'attendanceHours' => $attendanceHours, 'absenceDays' => $absenceDays]);
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
                $absences = [];
                $attendances = [];
                return $this->json([
                    'absences' => $absences,
                    'attendances' => $attendances,
                    'attendanceDays' => 0,
                    'attendanceHours' => 0,
                    'absenceDays' => 0,
                    'absenceTypes' => AbsenceType::getAll(),
                    'statusTypes' => StatusType::getAll()
                ]);
            }

            [$year, $month] = explode('-', $date);
            $absences = Absence::getAll("`employeeId` = ? AND YEAR(`startDate`) = ? AND MONTH(`startDate`) = ?",
                [$data->employeeId, $year, $month]);
            $attendances = Attendance::getAll("`employeeId` = ? AND YEAR(`checkInTime`) = ? AND MONTH(`checkInTime`) = ?",
                [$data->employeeId, $year, $month]);

            $absenceDays = 0;
            $attendanceDays = 0;
            $attendanceHours = 0;

            foreach ($absences as $a) {
                $start = new \DateTime($a->getStartDate());
                if ($a->getEndDate() === null) {
                    $end = new \DateTime();
                } else {
                    $end = new \DateTime($a->getEndDate());
                }
                $absenceDays += $start->diff($end)->days + 1;
            }

            foreach ($attendances as $a) {
                $start = new \DateTime($a->getCheckInTime());
                if ($a->getCheckOutTime() === null) {
                    $end = new \DateTime();
                } else {
                    $end = new \DateTime($a->getCheckOutTime());
                }
                $attendanceHours += ($end->getTimestamp() - $start->getTimestamp()) / 3600;
                $days = $start->diff($end)->days + 1;
                $attendanceDays += $days;
            }

            return $this->json([
                'absences' => $absences,
                'attendances' => $attendances,
                'attendanceDays' => $attendanceDays,
                'attendanceHours' => $attendanceHours,
                'absenceDays' => $absenceDays,
                'absenceTypes' => AbsenceType::getAll(),
                'statusTypes' => StatusType::getAll()
            ]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Error: " . $e->getMessage());
        }
    }

    private function specialChars(string $str): bool {
        return preg_match('/[^a-zA-ZÀ-ž0-9@.,:\- ]/', $str) > 0;
    }
}
