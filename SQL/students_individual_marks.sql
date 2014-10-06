USE seminar_marks;
DROP VIEW IF EXISTS students_individual_marks;

CREATE VIEW students_individual_marks AS
SELECT	CONCAT(marker_first_name, ' ', marker_last_name) AS marker_name,
		mark_1,
		mark_2,
		mark_3,
		TRUNCATE(mark_1 + mark_2 + mark_3,2) as mark_total,
		marks.id_student,
		marks.seminar,
		marks.id_mark
FROM	marks INNER JOIN
		markers ON marks.id_marker = markers.id_marker
ORDER BY marker_name;