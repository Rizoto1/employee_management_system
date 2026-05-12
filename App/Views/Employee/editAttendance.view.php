<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Attendance $attendance */
/** @var \App\Models\StatusType $statusType */
/** @var \Framework\Auth\AppUser $user */
/** @var string|null $error */
?>

<div class="container">
    <h1>Attendance details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($employee->getFirstName() . ' ' . $employee->getLastName(), ENT_QUOTES); ?></h5>
            <form method="post" action="<?= $link->url('employee.updateAttendance')?>">
                <div class="mb-3">
                    <div class="mb-3" style="display: none">
                        <label for="id" class="form-label">Id</label>
                        <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($attendance->getId(), ENT_QUOTES); ?>" readonly />
                    </div>

                    <?php if(!is_null(@$error)) {?>
                        <div class="text-center text-danger mb-3">
                            <?= @$error ?>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <p>
                            <span style="font-weight: bold">Check in time: </span> <?= htmlspecialchars($attendance->getCheckInTime(), ENT_QUOTES); ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="checkOutTime" class="form-label">Check out time</label>
                        <input id="checkOutTime" type="datetime-local" name="checkOutTime" class="form-control" value="" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <p>
                            <span style="font-weight: bold">Status: </span> <?= htmlspecialchars($statusType->getName(), ENT_QUOTES); ?>
                        </p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('employee.showAttendances', ['name' => $user->getName()]) ?>" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>
</div>
