<?php
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container">
    <form method="post" action="<?= $link->url("add") ?>">
        <div class="mb-3">
            <label for="firstName" class="form-label">First name</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required maxlength="254"
                   placeholder="Insert first name here">
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required maxlength="254"
                   placeholder="Insert last name here">
        </div>
        <div class="mb-3">
            <label for="birthDate" class="form-label">Birth date</label>
            <input type="date" class="form-control" id="birthDate" name="birthDate" required maxlength="254"
                   placeholder="Insert birth date here">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required maxlength="254"
                   placeholder="Insert address here">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" required maxlength="254"
                   placeholder="Insert email here">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required maxlength="254"
                   placeholder="Insert phone here">
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" required maxlength="254"
                   placeholder="Insert position here">
        </div>
        <div class="mb-3">
            <label for="hireDate" class="form-label">Hire date</label>
            <input type="date" class="form-control" id="hireDate" name="hireDate" required maxlength="254"
                   placeholder="Insert hire date here">
        </div>

        <a href="<?= $link->url("add")?>">
            <button type="submit" class="btn-primary">save</button>
        </a>
    </form>

</div>
