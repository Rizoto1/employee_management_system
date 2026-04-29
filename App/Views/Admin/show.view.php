<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee[] $employees */
?>
<div class="container">
    <?php if (!empty($employees)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Hire date</th>
                <th>Department</th>
                <th>Position</th>
            </tr>
            <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td><?= $employee->getId()?></td>
                    <td><?= $employee->getFirstName()?></td>
                    <td><?= $employee->getLastName()?></td>
                    <td><?= $employee->getAddress()?></td>
                    <td><?= $employee->getEmail()?></td>
                    <td><?= $employee->getPhone()?></td>
                    <td><?= $employee->getAge()?></td>
                    <td><?= $employee->getHireDate()?></td>
                    <td><?= $employee->getDepartmentId()?></td>
                    <td><?= $employee->getPosition()?></td>
                </tr>

            <?php }?>
        </table>
    <?php } else { ?>
        <h1> No employees.</h1>
    <?php } ?>
</div>



