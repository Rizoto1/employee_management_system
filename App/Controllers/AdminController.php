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
        $employee->setFirstName($request->post('firstName'));
        $employee->setLastName($request->post('lastName'));
        $employee->setEmail($request->post('email'));
        $employee->setPhone($request->post('phone'));
        $employee->setAddress($request->post('address'));
        $employee->setBirthDate($request->post('birthDate'));
        $employee->setDepartmentId(null);
        $employee->setPosition($request->post('position'));
        $employee->setHireDate($request->post('hireDate'));
        $employee->save();

        $employeeId = $employee->getId();
        $user = new User();
        $result = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $employee->getLastName()));
        $user->setUsername($result);
        $user->setPassword($result);
        $user->setEmployeeId($employeeId);

        $user->save();
        return $this->html(['departments' => Department::getAll()]);
    }

    public function editEmployee(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            return $this->html(
                [
                    'employee' => Employee::getOne($id),
                    'attendances' => Attendance::getAll('`employeeId` LIKE ?', [$id]),
                    'absences' => Absence::getAll('`employeeId` LIKE ?', [$id]),
                    'departments' => Department::getAll()
                ]
            );
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function updateEmployee(Request $request): Response {
        if (!$request->isPost()) {
            return $this->redirect($this->url("admin.editEmployee", ['id' => $request->post('id')]));
        }

        $employee = Employee::getOne((int)$request->post('id'));
        if (is_null($employee)) {
            throw new HttpException(404);
        }

        $employee->setFirstName($request->post('firstName'));
        $employee->setLastName($request->post('lastName'));
        $employee->setEmail($request->post('email'));
        $employee->setPhone($request->post('phone'));
        $employee->setAddress($request->post('address'));
        $employee->setBirthDate($request->post('birthDate'));
        $employee->setDepartmentId($request->post('departmentId') !== '0' ? (int)$request->post('departmentId') : null);
        $employee->setPosition($request->post('position'));
        $employee->setHireDate($request->post('hireDate'));

        $employee->save();

        return $this->redirect($this->url("admin.editEmployee", ['id' => $request->post('id')]));
    }

    public function deleteEmployee(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            $employee = Employee::getOne($id);
            if (is_null($employee)) {
                throw new HttpException(404);
            }

            Employee::deleteRelated($id);
            $employee->delete();

        } catch (Exception $e) {
            throw new HttpException(500, 'DB Error:: ' . $e->getMessage());
        }

        return $this->redirect($this->url("admin.show"));
    }

    public function show(Request $request): Response
    {
        try {
            return $this->html(
                [
                    'employees' => Employee::getAll()
                ]
            );
        } catch (\Exception $e) {
            throw new \HttpException(500, "DB Chyba: " . $e->getMessage());
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

            $statusTypes = StatusType::getAll();

            return $this->html(['attendance' => $attendance, 'employee' => $employee, 'statusTypes' => $statusTypes]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function updateAttendance(Request $request): Response
    {
        try {
            $id = (int)$request->value('id');

            $attendance = Attendance::getOne($id);
            if (is_null($attendance)) {
                throw new HttpException(404);
            }

            $attendance->setCheckInTime($request->post('checkInTime'));
            $attendance->setCheckOutTime($request->post('checkOutTime'));
            $attendance->setStatusId($request->post('statusId'));
            $attendance->save();

            return $this->redirect($this->url("admin.editAttendance", ['id' => $attendance->getId()]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
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
            throw new HttpException(500, 'DB Error:: ' . $e->getMessage());
        }

        return $this->redirect($this->url("admin.editEmployee", ['id' => $attendance->getEmployeeId()]));
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

            $statusTypes = StatusType::getAll();
            $absenceTypes = AbsenceType::getAll();

            return $this->html(['absence' => $absence, 'employee' => $employee, 'statusTypes' => $statusTypes, 'absenceTypes' => $absenceTypes]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
        }
    }

    public function filter(Request $request): Response
    {
        try {
            $data = $request->json();

            if (!is_object($data)) {
                return $this->json([]);
            }

            $filter = $data->filter ?? null;
            $filterValue = $data->filterValue ?? null;

            if (empty($filter) || empty($filterValue)) {
                $employees = Employee::getAll();
                return $this->json(['employees' => $employees,
                    'departments' => Department::getAll()]);
            }

            $allowedFilters = [
                'firstName',
                'lastName',
                'email',
                'hireDate',
                'department',
                'position'
            ];

            if (!in_array($filter, $allowedFilters)) {
                return $this->json([]);
            }

            if ($filter === 'department') {
                $departments = Department::GetAll("`name` LIKE ?", ["%$filterValue%"]);
                if(empty($departments)) {
                    return $this->json(['employees' => Employee::getAll(),
                                        'departments' => Department::getAll()]);
                }
                $department = $departments[0];
                $employees = Employee::getAll("`departmentId` = ?", [$department->getId()]);
            } else {
                $employees = Employee::getAll("`$filter` LIKE ?", ["%$filterValue%"]);
            }

            return $this->json(['employees' => $employees,
                                'departments' => Department::getAll()]);
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
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


            $absence->setStartDate($request->post('startDate'));
            $absence->setEndDate($request->post('endDate'));
            $absence->setStatusId($request->post('statusId'));
            $absence->setAbsenceTypeId($request->post('absenceId'));
            $absence->save();

            return $this->redirect($this->url("admin.editAbsence", ['id' => $absence->getId()]));
        } catch (\Exception $e) {
            throw new HttpException(500, "DB Chyba: " . $e->getMessage());
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
            throw new HttpException(500, 'DB Error:: ' . $e->getMessage());
        }

        return $this->redirect($this->url("admin.editEmployee", ['id' => $absence->getEmployeeId()]));

    }

    public function statistics(Request $request): Response
    {
        $employee = Employee::getOne($request->post('employeeId'));
        if (is_null($employee)) {
            throw new HttpException(404);
        }

        $attendance = Attendance::getAll("`employeeId` = ?", [$employee->getId()]);
        $absence = Absence::getAll("`employeeId` = ?", [$employee->getId()]);


    }
}
