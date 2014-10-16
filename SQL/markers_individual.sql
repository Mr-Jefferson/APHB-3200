/* 
 * Individual marker page statistics view for table on individual marker page.
 */
USE seminar_marks;
DROP VIEW IF EXISTS markers_individual;

CREATE VIEW markers_individual AS
SELECT	TRUNCATE(AVG(proposal_marks.mark_1),2) AS proposal_mark_1_average,
        TRUNCATE(AVG(proposal_marks.mark_2),2) AS proposal_mark_2_average,
        TRUNCATE(AVG(proposal_marks.mark_3),2) AS proposal_mark_3_average,
        TRUNCATE(AVG(proposal_marks.mark_1)*0.1 + AVG(proposal_marks.mark_2)*0.1 + AVG(proposal_marks.mark_3)*0.8,2)*10 AS proposal_overall_average,
        TRUNCATE(AVG(final_marks.mark_1),2) AS final_mark_1_average,
        TRUNCATE(AVG(final_marks.mark_2),2) AS final_mark_2_average,
        TRUNCATE(AVG(final_marks.mark_3),2) AS final_mark_3_average,
        TRUNCATE(AVG(final_marks.mark_1)*0.1 + AVG(final_marks.mark_2)*0.1 + AVG(final_marks.mark_3)*0.8,2)*10 AS final_overall_average,
        proposal_marks.id_marker,
        proposal_marks.id_student,
        students.cohort,
        students.semester
FROM 	marks AS proposal_marks INNER JOIN
		marks AS final_marks ON proposal_marks.id_marker = final_marks.id_marker INNER JOIN
        students ON proposal_marks.id_student = students.id_student AND final_marks.id_student = students.id_student
WHERE   proposal_marks.seminar = 1 AND
		final_marks.seminar = 2
GROUP BY proposal_marks.id_marker, final_marks.id_marker;