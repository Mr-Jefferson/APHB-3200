USE seminar_marks;
DROP VIEW IF EXISTS students_overall_stats;

CREATE VIEW students_overall_stats AS
SELECT	AVG(proposal_total) AS overall_average,
		MAX(proposal_total) AS overall_maximum,
		MIN(proposal_total) AS overall_minimum,
		(MAX(proposal_total)-MIN(proposal_total)) as overall_range,
		STDDEV(proposal_total) as overall_stddev,
		students.cohort,
		students.semester,
		1 as seminar
FROM	students INNER JOIN
		students_overall ON students_overall.id_student = students.id_student UNION
SELECT	AVG(final_total) AS overall_average,
		MAX(final_total) AS overall_maximum,
		MIN(final_total) AS overall_minimum,
		(MAX(final_total)-MIN(final_total)) as overall_range,
		STDDEV(final_total) as overall_stddev,
		students.cohort,
		students.semester,
		2 as seminar
FROM	students INNER JOIN
		students_overall ON students_overall.id_student = students.id_student;