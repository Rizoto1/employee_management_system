import { Filter } from "./Filter.js";

const filterService = new Filter();

const input = document.getElementById('filterValue');
const select = document.getElementById('filter');

function renderTable(data) {
    const table = document.getElementById('employeesTable');

    table.innerHTML = `
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
    `;

    if (!data || data.length === 0) {
        table.innerHTML += `
            <tr>
                <td colspan="11">No employees.</td>
            </tr>
        `;
        return;
    }

    data.forEach(emp => {
        //${} is template string, it allows for variable values to be printed instead of the variable name
        table.innerHTML += `
            <tr>
                <td>${emp.id}</td> 
                <td>${emp.firstName}</td>
                <td>${emp.lastName}</td>
                <td>${emp.address}</td>
                <td>${emp.email}</td>
                <td>${emp.phone}</td>
                <td>${emp.age}</td>
                <td>${emp.hireDate}</td>
                <td>${emp.departmentId ?? ''}</td>
                <td>${emp.position}</td>
                <td>
                    <a href="?c=admin&a=editEmployee&id=${emp.id}" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                    <a href="?c=admin&a=deleteEmployee&id=${emp.id}" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Do you really want to delete employee?');">
                        Delete
                    </a>
                </td>
            </tr>
        `;
    });
}

input.addEventListener('input', async function () {
    const data = await filterService.filterEmployees(
        select.value,
        input.value
    );
    renderTable(data);
});