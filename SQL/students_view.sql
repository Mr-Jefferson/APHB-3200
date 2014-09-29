DROP VIEW IF EXISTS seminar_marks.students_view;
CREATE VIEW seminar_marks.students_view AS
SELECT 	CONCAT(student_first_name, ' ', student_last_name) AS student_name,
        student_number,
        AVG(proposal_marks.mark_1) AS proposal_mark_1,
        AVG(proposal_marks.mark_2) AS proposal_mark_2,
        AVG(proposal_marks.mark_3) AS proposal_mark_3,
        AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3) AS proposal_total,
        AVG(final_marks.mark_1) AS final_mark_1,
        AVG(final_marks.mark_2) AS final_mark_2,
        AVG(final_marks.mark_3) AS final_mark_3,
        AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3) AS final_total,
        AVG(proposal_marks.mark_1) + AVG(proposal_marks.mark_2) + AVG(proposal_marks.mark_3) + AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3) AS total,
        students.cohort,
        students.semester,
        students.id_student
FROM students
INNER JOIN marks AS proposal_marks ON students.id_student = proposal_marks.id_student
INNER JOIN marks AS final_marks ON students.id_student = final_marks.id_student
WHERE proposal_marks.seminar = 1 AND final_marks.seminar = 2
GROUP BY students.id_student;