import { Filter } from "./Filter.js";

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

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Renders the employees table with pagination.
 * @param {Object} data - The data containing employees, departments, and statuses.
 * @param {number} page - The current page number (default is 1).
 */
function renderTableEmployees(data, page = 1) {
    const perPage = 20;
    const table = document.getElementById('employeesTable');
    const employees = data.employees;
    const departments = data.departments;
    const statuses = data.statuses;

    const start = (page - 1) * perPage;
    const end = start + perPage;
    const paginatedEmployees = employees.slice(start, end);

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

    if (!paginatedEmployees || paginatedEmployees.length === 0) {
        table.innerHTML += `
            <tr>
                <td colspan="11">No employees.</td>
            </tr>
        `;
        return;
    }

    paginatedEmployees.forEach(emp => {
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

    renderPagination(employees.length, page, data);
}

/**
 * Renders pagination buttons based on the total number of items and the current page.
 * @param {number} totalItems - The total number of items to paginate.
 * @param {number} currentPage - The current page number.
 * @param {Object} data - The data containing employees, departments, and statuses.
 */
function renderPagination(totalItems, currentPage, data) {
    const perPage = 20;
    const pagination = document.getElementById('pagination');
    const totalPages = Math.ceil(totalItems / perPage);

    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        pagination.innerHTML += `
            <button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-secondary'}" data-page="${i}">
                ${i}
            </button>
        `;
    }

    pagination.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
            renderTableEmployees(data, Number(btn.dataset.page));
        });
    });
}

/**
 * Renders the employee statistics tables for absences and attendances.
 * @param {Object} data - The data containing absences, attendances, absence types, attendance days, attendance hours, absence days and status types.
 */
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

    if (statisticsTableAttendanceDays) statisticsTableAttendanceDays.textContent = data.attendanceDays ?? 0;
    if (statisticsTableAttendanceHours) statisticsTableAttendanceHours.textContent = data.attendanceHours ?? 0;
    if (statisticsTableAbsenceDays) statisticsTableAbsenceDays.textContent = data.absenceDays ?? 0;

    const adminEditEmployeeForm = document.getElementById('adminEditEmployeeForm');

    if (attendancesTable) {
        attendancesTable.innerHTML = `
        <tr>
            <th>ID</th>
            <th>Time in</th>
            <th>Time out</th>
            <th>Status</th>
            ${adminEditEmployeeForm ? `<th>Actions</th>` : ''}
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
                attendancesTable.innerHTML += `
            <tr>
                <td>${att.id}</td> 
                <td>${att.checkInTime}</td>
                <td>${att.checkOutTime}</td>
                <td>${statuses.find(s => s.id === att.statusId)?.name ?? ''}</td>
                ${adminEditEmployeeForm ? `
                <td>
                    <a href="?c=admin&a=editAttendance&id=${att.id}" class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <a href="?c=admin&a=deleteAttendance&id=${att.id}" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Do you really want to delete attendance?');">
                        Delete
                    </a>
                </td>
            ` : ''}
            </tr>
        `;
            });
        }
    }

    if (absencesTable) {
        absencesTable.innerHTML = `
        <tr>
            <th>ID</th>
            <th>Absence type</th>
            <th>Start</th>
            <th>End</th>
            ${adminEditEmployeeForm ? `<th>Actions</th>` : ''}
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
            absencesTable.innerHTML += `
            <tr>
                <td>${abs.id}</td> 
                <td>${absenceTypes.find(a => a.id === abs.absenceTypeId)?.name ?? ''}</td>
                <td>${abs.startDate}</td>
                <td>${abs.endDate}</td>
                ${adminEditEmployeeForm ? `
                <td>
                    <a href="?c=admin&a=editAbsence&id=${abs.id}" class="btn btn-sm btn-primary">
                        Edit
                    </a>

                    <a href="?c=admin&a=deleteAbsence&id=${abs.id}" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Do you really want to delete absence?');">
                        Delete
                    </a>
                </td>
            ` : ''}
            </tr>
        `;
        });
    }
}

window.addEventListener('DOMContentLoaded', () => {
    const adminFilter = new Filter("admin");
    const employeeFilter = new Filter("employee");

    const input = document.getElementById('filterValue');
    const select = document.getElementById('filter');
    if (input && select) {
        input.addEventListener('input', async function () {
            const data = await adminFilter.filterEmployees(
                select.value,
                input.value
            );
            renderTableEmployees(data);
        });

        select.addEventListener('change', async function () {
            const data = await adminFilter.filterEmployees(
                select.value,
                input.value
            );
            renderTableEmployees(data);
        });
    }

    const dateInput = document.getElementById('statisticsDate');
    const employeeId = document.getElementById('employeeId');
    if (dateInput && employeeId) {
        dateInput.addEventListener('change', async function () {
            const data = await adminFilter.filterStatistics(
                dateInput.value,
                employeeId.value
            );
            renderTableEmployeeStatistics(data);
        });

        dateInput.addEventListener('click', () => {
           dateInput.showPicker();
        });
    }

    const dateInputEmp = document.getElementById('statisticsDateEmp');
    const employeeIdEmp = document.getElementById('employeeId');
    if (dateInputEmp && employeeIdEmp) {
        dateInputEmp.addEventListener('change', async function () {
            const data = await employeeFilter.filterStatistics(
                dateInputEmp.value,
                employeeIdEmp.value
            );
            renderTableEmployeeStatistics(data);
        });

        dateInputEmp.addEventListener('click', () => {
            dateInputEmp.showPicker();
        });
    }
    
    const startDate = document.getElementById('startDate');
    if (startDate) {
        startDate.addEventListener('click', () => {
            startDate.showPicker();
        });
    }

    const endDate = document.getElementById('endDate');
    if (endDate) {
        endDate.addEventListener('click', () => {
            endDate.showPicker();
        });
    }

    const checkInTime = document.getElementById('checkInTime');
    if (checkInTime) {
        checkInTime.addEventListener('click', () => {
            checkInTime.showPicker();
        });
    }

    const checkOutTime = document.getElementById('checkOutTime');
    if (checkOutTime) {
        checkOutTime.addEventListener('click', () => {
            checkOutTime.showPicker();
        });
    }

    const birthDate = document.getElementById('birthDate');
    const error = document.getElementById('error');
    const submitBtn = document.getElementById('submit');
    if (birthDate) {
        birthDate.addEventListener('change', () => {
            if (error && calculateAge(birthDate.value) < 18 && submitBtn) {
                error.innerHTML = 'Employee must be at least 18 years old';
                submitBtn.disabled = true;
            } else if(error && submitBtn) {
                error.innerHTML = '';
                submitBtn.disabled = false;
            }
        });
        birthDate.addEventListener('click', () => {
            birthDate.showPicker();

        });
    }

    const hireDate = document.getElementById('hireDate');
    if (hireDate) {
        hireDate.addEventListener('click', () => {
            hireDate.showPicker();
        });
    }

    const email = document.getElementById('email');
    if (email) {
        email.addEventListener('input', () => {
            if (error && !validateEmail(email.value) && submitBtn) {
                error.innerHTML='Invalid email address';
                submitBtn.disabled = true;
            } else if (error && submitBtn) {
                error.innerHTML='';
                submitBtn.disabled = false;
            }
        });
    }
});

