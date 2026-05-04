<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Absence $absence */
/** @var \App\Models\StatusType[] $statusTypes */
/** @var \App\Models\AbsenceType[] $absenceTypes */
?>

<div class="container">
    <h1>Attendance details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($employee->getFirstName() . ' ' . $employee->getLastName(), ENT_QUOTES); ?></h5>
            <form method="post" action="<?= $link->url('admin.updateAttendance')?>">
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="id" class="form-label">Id</label>
                        <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($absence->getId(), ENT_QUOTES); ?>" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="startDate" class="form-label">Check in time</label>
                        <input id="startDate" type="datetime-local" name="startDate" class="form-control" value="<?= htmlspecialchars($absence->getCheckInTime(), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <label for="endDate" class="form-label">Check out time</label>
                        <input id="endDate" type="datetime-local" name="endDate" class="form-control" value="<?= htmlspecialchars($absence->getCheckOutTime(), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
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
                        <label for="statusId" class="form-label">Status: </label>
                        <select name="statusId" id="statusId">
                            <?php foreach ($absenceTypes as $absenceType) { ?>
                                <option value="<?= htmlspecialchars($absenceType->getId(), ENT_QUOTES); ?>" <?= $absence->getStatusId() === $absenceType->getId() ? 'selected' : '' ?>>
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
            </form>
        </div>
    </div>
</div>
