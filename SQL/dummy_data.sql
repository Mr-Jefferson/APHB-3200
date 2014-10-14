USE seminar_marks;
DELETE FROM users;
DELETE FROM markers;
DELETE FROM students;
DELETE FROM marks;

INSERT INTO users VALUES
    (1, "admin", "password", 2014, 2);

INSERT INTO markers VALUES
    (1, "Tim", "Tam"),
    (2, "Kim", "Kam"),
    (3, "Bim", "Bam"),
    (4, "Jim", "Jam");

INSERT INTO students VALUES
    (1, "Tob", "Tub", 21127888, 2014, 1),
    (2, "Kob", "Kub", 21137999, 2014, 1),
    (3, "Bob", "Bub", 22113874, 2014, 1),
    (4, "Job", "Jub", 34783927, 2014, 1);

INSERT INTO marks VALUES
    (1, 4, 5, 70, 1, 1, 1),
    (2, 3, 4, 27, 2, 1, 1),
    (3, 1, 3, 25, 1, 2, 1),
    (4, 5, 7, 64, 2, 2, 1),
    (5, 3, 5, 73, 1, 3, 1),
    (6, 9, 5, 75, 2, 3, 1),
    (7, 6, 3, 75, 1, 4, 1),
    (8, 2, 8, 49, 2, 4, 1),
    (9, 3, 5, 45, 1, 1, 2),
    (10, 6, 8, 59, 2, 1, 2),
    (11, 7, 9, 14, 1, 2, 2),
    (12, 8, 8, 56, 2, 2, 2),
    (13, 5, 2, 72, 1, 3, 2),
    (14, 9, 7, 35, 2, 3, 2),
    (15, 8, 6, 53, 1, 4, 2),
    (16, 6, 1, 25, 2, 4, 2);