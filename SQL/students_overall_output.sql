/* 
 * Overall students marks view for marks export
 */
USE seminar_marks;
DROP VIEW IF EXISTS students_overall_output;

CREATE VIEW students_overall_output AS
SELECT 	student_last_name,
		student_first_name,
        student_number,
		ROUND(AVG(proposal_marks.mark_1)*0.5 + AVG(proposal_marks.mark_2)*0.5,2) AS proposal_mark_1_2_average,
        ROUND(AVG(proposal_marks.mark_3)*1.0,2) AS proposal_mark_3,
        ROUND(AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3)*8,2) AS proposal_mark_1_2_3_weighted,
        ROUND(AVG(final_marks.mark_1)*0.5 + AVG(final_marks.mark_2)*0.5,2) AS final_mark_1_2_average,
        ROUND(AVG(final_marks.mark_3)*1.0,2) AS final_mark_3,
        ROUND(AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3)*8,2) AS final_mark_1_2_3_weighted,
        students.cohort,
        students.semester
FROM	students
LEFT JOIN marks proposal_marks ON students.id_student = proposal_marks.id_student AND proposal_marks.seminar=1
LEFT JOIN marks final_marks ON students.id_student = final_marks.id_student AND final_marks.seminar=2
GROUP BY students.id_student
ORDER BY student_last_name, student_first_name, student_number;
