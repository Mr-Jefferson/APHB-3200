USE seminarmarks;
DELETE FROM marks;
DELETE FROM markers;
DELETE FROM students;
DELETE FROM users;

INSERT INTO marks VALUES
		(0, 4, 5, 70, 2014, 1, 1, 1, 1), 
		(0, 3, 4, 27, 2014, 2, 1, 1, 2),
		(0, 1, 3, 25, 2014, 1, 2, 1, 3),
		(0, 5, 7, 64, 2014, 2, 2, 1, 4),
		(0, 3, 5, 73, 2014, 1, 3, 1, 1),
		(0, 9, 5, 75, 2014, 2, 3, 1, 2),
		(0, 6, 3, 75, 2014, 1, 4, 1, 3),
		(0, 2, 8, 49, 2014, 2, 4, 1, 4),
		(0, 3, 5, 45, 2014, 1, 1, 2, 1),
		(0, 6, 8, 59, 2014, 2, 1, 2, 2),
		(0, 7, 9, 14, 2014, 1, 2, 2, 3),
		(0, 8, 8, 56, 2014, 2, 2, 2, 4),
		(0, 5, 2, 72, 2014, 1, 3, 2, 1),
		(0, 9, 7, 35, 2014, 2, 3, 2, 2),
		(0, 8, 6, 53, 2014, 1, 4, 2, 3),
		(0, 6, 1, 25, 2014, 2, 4, 2, 4);

INSERT INTO markers VALUES
	(0, "Tim", "Tam"),
	(0, "Kim", "Kam"),
	(0, "Bim", "Bam"),
	(0, "Jim", "Jam");

INSERT INTO students VALUES
	(0, "Tob", "Tub", 21127888),
	(0, "Kob", "Kub", 21137999),
	(0, "Bob", "Bub", 22113874),
	(0, "Job", "Jub", 34783927);

INSERT INTO users VALUES
	(0, "admin", "password");