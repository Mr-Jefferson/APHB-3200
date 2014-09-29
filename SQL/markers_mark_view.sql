DROP VIEW IF EXISTS seminar_marks.markers_mark_view;
CREATE VIEW seminar_marks.markers_mark_view AS
SELECT  marks.id_mark,
		CONCAT(student_first_name, ' ', student_last_name) AS student_name,
		students.student_number,
        mark_1,
        mark_2,
        mark_3,
        mark_1 + mark_2 + mark_3 AS mark_total,
		marks.seminar,
		marks.id_marker
FROM marks
INNER JOIN markers ON markers.id_marker = marks.id_marker
INNER JOIN students ON marks.id_student = students.id_student;