-- departments
INSERT INTO departments (name, description)
VALUES ('IT', 'IT oddelenie');

-- employees
INSERT INTO employees (
    firstName, lastName, birthdate, address, email, phone, position, departmentId, hireDate
) VALUES (
             'Jan', 'Novak', '1990-05-15', 'Bratislava 123', 'jan.novak@example.com', '+421900000000', 'Developer', 1, '2022-01-10'
         );

-- users
INSERT INTO users (
    username, password, employeeId
) VALUES (
             'jnovak', '$2y$10$plR96Q9VSuINxHzsQUq3seC0cXHVFzVIYx66Vd9J6SHoV6e1pdxre', 1
         );

-- attendances
INSERT INTO attendances (
    employeeId, checkInTime, checkOutTime, status
) VALUES (
             1, '2026-04-20 08:00:00', '2026-04-20 16:00:00', 'present'
         );

-- absence_types
INSERT INTO absence_types (
    name, description
) VALUES (
             'vacation', 'Dovolenka'
         );

-- absences
INSERT INTO absences (
    employeeId, absenceTypeId, startDate, endDate, status
) VALUES (
             1, 1, '2026-04-25', '2026-04-30', 'vacation'
         );