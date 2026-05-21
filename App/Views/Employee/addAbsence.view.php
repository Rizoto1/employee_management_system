<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\AbsenceType[] $absenceTypes */
/** @var \Framework\Auth\AppUser $user */
/** @var string|null $error */
?>

<div class="container">
    <form method="post" action="<?= $link->url('employee.addAbsence')?>">
        <div class="text-center text-danger mb-3" id="error">
            <?php if(!is_null(@$error)) {?>
                <?= htmlspecialchars($error, ENT_QUOTES) ?>
            <?php } ?>
        </div>
        <div style="display: none">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" class="form-control" value="<?= $user->getName() ?>" required readonly/>
        </div>
        <div class="mb-3">
            <label for="startDate" class="form-label">Start date</label>
            <input id="startDate" type="date" name="startDate" class="form-control" required" />
        </div>
        <div class="mb-3">
            <label for="endDate" class="form-label">End date</label>
            <input id="endDate" type="date" name="endDate" class="form-control"" />
        </div>
        <div class="mb-3">
            <label for="absenceTypeId" class="form-label">Absence type: </label>
            <select name="absenceTypeId" id="absenceTypeId">
                <?php foreach ($absenceTypes as $absenceType) { ?>
                    <option value="<?= htmlspecialchars($absenceType->getId(), ENT_QUOTES); ?>">
                        <?= htmlspecialchars($absenceType->getName(), ENT_QUOTES); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>