/* 
 * Overall marker proposal marks view for table on marker page.
 */
USE seminar_marks;
DROP VIEW IF EXISTS markers_overall_proposal;

CREATE VIEW markers_overall_proposal AS
SELECT  CONCAT(marker_first_name, ' ', marker_last_name) AS marker_name,
		marker_first_name,
		marker_last_name,
        ROUND(AVG(mark_1),2) AS mark_1_average,
        ROUND(AVG(mark_2),2) AS mark_2_average,
        ROUND(AVG(mark_3),2) AS mark_3_average,
        ROUND(AVG(mark_1) + AVG(mark_2) + AVG(mark_3)*8,2) AS overall_average,
        COUNT(mark_1) AS number_of_marks,
        ROUND(MIN(mark_1 + mark_2 + mark_3*8),2) AS minimum_mark,
        ROUND(MAX(mark_1 + mark_2 + mark_3*8),2) AS maximum_mark,
        ROUND(STDDEV(mark_1 + mark_2 + mark_3*8),2) AS standard_deviation,
		marks.id_marker,
        students.cohort,
        students.semester
FROM 	marks INNER JOIN
		markers ON markers.id_marker = marks.id_marker INNER JOIN
        students ON marks.id_student = students.id_student
WHERE   marks.seminar = 1 AND
		cohort = (SELECT cohort FROM users LIMIT 1) AND
		semester = (SELECT semester FROM users LIMIT 1) #Suggested revision, only works for 1 user
GROUP BY marks.id_marker
ORDER BY marker_last_name, marker_first_name;
