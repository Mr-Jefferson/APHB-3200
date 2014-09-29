DROP VIEW IF EXISTS seminar_marks.markers_individual_marks;

CREATE VIEW seminar_marks.markers_individual_marks AS
SELECT  CONCAT(student_first_name, ' ', student_last_name) AS student_name,
		students.student_number,
        mark_1,
        mark_2,
        mark_3,
        TRUNCATE(mark_1 + mark_2 + mark_3,2) AS mark_total,
		marks.seminar,
		marks.id_marker,
		marks.id_mark
FROM	marks INNER JOIN
		markers ON markers.id_marker = marks.id_marker INNER JOIN
		students ON marks.id_student = students.id_student;