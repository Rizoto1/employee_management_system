<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Attendance[] $attendances */
/** @var \App\Models\Absence[] $absences */
?>

<div class="container">
    <h1>Employee details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= $employee->getFirstName() . " " . $employee->getLastName() ?></h5>
            <p class="card-text">Address: <?= $employee->getAddress() ?></p>
            <p class="card-text">Email: <?= $employee->getEmail() ?></p>
            <p class="card-text">Phone: <?= $employee->getPhone() ?></p>
            <p class="card-text">Age: <?= $employee->getAge() ?></p>
            <p class="card-text">Hire date: <?= $employee->getHireDate() ?></p>
            <p class="card-text">Department: <?= $employee->getDepartmentId() ?></p>
            <p class="card-text">Position: <?= $employee->getPosition() ?></p>
        </div>
    </div>

    <h2>Attendances</h2>
    <?php if (!empty($attendances)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Time in</th>
                <th>Time out</th>
            </tr>
            <?php foreach ($attendances as $attendance) { ?>
                <tr>
                    <td><?= $attendance->getId() ?></td>
                    <td><?= $attendance->getEmployeeId() ?></td>
                    <td><?= $attendance->getCheckInTime() ?></td>
                    <td><?= $attendance->getCheckOutTime() ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <h3>No attendances.</h3>
    <?php } ?>

    <h2>Absences</h2>
    <?php if (!empty($absences)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Employee ID</th>
                <th>Absence type</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
            </tr>
            <?php foreach ($absences as $absence) { ?>
                <tr>
                    <td><?= $absence->getId() ?></td>
                    <td><?= $absence->getEmployeeId() ?></td>
                    <td><?= $absence->getAbsenceTypeId()?></td>
                    <td><?= $absence->getStartDate() ?></td>
                    <td><?= $absence->getEndDate() ?></td>
                    <td><?= $absence->getStatus() ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <h3>No absences.</h3>
    <?php } ?>
</div>


