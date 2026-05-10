import { Filter } from "./Filter.js";

const filterService = new Filter();

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

function renderTableEmployees(data) {
    const table = document.getElementById('employeesTable');
    const employees = data.employees;
    const departments = data.departments;
    const statuses = data.statuses;

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
            <th>Status</th>
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
                <td>${departments.find(d => d.id === emp.departmentId)?.name ?? ''}</td>
                <td>${emp.position}</td>
                <td>${statuses[emp.id]}</td>
                <td>
                    <a href="?c=admin&a=statistics&id=${emp.id}" class="btn btn-sm btn-secondary">
                        Statistics
                    </a>
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

function renderTableEmployeeStatistics(data) {
    const absencesTable = document.getElementById('absencesTable');
    const attendancesTable = document.getElementById('attendancesTable');
    const statisticsTableAttendanceDays = document.getElementById('attendanceDays');
    const statisticsTableAttendanceHours = document.getElementById('attendanceHours');
    const statisticsTableAbsenceDays = document.getElementById('absenceDays');

    const absences = data.absences;
    const attendances = data.attendances;
    const absenceTypes = data.absenceTypes;
    const statuses = data.statusTypes;

    statisticsTableAttendanceDays.textContent = data.attendanceDays ?? 0;
    statisticsTableAttendanceHours.textContent = data.attendanceHours ?? 0;
    statisticsTableAbsenceDays.textContent = data.absenceDays ?? 0;

    attendancesTable.innerHTML = `
        <tr>
            <th>ID</th>
            <th>Time in</th>
            <th>Time out</th>
            <th>Status</th>
        </tr>
    `;

    if (!attendances || attendances.length === 0) {
        attendancesTable.innerHTML += `
            <tr>
                <td colspan="4">No attendances.</td>
            </tr>
        `;
    } else {
        attendances.forEach(att => {
            //${} is template string, it allows for variable values to be printed instead of the variable name
            attendancesTable.innerHTML += `
            <tr>
                <td>${att.id}</td> 
                <td>${att.checkInTime}</td>
                <td>${att.checkOutTime}</td>
                <td>${statuses.find(s => s.id === att.statusId)?.name ?? ''}</td>
            </tr>
        `;
        });
    }

    absencesTable.innerHTML = `
        <tr>
            <th>ID</th>
            <th>Absence type</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
        </tr>
    `;

    if (!absences || absences.length === 0) {
        absencesTable.innerHTML += `
            <tr>
                <td colspan="5">No absences.</td>
            </tr>
        `;
        return;
    }

    absences.forEach(abs => {
        //${} is template string, it allows for variable values to be printed instead of the variable name
        absencesTable.innerHTML += `
            <tr>
                <td>${abs.id}</td> 
                <td>${absenceTypes.find(a => a.id === abs.absenceTypeId)?.name ?? ''}</td>
                <td>${abs.startDate}</td>
                <td>${abs.endDate}</td>
                <td>${statuses.find(s => s.id === abs.statusId)?.name ?? ''}</td>
            </tr>
        `;
    });
}

window.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('filterValue');
    const select = document.getElementById('filter');
    if (input && select) {
        input.addEventListener('input', async function () {
            const data = await filterService.filterEmployees(
                select.value,
                input.value
            );
            renderTableEmployees(data);
        });
    }

    const dateInput = document.getElementById('statisticsDate');
    const employeeId = document.getElementById('employeeId').value;
    if (dateInput && employeeId) {
        dateInput.addEventListener('change', async function () {
            const data = await filterService.filterStatistics(
                dateInput.value,
                employeeId
            );
            renderTableEmployeeStatistics(data);
        });

        dateInput.addEventListener('click', () => {
           dateInput.showPicker();
        });
    }
});

