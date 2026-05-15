<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Absence[] $absences */
/** @var \App\Models\AbsenceType[] $absenceTypes */
/** @var \App\Models\Employee $employee */
/** @var int $absenceDays */
/** @var string $error */
?>

<div class="container">
    <h2>Absences</h2>
    <?php if(!is_null(@$error)) {?>
        <div class="text-center text-danger mb-3">
            <?= @$error ?>
        </div>
    <?php } ?>

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
                <th>Total absences</th>
            </tr>
            <tr>
                <td id="absenceDays"><?= htmlspecialchars($absenceDays, ENT_QUOTES)?></td>
            </tr>
        </table>
    </div>

    <table id="absencesTable">
    <?php if (!empty($absences)) { ?>
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
                        <?php if ($absence->getEndDate() === null) {?>
                    <td>
                        <a href="<?= $link->url('employee.editAbsence', ['id' => $absence->getId()]) ?>"
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

