<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Attendance[] $attendances */
/** @var \App\Models\Absence[] $absences */
/** @var \App\Models\AbsenceType[] $absenceTypes */
/** @var \App\Models\statusType[] $statusTypes */
?>

<div class="container">
    <h1>Statistics</h1>

    <div class="card mb-3">
        <h5 class="card-title"><?= htmlspecialchars($employee->getFirstName() . ' ' . $employee->getLastName(), ENT_QUOTES); ?></h5>
        <input type="hidden" id="employeeId" value="<?= htmlspecialchars($employee->getId(), ENT_QUOTES); ?>">
        <div class="card-body">
            <div class="mb-3">
                <label for="statisticsDate" class="form-label">Filter by date</label>
                <input id="statisticsDate" type="month" name="statisticsDate" class="form-control" value="<?= htmlspecialchars(date('Y-m'), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
            </div>
            <h2>Attendances</h2>
            <?php if (!empty($attendances)) { ?>
                <table id="attendancesTable">
                    <tr>
                        <th>ID</th>
                        <th>Time in</th>
                        <th>Time out</th>
                        <th>Status</th>
                    </tr>
                    <?php foreach ($attendances as $attendance) { ?>
                        <tr>
                            <td><?= htmlspecialchars($attendance->getId(), ENT_QUOTES);  ?></td>
                            <td><?= htmlspecialchars($attendance->getCheckInTime(), ENT_QUOTES);  ?></td>
                            <td><?= htmlspecialchars($attendance->getCheckOutTime(), ENT_QUOTES);  ?></td>
                            <td><?= htmlspecialchars($statusTypes[$attendance->getStatusId() - 1]->getName(), ENT_QUOTES);  ?></td>
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
                        <th>Status</th>
                    </tr>
                    <?php foreach ($absences as $absence) { ?>
                        <tr>
                            <td><?= htmlspecialchars($absence->getId(), ENT_QUOTES);  ?></td>
                            <td><?= htmlspecialchars($absenceTypes[$absence->getAbsenceTypeId()]->getName(), ENT_QUOTES); ?></td>
                            <td><?= htmlspecialchars($absence->getStartDate(), ENT_QUOTES);  ?></td>
                            <td><?= htmlspecialchars($absence->getEndDate(), ENT_QUOTES);  ?></td>
                            <td><?= htmlspecialchars($statusTypes[$absence->getStatusId() - 1]->getName(), ENT_QUOTES);  ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3>No absences.</h3>
            <?php } ?>
        </div>
    </div>
</div>
