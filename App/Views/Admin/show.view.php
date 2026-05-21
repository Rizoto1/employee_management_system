<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\Employee[] $employees */
/** @var integer $currentPage */
/** @var integer $totalPages */
/** @var string[] $statuses */
?>
<div class="container">
    <div class="mb-3">
        <label for="filter" class="form-label">Filter: </label>
        <select name="filter" id="filter">
            <option value="0"></option>
            <option value="firstName">First name</option>
            <option value="lastName">Last name</option>
            <option value="email">Email</option>
            <option value="hireDate">Hire date</option>
            <option value="department">Department</option>
            <option value="position">Position</option>
        </select>
        <input type="text" id="filterValue" name="filterValue" class="form-control" placeholder="Filter value">
    </div>
    <?php if (!empty($employees)) { ?>
        <table id="employeesTable">
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
                <th>Status</th>
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
                    <td><?= htmlspecialchars($employee->getDepartment() !== null ? $employee->getDepartment()->getName() : '', ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($employee->getPosition(), ENT_QUOTES);?></td>
                    <td><?= htmlspecialchars($statuses[$employee->getId()], ENT_QUOTES);?></td>
                    <td>
                        <a href="<?= $link->url('statistics', ['id' => $employee->getId()]) ?>"
                           class="btn btn-sm btn-secondary">
                            Statistics
                        </a>

                        <a href="<?= $link->url('editEmployee', ['id' => $employee->getId()]) ?>"
                           class="btn btn-sm btn-primary">
                            Edit
                        </a>

                        <a href="<?= $link->url('deleteEmployee', ['id' => $employee->getId()]) ?>"
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

    <div class="mb-3" id="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="<?= $link->url('admin.show', ['page' => $i]) ?>"
               class="btn btn-sm <?= $i == $currentPage ? 'btn-primary' : 'btn-secondary' ?>">
                <?= $i ?>
            </a>
        <?php } ?>
    </div>
</div>



