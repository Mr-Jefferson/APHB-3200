USE seminar_marks;
DROP VIEW IF EXISTS students_overall_stats;

CREATE VIEW students_overall_stats AS
SELECT	COUNT(*) AS number_of_marks,
		AVG(mark_1*0.1 + mark_2*0.1 + mark_3*0.8) AS overall_average,
		MAX(mark_1*0.1 + mark_2*0.1 + mark_3*0.8) AS overall_maximum,
		MIN(mark_1*0.1 + mark_2*0.1 + mark_3*0.8) AS overall_minimum,
		(MAX(mark_1*0.1 + mark_2*0.1 + mark_3*0.8)-MIN(mark_1*0.1 + mark_2*0.1 + mark_3*0.8)) as overall_range,
		STDDEV(mark_1*0.1 + mark_2*0.1 + mark_3*0.8),
		cohort,
		semester
FROM	marks INNER JOIN
        students ON marks.id_student = students.id_student
GROUP BY seminar, cohort, semester
ORDER BY seminar DESC;

select * from students_overall_stats;