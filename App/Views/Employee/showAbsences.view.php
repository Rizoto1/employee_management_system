<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Absence[] $absences */
/** @var \App\Models\AbsenceType[] $absenceTypes */
/** @var string $error */
?>

<div class="container">
    <h2>Absences</h2>
    <?php if(!is_null(@$error)) {?>
        <div class="text-center text-danger mb-3">
            <?= @$error ?>
        </div>
    <?php } ?>
    <?php if (!empty($absences)) { ?>
        <table>
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
        </table>
    <?php } else { ?>
        <h3>No absences.</h3>
    <?php } ?>
</div>

