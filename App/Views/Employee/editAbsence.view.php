<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \App\Models\Absence $absence */
/** @var \App\Models\AbsenceType $absenceType */
/** @var \Framework\Auth\AppUser $user */
/** @var string|null $error */
?>

<div class="container">
    <h1>Absence details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($employee->getFirstName() . ' ' . $employee->getLastName(), ENT_QUOTES); ?></h5>
            <form method="post" action="<?= $link->url('employee.updateAbsence')?>">
                <div class="mb-3">
                    <div class="mb-3" style="display: none">
                        <label for="id" class="form-label">Id</label>
                        <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($absence->getId(), ENT_QUOTES); ?>" readonly />
                    </div>

                    <?php if(!is_null(@$error)) {?>
                        <div class="text-center text-danger mb-3">
                            <?= @$error ?>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <p>
                            <span style="font-weight: bold">Start date: </span> <?= htmlspecialchars($absence->getStartDate(), ENT_QUOTES); ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="endDate" class="form-label">End date</label>
                        <input id="endDate" type="date" name="endDate" class="form-control" value="<?= htmlspecialchars($absence->getEndDate() ?? '', ENT_QUOTES); ?>" required onfocus="this.showPicker()" />
                    </div>

                    <div class="mb-3">
                        <p>
                            <span style="font-weight: bold">Absence type: </span> <?= htmlspecialchars($absenceType->getName(), ENT_QUOTES); ?>
                        </p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('employee.showAbsences', ['name' => $user->getName()]) ?>" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>
</div>
