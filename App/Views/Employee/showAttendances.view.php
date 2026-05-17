<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Attendance[] $attendances */
/** @var \App\Models\StatusType[] $statusTypes */
/** @var string $error */
/** @var \App\Models\Employee $employee */
/** @var $attendanceDays */
/** @var $attendanceHours */
?>

<div class="container">
    <h2>Attendances</h2>
    <div class="text-center text-danger mb-3">
        <?= @$error ?>
    </div>

    <div>
        <input type="hidden" id="employeeId" value="<?= htmlspecialchars($employee->getId(), ENT_QUOTES); ?>">
    </div>

    <div class="mb-3">
        <label for="statisticsDateEmp" class="form-label">Filter by date</label>
        <input id="statisticsDateEmp" type="month" name="statisticsDateEmp" class="form-control" value="<?= htmlspecialchars(date('Y-m'), ENT_QUOTES); ?>" required />
    </div>

    <div class="mb-3">
        <table id="statisticsTable">
            <tr>
                <th>Total days worked</th>
                <th>Total hours worked</th>
            </tr>
            <tr>
                <td id="attendanceDays"><?= htmlspecialchars($attendanceDays, ENT_QUOTES)?></td>
                <td id="attendanceHours"><?= htmlspecialchars($attendanceHours, ENT_QUOTES)?></td>
            </tr>
        </table>
    </div>

    <table id="attendancesTable">
    <?php if (!empty($attendances)) { ?>
            <tr>
                <th>ID</th>
                <th>Status type</th>
                <th>Start</th>
                <th>End</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($attendances as $attendance) { ?>
                <tr>
                    <td><?= htmlspecialchars($attendance->getId(), ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($statusTypes[$attendance->getStatusId() - 1]->getName(), ENT_QUOTES); ?></td>
                    <td><?= htmlspecialchars($attendance->getCheckInTime(), ENT_QUOTES);  ?></td>
                    <td><?= htmlspecialchars($attendance->getCheckOutTime()  ?? '-', ENT_QUOTES);  ?></td>
                    <?php if ($attendance->getCheckOutTime() === null) {?>
                        <td>
                            <a href="<?= $link->url('employee.editAttendance', ['id' => $attendance->getId()]) ?>"
                                class="btn btn-sm btn-primary">
                                Edit
                            </a>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>

    <?php } else { ?>
        <tr>
            <th rowspan="5">No absences.</th>
        </tr>
    <?php } ?>
    </table>
</div>

