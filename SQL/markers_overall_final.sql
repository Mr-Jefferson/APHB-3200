USE seminar_marks;
DROP VIEW IF EXISTS markers_overall_final;

CREATE VIEW markers_overall_final AS
SELECT  CONCAT(marker_first_name, ' ', marker_last_name) AS marker_name,
	marker_first_name,
	marker_last_name,
        TRUNCATE(AVG(mark_1),2) AS mark_1_average,
        TRUNCATE(AVG(mark_2),2) AS mark_2_average,
        TRUNCATE(AVG(mark_3),2) AS mark_3_average,
        TRUNCATE(AVG(mark_1) + AVG(mark_2) + AVG(mark_3),2) AS overall_average,
        COUNT(mark_1) AS number_of_marks,
        MIN(mark_1 + mark_2 + mark_3) AS minimum_mark,
        MAX(mark_2 + mark_3) AS maximum_mark,
        STDDEV(mark_1 + mark_2 + mark_3) AS standard_deviation,
	marks.id_marker,
        students.cohort,
        students.semester
FROM 	marks INNER JOIN
	markers ON markers.id_marker = marks.id_marker INNER JOIN
        students ON marks.id_student = students.id_student
WHERE   marks.seminar = 2;
GROUP BY marks.id_marker
ORDER BY marker_last_name DESC, marker_first_name DESC;