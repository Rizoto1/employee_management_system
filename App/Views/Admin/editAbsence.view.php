<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Absence $absence */
/** @var \App\Models\StatusType[] $statusTypes */
/** @var \App\Models\AbsenceType[] $absenceTypes */
?>

<div class="container">
    <h1>Absence details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($employee->getFirstName() . ' ' . $employee->getLastName(), ENT_QUOTES); ?></h5>
            <form method="post" action="<?= $link->url('admin.updateAbsence')?>">
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="id" class="form-label">Id</label>
                        <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($absence->getId(), ENT_QUOTES); ?>" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start date</label>
                        <input id="startDate" type="date" name="startDate" class="form-control" value="<?= htmlspecialchars($absence->getStartDate(), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <label for="endDate" class="form-label">End date</label>
                        <input id="endDate" type="date" name="endDate" class="form-control" value="<?= htmlspecialchars($absence->getEndDate(), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <label for="statusId" class="form-label">Status: </label>
                        <select name="statusId" id="statusId">
                            <?php foreach ($statusTypes as $statusType) { ?>
                                <option value="<?= htmlspecialchars($statusType->getId(), ENT_QUOTES); ?>" <?= $absence->getStatusId() === $statusType->getId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($statusType->getName(), ENT_QUOTES); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="absenceId" class="form-label">Absence type: </label>
                        <select name="absenceId" id="absenceId">
                            <?php foreach ($absenceTypes as $absenceType) { ?>
                                <option value="<?= htmlspecialchars($absenceType->getId(), ENT_QUOTES); ?>" <?= $absence->getAbsenceTypeId() === $absenceType->getId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($absenceType->getName(), ENT_QUOTES); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('admin.editEmployee', ['id' => $employee->getId()]) ?>" class="btn btn-secondary">
                    Back
                </a>
                <a href="<?= $link->url('admin.deleteAbsence', ['id' => $absence->getId()]) ?>" class="btn btn-danger">
                    Delete
                </a>
            </form>
        </div>
    </div>
</div>
