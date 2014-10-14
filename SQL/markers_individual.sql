USE seminar_marks;
DROP VIEW IF EXISTS markers_individual;

CREATE VIEW markers_individual AS
SELECT	TRUNCATE(AVG(proposal_marks.mark_1),2) AS proposal_mark_1_average,
        TRUNCATE(AVG(proposal_marks.mark_2),2) AS proposal_mark_2_average,
        TRUNCATE(AVG(proposal_marks.mark_3),2) AS proposal_mark_3_average,
        TRUNCATE(AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3),2) AS proposal_overall_average,
	TRUNCATE(AVG(final_marks.mark_1),2) AS final_mark_1_average,
        TRUNCATE(AVG(final_marks.mark_2),2) AS final_mark_2_average,
        TRUNCATE(AVG(final_marks.mark_3),2) AS final_mark_3_average,
        TRUNCATE(AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3),2) AS final_overall_average,
        proposal_marks.id_marker
FROM 	marks AS proposal_marks INNER JOIN
	marks AS final_marks ON proposal_marks.id_marker = final_marks.id_marker
WHERE   proposal_marks.seminar = 1 AND
	final_marks.seminar = 2 AND
	proposal_marks.id_student IN (SELECT id_student FROM students WHERE (students.semester,students.cohort) = (SELECT semester,cohort FROM users LIMIT 1)) AND
	final_marks.id_student IN (SELECT id_student FROM students WHERE (students.semester,students.cohort) = (SELECT semester,cohort FROM users LIMIT 1))
GROUP BY proposal_marks.id_marker, final_marks.id_marker;