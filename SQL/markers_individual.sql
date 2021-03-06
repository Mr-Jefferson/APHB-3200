/* 
 * Individual marker page statistics view for table on individual marker page.
 */
USE seminar_marks;
DROP VIEW IF EXISTS markers_individual;

CREATE VIEW markers_individual AS
SELECT	ROUND(AVG(proposal_marks.mark_1),2) AS proposal_mark_1_average,
        ROUND(AVG(proposal_marks.mark_2),2) AS proposal_mark_2_average,
        ROUND(AVG(proposal_marks.mark_3),2) AS proposal_mark_3_average,
        ROUND(AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3)*8,2) AS proposal_overall_average,
        ROUND(AVG(final_marks.mark_1),2) AS final_mark_1_average,
        ROUND(AVG(final_marks.mark_2),2) AS final_mark_2_average,
        ROUND(AVG(final_marks.mark_3),2) AS final_mark_3_average,
        ROUND(AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3)*8,2) AS final_overall_average,
        proposal_marks.id_marker,
        proposal_marks.id_student,
        students.cohort,
        students.semester
FROM 	marks AS proposal_marks INNER JOIN
		marks AS final_marks ON proposal_marks.id_marker = final_marks.id_marker INNER JOIN
        students ON proposal_marks.id_student = students.id_student AND final_marks.id_student = students.id_student
WHERE   proposal_marks.seminar = 1 AND
		final_marks.seminar = 2 AND
        proposal_marks.id_marker = final_marks.id_marker
GROUP BY proposal_marks.id_marker, final_marks.id_marker;
