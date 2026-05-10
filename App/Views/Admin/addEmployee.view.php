<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Department[] $departments */
/** @var string $error */
?>

<div class="container">
    <form method="post" action="<?= $link->url('admin.addEmployee')?>">
        <div class="text-center text-danger mb-3">
            <?= @$error ?>
        </div>
        <div class="mb-3">
            <label for="firstName" class="form-label">First name</label>
            <input id="firstName" type="text" name="firstName" class="form-control" placeholder="Insert first name here" required />
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last name</label>
            <input id="lastName" type="text" name="lastName" class="form-control" placeholder="Insert last name here" required />
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input id="address" type="text" name="address" class="form-control" placeholder="Insert address here" required />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="text" name="email" class="form-control" placeholder="Insert email here" required />
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone number</label>
            <input id="phone" type="number" name="phone" class="form-control" placeholder="Insert phone number here" required />
        </div>
        <div class="mb-3">
            <label for="birthDate" class="form-label">Birth date</label>
            <input id="birthDate" type="date" name="birthDate" class="form-control" required onfocus="this.showPicker()" />
        </div>
        <div class="mb-3">
            <label for="hireDate" class="form-label">Hire date</label>
            <input id="hireDate" type="date" name="hireDate" class="form-control" required onfocus="this.showPicker()" />
        </div>
        <div class="mb-3">
            <label for="departmentId" class="form-label">Department: </label>
            <select name="departmentId" id="departmentId">
                <option value="0" selected></option>
                <?php foreach ($departments as $department) { ?>
                    <option value="<?= htmlspecialchars($department->getId(), ENT_QUOTES); ?>">
                        <?= htmlspecialchars($department->getName(), ENT_QUOTES); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input id="position" type="text" name="position" class="form-control" placeholder="Insert position here" required />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</div>
