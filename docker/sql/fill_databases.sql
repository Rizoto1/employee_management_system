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
                                                       ('jnovak', '$2y$10$wH8Q5Pq8kz8yQv1Q7u8k7e5Q5zK5vQ0y8r5K5Y5K5z5Y5K5z5Y5K5', 1),
                                                       ('pkovac', '$2y$10$wH8Q5Pq8kz8yQv1Q7u8k7e5Q5zK5vQ0y8r5K5Y5K5z5Y5K5z5Y5K5', 2),
                                                       ('lhorvathova', '$2y$10$wH8Q5Pq8kz8yQv1Q7u8k7e5Q5zK5vQ0y8r5K5Y5K5z5Y5K5z5Y5K5', 3),
                                                       ('mvarga', '$2y$10$wH8Q5Pq8kz8yQv1Q7u8k7e5Q5zK5vQ0y8r5K5Y5K5z5Y5K5z5Y5K5', 4),
                                                       ('ebielikova', '$2y$10$wH8Q5Pq8kz8yQv1Q7u8k7e5Q5zK5vQ0y8r5K5Y5K5z5Y5K5z5Y5K5', 5);

-- attendances
INSERT INTO attendances (employeeId, checkInTime, checkOutTime, status) VALUES
                                                                            (1, '2026-04-01 08:00:00', '2026-04-01 16:00:00', 'present'),
                                                                            (2, '2026-04-01 08:30:00', '2026-04-01 16:30:00', 'present'),
                                                                            (3, '2026-04-01 09:00:00', '2026-04-01 17:00:00', 'home_office'),
                                                                            (4, '2026-04-01 08:00:00', '2026-04-01 15:00:00', 'sick'),
                                                                            (5, '2026-04-01 07:45:00', '2026-04-01 15:45:00', 'present');

-- absence_types
INSERT INTO absence_types (name, description) VALUES
                                                  ('Sick Leave', 'Illness'),
                                                  ('Vacation', 'Paid vacation'),
                                                  ('Home Office', 'Work from home'),
                                                  ('Unpaid Leave', 'Unpaid leave'),
                                                  ('Business Trip', 'Work travel');

-- absences
INSERT INTO absences (employeeId, absenceTypeId, startDate, endDate, status) VALUES
                                                                                 (1, 2, '2026-03-01', '2026-03-05', 'vacation'),
                                                                                 (2, 1, '2026-02-10', '2026-02-12', 'sick'),
                                                                                 (3, 3, '2026-01-15', '2026-01-15', 'home_office'),
                                                                                 (4, 4, '2026-04-10', '2026-04-12', 'present'),
                                                                                 (5, 5, '2026-03-20', '2026-03-22', 'present');