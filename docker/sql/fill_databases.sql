-- departments
INSERT INTO departments (name) VALUES
                                                ('IT'),
                                                ('HR'),
                                                ('Finance'),
                                                ('Marketing'),
                                                ('Operations');

-- employees
INSERT INTO employees (firstName, lastName, birthDate, address, email, phone, position, departmentId, hireDate) VALUES
                                                                                                                    ('Ján', 'Novák', '1990-05-10', 'Bratislava', 'jnovak@example.com', '0900000001', 'Developer', 1, '2020-01-15'),
                                                                                                                    ('Peter', 'Kováč', '1988-03-22', 'Žilina', 'pkovac@example.com', '0900000002', 'HR Manager', 2, '2019-06-10'),
                                                                                                                    ('Lucia', 'Horváthová', '1995-07-30', 'Košice', 'lhorvathova@example.com', '0900000003', 'Accountant', 3, '2021-09-01'),
                                                                                                                    ('Martin', 'Varga', '1992-11-05', 'Nitra', 'mvarga@example.com', '0900000004', 'Marketing Specialist', 4, '2018-04-20'),
                                                                                                                    ('Eva', 'Bieliková', '1998-02-14', 'Trnava', 'ebielikova@example.com', '0900000005', 'Operator', 5, '2022-02-01');




-- users
INSERT INTO users (username, password, employeeId) VALUES
                                                       ('jnovak', '$2y$10$oAo/dtYNT3d0wHkHzpc3fur7m0YMGCuNgtseqyH7k8SGzlx1tUtvW', 1),
                                                       ('pkovac', '$2y$10$HmyAO17fjshWqY4FzLiCd.JwoSoTSBl1SAri3DaHgmwcHAcPLsp5q', 2),
                                                       ('lhorvathova', '$2y$10$PKu7TL.dIUy/9yXi.nGzruoGBfuLDTP0AkY/qbz7gFAcdykGjZxEm', 3),
                                                       ('mvarga', '$2y$10$U0jyYA1rkq0xZGVSFqxf1.tcYEvUnsKOY/EksE8A1zHiWSPFA4Rsy', 4),
                                                       ('ebielikova', '$2y$10$LkvzUYNLpWUPDhPZEveAfOFNz1sGjeJFOBLTTAvnZ71y5/buaWd02', 5);

INSERT INTO statustypes (name) VALUES
                                   ('Absent'),
                                   ('Present'),
                                   ('Sick'),
                                   ('Home office'),
                                   ('Vacation');

-- attendances
INSERT INTO attendances (employeeId, checkInTime, checkOutTime, statusId) VALUES
-- 2024
                                                                              (1, '2024-01-08 08:00:00', '2024-01-08 16:00:00', 1),
                                                                              (1, '2024-02-12 08:15:00', '2024-02-12 16:10:00', 1),
                                                                              (2, '2024-03-03 08:30:00', '2024-03-03 16:30:00', 1),
                                                                              (3, '2024-04-18 09:00:00', '2024-04-18 17:00:00', 3),
                                                                              (4, '2024-05-21 07:50:00', '2024-05-21 15:30:00', 1),
                                                                              (5, '2024-06-10 08:00:00', '2024-06-10 16:00:00', 1),

-- 2025
                                                                              (1, '2025-01-10 08:00:00', '2025-01-10 16:00:00', 1),
                                                                              (1, '2025-02-11 08:05:00', '2025-02-11 16:20:00', 1),
                                                                              (2, '2025-03-15 08:30:00', '2025-03-15 16:45:00', 2),
                                                                              (2, '2025-04-20 08:15:00', '2025-04-20 16:00:00', 1),
                                                                              (3, '2025-05-09 09:00:00', '2025-05-09 17:00:00', 3),
                                                                              (3, '2025-06-14 09:10:00', '2025-06-14 17:05:00', 1),
                                                                              (4, '2025-07-01 08:00:00', '2025-07-01 15:00:00', 4),
                                                                              (4, '2025-08-12 08:20:00', '2025-08-12 15:10:00', 1),
                                                                              (5, '2025-09-03 07:45:00', '2025-09-03 15:45:00', 1),
                                                                              (5, '2025-10-22 08:00:00', '2025-10-22 16:00:00', 2),

-- 2026
                                                                              (1, '2026-01-05 08:00:00', '2026-01-05 16:00:00', 1),
                                                                              (1, '2026-02-06 08:10:00', '2026-02-06 16:10:00', 3),
                                                                              (2, '2026-03-07 08:30:00', '2026-03-07 16:30:00', 1),
                                                                              (3, '2026-04-08 09:00:00', '2026-04-08 17:00:00', 1),
                                                                              (4, '2026-05-09 08:00:00', '2026-05-09 15:00:00', 2),
                                                                              (5, '2026-06-10 07:45:00', '2026-06-10 15:45:00', 1),
                                                                              (2, '2026-05-10 07:45:00', null, 2);

-- absence_types
INSERT INTO absencetypes (name) VALUES
                                                  ('Sick leave'),
                                                  ('Vacation'),
                                                  ('Unpaid leave'),
                                                  ('Business trip');

-- absences
INSERT INTO absences (employeeId, absenceTypeId, startDate, endDate, statusId) VALUES
-- 2024
(1, 1, '2024-01-15', '2024-01-18', 2),
(2, 2, '2024-02-20', '2024-02-25', 4),
(3, 3, '2024-03-05', '2024-03-05', 3),
(4, 1, '2024-04-10', '2024-04-14', 1),
(5, 4, '2024-05-01', '2024-05-03', 2),

-- 2025
(1, 2, '2025-01-10', '2025-01-15', 4),
(1, 1, '2025-03-01', '2025-03-04', 2),
(2, 3, '2025-04-12', '2025-04-12', 3),
(2, 2, '2025-05-20', '2025-05-24', 1),
(3, 1, '2025-06-02', '2025-06-06', 2),
(3, 2, '2025-07-15', '2025-07-20', 4),
(4, 4, '2025-08-01', '2025-08-03', 2),
(4, 3, '2025-09-09', '2025-09-09', 3),
(5, 3, '2025-10-11', '2025-10-14', 1),
(5, 2, '2025-11-20', '2025-11-25', 4),

-- 2026
(1, 1, '2026-01-12', '2026-01-14', 2),
(1, 1, '2026-05-08', null, 5),
(1, 1, '2026-01-12', '2026-01-14', 2),
(2, 2, '2026-02-18', '2026-02-22', 4),
(3, 3, '2026-03-10', '2026-03-10', 3),
(4, 4, '2026-04-01', '2026-04-05', 2),
(5, 1, '2026-05-16', '2026-05-20', 1);

