USE seminar_marks;
DROP VIEW IF EXISTS markers_individual_marks;

CREATE VIEW markers_individual_marks AS
SELECT  CONCAT(student_first_name, ' ', student_last_name) AS student_name,
        student_last_name,
        student_first_name,
        students.student_number,
        mark_1,
        mark_2,
        mark_3,
        TRUNCATE(mark_1*0.1 + mark_2*0.1 + mark_3*0.8,2) AS mark_total,
        marks.seminar,
		marks.id_marker,
		marks.id_mark,
		cohort,
		semester
FROM	marks INNER JOIN
		markers ON markers.id_marker = marks.id_marker INNER JOIN
		students ON marks.id_student = students.id_student
ORDER BY student_last_name, student_first_name, student_number;