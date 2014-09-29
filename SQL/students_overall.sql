DROP VIEW IF EXISTS seminar_marks.students_overall;

CREATE VIEW seminar_marks.students_overall AS
SELECT 	CONCAT(student_first_name, ' ', student_last_name) AS student_name,
        student_number,
        TRUNCATE(AVG(proposal_marks.mark_1),2) AS proposal_mark_1,
        TRUNCATE(AVG(proposal_marks.mark_2),2) AS proposal_mark_2,
        TRUNCATE(AVG(proposal_marks.mark_3),2) AS proposal_mark_3,
        TRUNCATE(AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3),2) AS proposal_total,
        TRUNCATE(AVG(final_marks.mark_1),2) AS final_mark_1,
        TRUNCATE(AVG(final_marks.mark_2),2) AS final_mark_2,
        TRUNCATE(AVG(final_marks.mark_3),2) AS final_mark_3,
        TRUNCATE(AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3),2) AS final_total,
        TRUNCATE(AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3) + AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3),2) AS total,
        students.cohort,
        students.semester,
        students.id_student
FROM	students INNER JOIN
		marks AS proposal_marks ON students.id_student = proposal_marks.id_student INNER JOIN
		marks AS final_marks ON students.id_student = final_marks.id_student
WHERE proposal_marks.seminar = 1 AND final_marks.seminar = 2
GROUP BY students.id_student;