<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee $employee */
/** @var \Framework\Auth\AppUser $appUser */
/** @var \App\Models\User $user */
/** @var string|null $error */
?>

<div class="container">
    <h1>Profile details</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($employee->getFirstName() . ' ' . $employee->getLastName(), ENT_QUOTES); ?></h5>
            <form method="post" action="<?= $link->url('employee.updateUser')?>">
                <div class="mb-3">
                    <div class="mb-3" style="display: none">
                        <label for="id" class="form-label">Id</label>
                        <input id="id" type="text" name="id" class="form-control" value="<?= htmlspecialchars($user->getId(), ENT_QUOTES); ?>" readonly required />
                    </div>

                    <?php if(!is_null(@$error)) {?>
                        <div class="text-center text-danger mb-3">
                            <?= @$error ?>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" type="text" name="username" class="form-control" value="<?= htmlspecialchars($user->getName(), ENT_QUOTES); ?>" required maxlength="50"/>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" class="form-control" required maxlength="100"/>
                    </div>

                </div>
                <div class="mb-3">
                    <h6 class="text-danger"> Changing user details logs you out of the system.</h6>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= $link->url('employee.index', ['name' => $user->getName()]) ?>" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>
</div>


