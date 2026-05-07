import { Filter } from "./Filter.js";

const filterService = new Filter();

const input = document.getElementById('filterValue');
const select = document.getElementById('filter');

function calculateAge(birthDate) {
    const today = new Date();
    const birth = new Date(birthDate);

    let age = today.getFullYear() - birth.getFullYear();

    const m = today.getMonth() - birth.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    return age;
}

function renderTable(data) {
    const table = document.getElementById('employeesTable');
    const employees = data.employees;
    const departments = data.departments;

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

    if (!employees || employees.length === 0) {
        table.innerHTML += `
            <tr>
                <td colspan="11">No employees.</td>
            </tr>
        `;
        return;
    }

    employees.forEach(emp => {
        //${} is template string, it allows for variable values to be printed instead of the variable name
        table.innerHTML += `
            <tr>
                <td>${emp.id}</td> 
                <td>${emp.firstName}</td>
                <td>${emp.lastName}</td>
                <td>${emp.address}</td>
                <td>${emp.email}</td>
                <td>${emp.phone}</td>
                <td>${calculateAge(emp.birthDate)}</td>
                <td>${emp.hireDate}</td>
                <td>${departments.find(d => d.id == emp.departmentId)?.name ?? ''}</td>
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