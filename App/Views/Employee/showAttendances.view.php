<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Attendance[] $attendances */
/** @var \App\Models\StatusType[] $statusTypes */
/** @var string $error */
?>

<div class="container">
    <h2>Attendances</h2>
    <div class="text-center text-danger mb-3">
        <?= @$error ?>
    </div>
    <?php if (!empty($attendances)) { ?>
        <table>
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
        </table>
    <?php } else { ?>
        <h3>No absences.</h3>
    <?php } ?>
</div>

