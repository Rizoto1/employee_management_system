-- departments
INSERT INTO departments (name, description) VALUES
                                                ('IT', 'IT Department'),
                                                ('HR', 'Human Resources'),
                                                ('Finance', 'Finance Department'),
                                                ('Marketing', 'Marketing Department'),
                                                ('Operations', 'Operations Department');

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
                                   ('present'),
                                   ('sick'),
                                   ('home_office'),
                                   ('vacation');

-- attendances
INSERT INTO attendances (employeeId, checkInTime, checkOutTime, statusId) VALUES
                                                                            (1, '2026-04-01 08:00:00', '2026-04-01 16:00:00', 1),
                                                                            (2, '2026-04-01 08:30:00', '2026-04-01 16:30:00', 1),
                                                                            (3, '2026-04-01 09:00:00', '2026-04-01 17:00:00', 3),
                                                                            (4, '2026-04-01 08:00:00', '2026-04-01 15:00:00', 2),
                                                                            (5, '2026-04-01 07:45:00', '2026-04-01 15:45:00', 1);

-- absence_types
INSERT INTO absencetypes (name, description) VALUES
                                                  ('Sick Leave', 'Illness'),
                                                  ('Vacation', 'Paid vacation'),
                                                  ('Home Office', 'Work from home'),
                                                  ('Unpaid Leave', 'Unpaid leave'),
                                                  ('Business Trip', 'Work travel');

-- absences
INSERT INTO absences (employeeId, absenceTypeId, startDate, endDate, statusId) VALUES
                                                                                 (1, 2, '2026-03-01', '2026-03-05', 2),
                                                                                 (2, 1, '2026-02-10', '2026-02-12', 3),
                                                                                 (3, 3, '2026-01-15', '2026-01-15', 4),
                                                                                 (4, 4, '2026-04-10', '2026-04-12', 1),
                                                                                 (5, 5, '2026-03-20', '2026-03-22', 2);

