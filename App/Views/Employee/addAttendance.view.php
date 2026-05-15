<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\StatusType[] $statusTypes */
/** @var \Framework\Auth\AppUser $user */
/** @var string $error */

?>

<div class="container">
    <form method="post" action="<?= $link->url('employee.addAttendance')?>">
        <div class="text-center text-danger mb-3">
            <?= @$error ?>
        </div>
        <div style="display: none">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" class="form-control" value="<?= $user->getName() ?>" required readonly/>
        </div>
        <div class="mb-3">
            <label for="checkInTime" class="form-label">Check in time</label>
            <input id="checkInTime" type="datetime-local" name="checkInTime" class="form-control" required" />
        </div>
        <div class="mb-3">
            <label for="statusTypeId" class="form-label">Status type: </label>
            <select name="statusTypeId" id="statusTypeId">
                <?php foreach ($statusTypes as $statusType) { ?>
                    <option value="<?= htmlspecialchars($statusType->getId(), ENT_QUOTES); ?>">
                        <?= htmlspecialchars($statusType->getName(), ENT_QUOTES); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
