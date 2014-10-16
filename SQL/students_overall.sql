USE seminar_marks;
DROP VIEW IF EXISTS students_overall;

CREATE VIEW students_overall AS
SELECT 	CONCAT(student_first_name, ' ', student_last_name) AS student_name,
        student_last_name,
        student_first_name,
        student_number,
        TRUNCATE(AVG(proposal_marks.mark_1),2) AS proposal_mark_1,
        TRUNCATE(AVG(proposal_marks.mark_2),2) AS proposal_mark_2,
        TRUNCATE(AVG(proposal_marks.mark_3),2) AS proposal_mark_3,
        TRUNCATE(AVG(proposal_marks.mark_1)*0.1 + AVG(proposal_marks.mark_2)*0.1 + AVG(proposal_marks.mark_3)*0.8,2) AS proposal_total,
        TRUNCATE(AVG(final_marks.mark_1),2) AS final_mark_1,
        TRUNCATE(AVG(final_marks.mark_2),2) AS final_mark_2,
        TRUNCATE(AVG(final_marks.mark_3),2) AS final_mark_3,
        TRUNCATE(AVG(final_marks.mark_1) + AVG(final_marks.mark_2) + AVG(final_marks.mark_3),2) AS final_total,
        students.id_student as id_student,
        students.cohort as cohort,
        students.semester as semester

FROM	students LEFT JOIN 
        marks proposal_marks ON students.id_student = proposal_marks.id_student AND proposal_marks.seminar=1 LEFT JOIN
        marks final_marks ON students.id_student = final_marks.id_student AND final_marks.seminar=2
GROUP BY students.id_student
ORDER BY student_last_name DESC, student_first_name DESC, student_number DESC;

select * from students_overall
