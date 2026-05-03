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
                <th>Action</th>
            </tr>
            <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td><?= htmlspecialchars($employee->getId(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getFirstName(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getLastName(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getAddress(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getEmail(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getPhone(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getAge(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getHireDate(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getDepartment() !== null ? $employee->getDepartment()->getName() : '-', ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getPosition(), ENT_QUOTES);?></td>

                    <td>
                        <a href="<?= $link->url('edit', ['id' => $employee->getId()]) ?>"
                           class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <a href="<?= $link->url('delete', ['id' => $employee->getId()]) ?>"
                           class="btn btn-sm btn-danger"
                           onclick="confirm('Do you really want to delete employee?');">
                            Delete
                        </a>
                    </td>
                </tr>

            <?php }?>
        </table>
    <?php } else { ?>
        <h1> No employees.</h1>
    <?php } ?>
</div>



