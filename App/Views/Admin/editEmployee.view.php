<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\User $employeeUser */
/** @var \App\Models\Attendance[] $attendances */
/** @var \App\Models\Absence[] $absences */
/** @var \App\Models\Department[] $departments */
/** @var \App\Models\AbsenceType[] $absenceTypes */
/** @var \App\Models\statusType[] $statusTypes */
/** @var string|null $error */
?>

<div class="container">
    <h1>Employee details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <form method="post" action="<?= $link->url('admin.updateEmployee') ?>" id="adminEditEmployeeForm">
                <div style="display: none" class="mb-3">
                    <label for="employeeId" class="form-label">Id</label>
                    <input id="employeeId" type="text" name="employeeId" class="form-control" value="<?= htmlspecialchars($employee->getId(), ENT_QUOTES); ?>" readonly required />
                </div>
                <div style="display: none" class="mb-3">
                    <label for="id" class="form-label">Id</label>
                    <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($employee->getId(), ENT_QUOTES); ?>" readonly required />
                </div>
                <div class="text-center text-danger mb-3" id="error">
                    <?php if(!is_null(@$error)) {?>
                        <?= @$error ?>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="firstName" class="form-label">First name</label>
                    <input id="firstName" type="text" name="firstName" class="form-control" value="<?= htmlspecialchars($employee->getFirstName(), ENT_QUOTES); ?>" required maxlength="50" />
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last name</label>
                    <input id="lastName" type="text" name="lastName" class="form-control" value="<?= htmlspecialchars($employee->getLastName(), ENT_QUOTES); ?>" required maxlength="50" />
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input id="address" type="text" name="address" class="form-control" value="<?= htmlspecialchars($employee->getAddress(), ENT_QUOTES); ?>" required maxlength="100" />
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="text" name="email" class="form-control" value="<?= htmlspecialchars($employee->getEmail(), ENT_QUOTES); ?>" required maxlength="50" />
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone number</label>
                    <input id="phone" type="number" name="phone" class="form-control" value="<?= htmlspecialchars($employee->getPhone(), ENT_QUOTES); ?>" required maxlength="20" />
                </div>
                <div class="mb-3">
                    <label for="birthDate" class="form-label">Birth date</label>
                    <input id="birthDate" type="date" name="birthDate" class="form-control" value="<?= htmlspecialchars($employee->getBirthDate(), ENT_QUOTES); ?>" required" />
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input id="age" type="number" name="age" class="form-control" value="<?= htmlspecialchars($employee->getAge(), ENT_QUOTES); ?>" readonly />
                </div>
                <div class="mb-3">
                    <label for="hireDate" class="form-label">Hire date</label>
                    <input id="hireDate" type="date" name="hireDate" class="form-control" value="<?= htmlspecialchars($employee->getHireDate(), ENT_QUOTES); ?>" required" />
                </div>
                <div class="mb-3">
                    <label for="departmentId" class="form-label">Department: </label>
                    <select name="departmentId" id="departmentId">
                        <option value="0" <?= $employee->getDepartmentId() === null ? 'selected' : '' ?>></option>
                        <?php foreach ($departments as $department) { ?>
                            <option value="<?= htmlspecialchars($department->getId(), ENT_QUOTES); ?>" <?= $employee->getDepartmentId() === $department->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($department->getName(), ENT_QUOTES); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input id="position" type="text" name="position" class="form-control" value="<?= htmlspecialchars($employee->getPosition(), ENT_QUOTES); ?>" required maxlength="50" />
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('admin.show') ?>" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="post" action="<?= $link->url('admin.updateUser') ?>">
                <div class="mb-3" style="display: none">
                    <label for="id" class="form-label">Id</label>
                    <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($employeeUser->getId(), ENT_QUOTES); ?>" readonly required />
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input id="username" type="text" name="username" class="form-control" value="<?= htmlspecialchars($employeeUser->getName(), ENT_QUOTES); ?>" required maxlength="50" />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control" maxlength="100" required/>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('admin.show') ?>" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>

    <a href="<?= $link->url('statistics', ['id' => $employee->getId()]) ?>"
       class="btn btn-sm btn-secondary">
        Statistics
    </a>

    <div class="mb-3">
        <label for="statisticsDate" class="form-label">Filter by date</label>
        <input id="statisticsDate" type="month" name="statisticsDate" class="form-control" value="<?= htmlspecialchars(date('Y-m'), ENT_QUOTES); ?>" required />
    </div>

    <h2>Attendances</h2>
    <?php if (!empty($attendances)) { ?>
        <table id="attendancesTable">
            <tr>
                <th>ID</th>
                <th>Time in</th>
                <th>Time out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($attendances as $attendance) { ?>
                <tr>
                    <td><?= htmlspecialchars($attendance->getId(), ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($attendance->getCheckInTime(), ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($attendance->getCheckOutTime() ?? '-', ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($statusTypes[$attendance->getStatusId() - 1]->getName(), ENT_QUOTES);  ?></td>
                    <td>
                        <a href="<?= $link->url('admin.editAttendance', ['id' => $attendance->getId()]) ?>"
                           class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <a href="<?= $link->url('admin.deleteAttendance', ['id' => $attendance->getId()]) ?>"
                           class="btn btn-sm btn-danger"
                           onclick="confirm('Do you really want to delete attendance?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <h3>No attendances.</h3>
    <?php } ?>

    <h2>Absences</h2>
    <?php if (!empty($absences)) { ?>
        <table id="absencesTable">
            <tr>
                <th>ID</th>
                <th>Absence type</th>
                <th>Start</th>
                <th>End</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($absences as $absence) { ?>
                <tr>
                    <td><?= htmlspecialchars($absence->getId(), ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($absenceTypes[$absence->getAbsenceTypeId() - 1]->getName(), ENT_QUOTES); ?></td>
                    <td><?= htmlspecialchars($absence->getStartDate(), ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($absence->getEndDate()  ?? '-', ENT_QUOTES);  ?></td>
                    <td>
                        <a href="<?= $link->url('admin.editAbsence', ['id' => $absence->getId()]) ?>"
                           class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <a href="<?= $link->url('admin.deleteAbsence', ['id' => $absence->getId()]) ?>"
                           class="btn btn-sm btn-danger"
                           onclick="confirm('Do you really want to delete absence?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <h3>No absences.</h3>
    <?php } ?>
</div>


