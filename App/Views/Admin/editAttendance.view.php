<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Attendance $attendance */
/** @var \App\Models\StatusType[] $statusTypes */
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
                        <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($attendance->getId(), ENT_QUOTES); ?>" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="checkInTime" class="form-label">Check in time</label>
                        <input id="checkInTime" type="datetime-local" name="checkInTime" class="form-control" value="<?= htmlspecialchars($attendance->getCheckInTime(), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <label for="checkOutTime" class="form-label">Check out time</label>
                        <input id="checkOutTime" type="datetime-local" name="checkOutTime" class="form-control" value="<?= htmlspecialchars($attendance->getCheckOutTime(), ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <label for="statusId" class="form-label">Status: </label>
                        <select name="statusId" id="statusId">
                            <?php foreach ($statusTypes as $statusType) { ?>
                                <option value="<?= htmlspecialchars($statusType->getId(), ENT_QUOTES); ?>" <?= $attendance->getStatusId() === $statusType->getId() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($statusType->getName(), ENT_QUOTES); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('admin.editEmployee', ['id' => $employee->getId()]) ?>" class="btn btn-secondary">
                    Back
                </a>
                <a href="<?= $link->url('admin.deleteAttendance', ['id' => $attendance->getId()]) ?>" class="btn btn-danger">
                    Delete
                </a>
            </form>
        </div>
    </div>
</div>
