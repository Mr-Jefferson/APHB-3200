/* 
 * Overall marker proposal marks view for table on marker page.
 */
USE seminar_marks;
DROP VIEW IF EXISTS markers_overall_proposal;

CREATE VIEW markers_overall_proposal AS
SELECT  CONCAT(marker_first_name, ' ', marker_last_name) AS marker_name,
		marker_first_name,
		marker_last_name,
        TRUNCATE(AVG(mark_1),2) AS mark_1_average,
        TRUNCATE(AVG(mark_2),2) AS mark_2_average,
        TRUNCATE(AVG(mark_3),2) AS mark_3_average,
        TRUNCATE(AVG(mark_1)*0.1 + AVG(mark_2)*0.1 + AVG(mark_3)*0.8,2)*10 AS overall_average,
        COUNT(mark_1) AS number_of_marks,
        TRUNCATE(MIN(mark_1*0.1 + mark_2*0.1 + mark_3*0.8),2)*10 AS minimum_mark,
        TRUNCATE(MAX(mark_1*0.1 + mark_2*0.1 + mark_3*0.8),2)*10 AS maximum_mark,
        TRUNCATE(STDDEV(mark_1*0.1 + mark_2*0.1 + mark_3*0.8),2)*10 AS standard_deviation,
		marks.id_marker,
        students.cohort,
        students.semester
FROM 	marks INNER JOIN
		markers ON markers.id_marker = marks.id_marker INNER JOIN
        students ON marks.id_student = students.id_student
WHERE   marks.seminar = 1 AND
		cohort = (SELECT cohort FROM users LIMIT 1) AND
		semester = (SELECT semester FROM users LIMIT 1)
GROUP BY marks.id_marker
ORDER BY marker_last_name, marker_first_name;
