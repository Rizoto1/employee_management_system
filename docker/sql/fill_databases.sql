INSERT INTO departments (name) VALUES
                                   ('Logistics'),
                                   ('QA'),
                                   ('Research'),
                                   ('Management'),
                                   ('Procurement'),
                                   ('Analytics'),
                                   ('Development'),
                                   ('DevOps'),
                                   ('Administration'),
                                   ('Customer Care');


INSERT INTO employees (firstName, lastName, birthDate, address, email, phone, position, departmentId, hireDate) VALUES
                                                                                                                    ('Marek', 'Hudak', '1991-03-12', 'Presov', 'mhudak@example.com', '0900000006', 'Developer', 1, '2021-01-10'),
                                                                                                                    ('Simona', 'Krajcikova', '1994-07-18', 'Bratislava', 'skrajcikova@example.com', '0900000007', 'Recruiter', 2, '2020-06-01'),
                                                                                                                    ('Tomas', 'Mikula', '1989-11-01', 'Martin', 'tmikula@example.com', '0900000008', 'Analyst', 3, '2019-03-15'),
                                                                                                                    ('Lenka', 'Urbanova', '1997-02-21', 'Poprad', 'lurbanova@example.com', '0900000009', 'Designer', 4, '2022-05-11'),
                                                                                                                    ('Filip', 'Kmet', '1993-08-10', 'Nitra', 'fkmet@example.com', '0900000010', 'Operator', 5, '2018-09-01'),

                                                                                                                    ('Patrik', 'Simko', '1990-01-14', 'Žilina', 'psimko@example.com', '0900000011', 'Logistics Specialist', 6, '2020-01-01'),
                                                                                                                    ('Dominika', 'Vanova', '1995-06-30', 'Košice', 'dvanova@example.com', '0900000012', 'QA Tester', 7, '2021-07-01'),
                                                                                                                    ('Samuel', 'Bartos', '1992-09-05', 'Bratislava', 'sbartos@example.com', '0900000013', 'Researcher', 8, '2019-10-20'),
                                                                                                                    ('Nikola', 'Farkasova', '1998-12-24', 'Trenčín', 'nfarkasova@example.com', '0900000014', 'Manager', 9, '2023-02-01'),
                                                                                                                    ('Erik', 'Polak', '1987-04-04', 'Levice', 'epolak@example.com', '0900000015', 'Buyer', 10, '2017-12-01'),

                                                                                                                    ('Michaela', 'Kovacova', '1991-05-20', 'Bratislava', 'mkovacova@example.com', '0900000016', 'Data Analyst', 1, '2020-11-11'),
                                                                                                                    ('Roman', 'Kral', '1986-07-07', 'Zilina', 'rkral@example.com', '0900000017', 'Backend Developer', 2, '2016-04-05'),
                                                                                                                    ('Andrea', 'Lukacova', '1999-08-19', 'Kosice', 'alukacova@example.com', '0900000018', 'DevOps Engineer', 3, '2024-01-01'),
                                                                                                                    ('Juraj', 'Svec', '1993-10-11', 'Presov', 'jsvec@example.com', '0900000019', 'Administrator', 4, '2018-06-15'),
                                                                                                                    ('Barbora', 'Kucerova', '1996-03-28', 'Nitra', 'bkucerova@example.com', '0900000020', 'Support Agent', 5, '2022-09-09'),

                                                                                                                    ('Adam', 'Toth', '1990-01-01', 'Bratislava', 'atoth@example.com', '0900000021', 'Developer', 1, '2019-01-01'),
                                                                                                                    ('Veronika', 'Slavikova', '1995-02-02', 'Trnava', 'vslavikova@example.com', '0900000022', 'HR Specialist', 2, '2021-02-02'),
                                                                                                                    ('Daniel', 'Cerny', '1988-03-03', 'Zilina', 'dcerny@example.com', '0900000023', 'Financial Analyst', 3, '2017-03-03'),
                                                                                                                    ('Petra', 'Gregorova', '1994-04-04', 'Kosice', 'pgregorova@example.com', '0900000024', 'Marketing Manager', 4, '2020-04-04'),
                                                                                                                    ('Róbert', 'Marek', '1991-05-05', 'Nitra', 'rmarek@example.com', '0900000025', 'Operator', 5, '2018-05-05'),

                                                                                                                    ('Alena', 'Vesela', '1992-06-06', 'Poprad', 'avesela@example.com', '0900000026', 'Logistics Manager', 6, '2019-06-06'),
                                                                                                                    ('Karol', 'Benko', '1989-07-07', 'Martin', 'kbenko@example.com', '0900000027', 'QA Engineer', 7, '2016-07-07'),
                                                                                                                    ('Ivana', 'Molnarova', '1997-08-08', 'Prievidza', 'imolnarova@example.com', '0900000028', 'Scientist', 8, '2022-08-08'),
                                                                                                                    ('Marian', 'Hruska', '1985-09-09', 'Banska Bystrica', 'mhruska@example.com', '0900000029', 'Director', 9, '2015-09-09'),
                                                                                                                    ('Zuzana', 'Kleinova', '1993-10-10', 'Trencin', 'zkleinova@example.com', '0900000030', 'Procurement Specialist', 10, '2020-10-10'),

                                                                                                                    ('Oliver', 'Kovac', '1994-11-11', 'Bratislava', 'okovac@example.com', '0900000031', 'BI Analyst', 1, '2021-11-11'),
                                                                                                                    ('Nina', 'Biela', '1996-12-12', 'Zilina', 'nbiela@example.com', '0900000032', 'Frontend Developer', 2, '2023-12-12'),
                                                                                                                    ('Kristián', 'Vlk', '1991-01-13', 'Kosice', 'kvlk@example.com', '0900000033', 'Cloud Engineer', 3, '2019-01-13'),
                                                                                                                    ('Laura', 'Sedlackova', '1998-02-14', 'Nitra', 'lsedlackova@example.com', '0900000034', 'Office Manager', 4, '2024-02-14'),
                                                                                                                    ('Matej', 'Oravec', '1990-03-15', 'Presov', 'moravec@example.com', '0900000035', 'Support Specialist', 5, '2018-03-15');

INSERT INTO users (username, password, employeeId) VALUES
                                                       ('mhudak', '$2y$10$B7Wc.FyBSX4btoCOZqO9hOpLllO56xQKogFi9eG3cafSga/5BFNaS', 1),
                                                       ('skrajcikova', '$2y$10$i.bbogtoPIkt2h12PxhHneRwwaZLt55MVnAk7ZLpVoV3EsSPy24h.', 2),
                                                       ('tmikula', '$2y$10$lkVnur9KTVj2wrsyE2PFhe4vILZbzy6Wh1cybdJI8RYZhCksZ/7La', 3),
                                                       ('lurbanova', '$2y$10$/oKTFjH5okv8sr/qTg0viuIHfwag9D3IPT5Q4gYV7npxfyNkkxMnq', 4),
                                                       ('fkmet', '$2y$10$33pDWRrd3zHVXkhN4xoWEOEKS9eAG.TAsjT9Civxhydj2w004XDlW', 5),

                                                       ('psimko', '$2y$10$qNfXMz2KaKtPkZkJvGJdxOF8KnBCtXWvwkyBapIkBQVoTgQdHwGqW', 6),
                                                       ('dvanova', '$2y$10$/EEFtf5TmMOftAf30I8IA.fPOZvRmWMQ4QzC/r0CkQYMSUeyhNKeC', 7),
                                                       ('sbartos', '$2y$10$9n4eHSbF54IriFDMBlDC0ORqBIrVY9/.Zh639bMP97PvsPTzgAER2', 8),
                                                       ('nfarkasova', '$2y$10$sLX1aY1nS2U5korFc8oFS.jlckHFktoxcuSeeOq7t9pCdIQwboJMi', 9),
                                                       ('epolak', '$2y$10$aXAjI1mLZZF.BBOIIxbv8OjgkVS3ZoS4luace/V.vQviVnTKW2.2i', 10),

                                                       ('mkovacova', '$2y$10$fiFXMfifky9K/itm83ftzOfbhyvtijzvQz6Pobnc/a.0duGJtBkYW', 11),
                                                       ('rkral', '$2y$10$gOiwWQkjkGo5Yr55fg1c8OOLs31K2EzQMdeyR4tZHj.R5MHtD8peS', 12),
                                                       ('alukacova', '$2y$10$plp0W4I/mXVHhQsO81HqLuePi84Sld0yLamog0Eu3D6jX9aq/3VFq', 13),
                                                       ('jsvec', '$2y$10$u/Zo4P14h2Nf1NjEIQJ4ZuYHTUt1lKfZkzU600GKFEq28wYEZim8C', 14),
                                                       ('bkucerova', '$2y$10$QdbHBZ.rY/V4XMVBL6MK6eY2SsdJlwK4Cjqx7GcFN8ElRmt2BqCLy', 15),

                                                       ('atoth', '$2y$10$cWUOZtcVfDk7xAsf8oQV/Oa2XC4XGJvwnCMvWtEKWYQ3leHLejBwW', 16),
                                                       ('vslavikova', '$2y$10$Kh1I5l4uNUxIjoj9WQqIKOFWv2GFFjNq3HRajEsYAdp4FCtYmVePe', 17),
                                                       ('dcerny', '$2y$10$eQWAy8qSSbuhw7L6TdqVNexu10q8Pl7/1/LD.f2PODT6Fqeb607qO', 18),
                                                       ('pgregorova', '$2y$10$u0Lq1Sv8dhiTS1VRsdMDqOovfYybG1u0Y1MGCnbSIZaUykreQ4VuW', 19),
                                                       ('rmarek', '$2y$10$ArRiFeZoCKs2M7UnrtAyve9aVv9LXl1MM0zo81USwUSjb8hBn/XfW', 20),

                                                       ('avesela', '$2y$10$Hs9cCAagoj5E7a0K6O6YauHcOk8GZAvwIxg849BVk2vrIipbayqUe', 21),
                                                       ('kbenko', '$2y$10$dOEchUrG4WSCnw7ZInKtru8/JTS3QB.J8QOzu8R8BejCKhMcwOCEG', 22),
                                                       ('imolnarova', '$2y$10$ZuOKHH8EsbI4jKXlImOvweTSAdU63imuD8QUAYtJaT20M4s0hdHrG', 23),
                                                       ('mhruska', '$2y$10$sTcB5qmzVDhZUxt80jSWAeQPI4c5QElUJuHTbM5mZxCafRSFe5TRq', 24),
                                                       ('zkleinova', '$2y$10$X2dpH2pX8mr/Lc62XzWpxuloykOvvF5eTjq2SNgbw2OjFW0OwwpYW', 25),

                                                       ('okovac', '$2y$10$ED9OI1jybOht4SjJHbCILOHQsNjLSY4Li8HJzgWZTw/iwVpJ9bn3y', 26),
                                                       ('nbiela', '$2y$10$o1SJX3Iw.K/sGaBh7DlH7elxnkXJJGud4FhKUf9R9l83n62crmEcC', 27),
                                                       ('kvlk', '$2y$10$aaqlBrHNhv7ffJx8mJrT5uvl.aUZ6KaqZ6lvGJfTGfe7flM3lDzOa', 28),
                                                       ('lsedlackova', '$2y$10$09TTohKPdWAOVDAQ9GoEQOgPzrFkNfbdf0GaaKdOLKDDR7kNL1XCi', 29),
                                                       ('moravec', '$2y$10$Z5xwM8oOsHvEaEYjViPji.WeyxcQ6TozRTf3z2M.RBENmTD0tzfSm', 30);

INSERT INTO statustypes (name) VALUES
                                   ('Present'),
                                   ('Home office');

-- attendances
DELIMITER $$

CREATE PROCEDURE generate_attendances()
BEGIN
    DECLARE empId INT DEFAULT 1;
    DECLARE currentDate DATE;

    WHILE empId <= 30 DO

            SET currentDate = '2024-01-01';

            WHILE currentDate <= CURDATE() DO
                    IF WEEKDAY(currentDate) < 5 THEN

                    INSERT INTO attendances (
                        employeeId,
                        checkInTime,
                        checkOutTime,
                        statusId
                    )
                    VALUES (
                               empId,

                               TIMESTAMP(
                                       currentDate,
                                       MAKETIME(
                                               8 + (DAY(currentDate) % 2),
                                               (DAY(currentDate) * 3) % 60,
                                               0
                                       )
                               ),

                               TIMESTAMP(
                                       currentDate,
                                       MAKETIME(
                                               16 + (DAY(currentDate) % 2),
                                               (DAY(currentDate) * 2) % 60,
                                               0
                                       )
                               ),

                               CASE
                                   WHEN DAY(currentDate) % 4 = 0 THEN 2
                                   ELSE 1
                                END
                           );
                    END IF;

                    SET currentDate = DATE_ADD(currentDate, INTERVAL 1 DAY);

            END WHILE;

        SET empId = empId + 1;

     END WHILE;
END$$

DELIMITER ;

CALL generate_attendances();
SHOW WARNINGS;
DROP PROCEDURE generate_attendances;

-- absence_types
INSERT INTO absencetypes (name) VALUES
                                                  ('Sick leave'),
                                                  ('Vacation'),
                                                  ('Unpaid leave'),
                                                  ('Business trip');

-- absences
DELIMITER $$

CREATE PROCEDURE generate_absences()
BEGIN
    DECLARE empId INT DEFAULT 1;
    DECLARE i INT;
    DECLARE startDate DATE;
    DECLARE durationDays INT;
    DECLARE randomDays INT;

    WHILE empId <= 30 DO

            SET i = 0;

            WHILE i < 20 DO

                    SET randomDays = FLOOR(
                            RAND() * DATEDIFF(CURDATE(), '2024-01-01')
                                     );

                    SET startDate = DATE_ADD(
                            '2024-01-01',
                            INTERVAL randomDays DAY
                                    );

                    SET durationDays = FLOOR(RAND() * 7) + 1;

                    INSERT INTO absences (
                        employeeId,
                        absenceTypeId,
                        startDate,
                        endDate
                    )
                    VALUES (
                               empId,

                               FLOOR(RAND() * 4) + 1,

                               startDate,

                               CASE
                                   WHEN RAND() < 0.1 THEN NULL
                                   ELSE DATE_ADD(
                                           startDate,
                                           INTERVAL (durationDays - 1) DAY
                                        )
                                   END
                           );

                    SET i = i + 1;

                END WHILE;

            SET empId = empId + 1;

        END WHILE;
END$$

DELIMITER ;

CALL generate_absences();

DROP PROCEDURE generate_absences;

