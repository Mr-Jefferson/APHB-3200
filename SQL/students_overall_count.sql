USE seminar_marks;
DROP VIEW IF EXISTS students_overall_count;

CREATE VIEW students_overall_count AS
SELECT	COUNT(DISTINCT(students.id_student)) AS number_of_students,
		semester,
		cohort,
		seminar
FROM	students INNER JOIN
		marks ON marks.id_student = students.id_student
WHERE	marks.id_student IN (SELECT id_student FROM marks)
GROUP BY seminar, semester, cohort
ORDER BY seminar;

select * from students_overall_count