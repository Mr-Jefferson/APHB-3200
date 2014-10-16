/* 
 * Cohort statistics view for table on individual student page.
 */
USE seminar_marks;
DROP VIEW IF EXISTS students_overall_stats;

CREATE VIEW students_overall_stats AS
(SELECT	TRUNCATE(AVG(proposal_total),2) AS overall_average,
		MAX(proposal_total) AS overall_maximum,
		MIN(proposal_total) AS overall_minimum,
		(MAX(proposal_total)-MIN(proposal_total)) AS overall_range,
		TRUNCATE(STDDEV(proposal_total),2) AS overall_stddev,
		students.cohort,
		students.semester,
		1 AS seminar
FROM	students INNER JOIN
		students_overall ON students_overall.id_student = students.id_student
GROUP BY semester, cohort)
UNION
(SELECT	TRUNCATE(AVG(final_total),2) AS overall_average,
		MAX(final_total) AS overall_maximum,
		MIN(final_total) AS overall_minimum,
		(MAX(final_total)-MIN(final_total)) AS overall_range,
		TRUNCATE(STDDEV(final_total),2) AS overall_stddev,
		students.cohort,
		students.semester,
		2 AS seminar
FROM	students INNER JOIN
		students_overall ON students_overall.id_student = students.id_student
GROUP BY semester, cohort);