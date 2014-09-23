DROP VIEW IF EXISTS seminarmarks.studentsView;

CREATE VIEW seminarmarks.studentsView AS
SELECT 	CONCAT(StudentFirstName, ' ', StudentLastName) AS StudentName,
		StudentNumber,
		marks1.Mark1 AS ProposalMark1,
		marks1.Mark2 AS ProposalMark2,
		marks1.Mark3 AS ProposalMark3,
		marks1.Mark1*0.1+marks1.Mark2*0.1+marks1.Mark3*0.8 AS ProposalTotal, #Hard-coded scaling
		marks2.Mark1 AS FinalMark1,
		marks2.Mark2 AS FinalMark2,
		marks2.Mark3 AS FinalMark3,
		marks2.Mark1*0.1+marks2.Mark2*0.1+marks2.Mark3*0.8 AS FinalTotal, #Hard-coded scaling
		((marks1.Mark1+marks1.Mark2+marks1.Mark3)/3+(marks2.Mark1+marks2.Mark2+marks2.Mark3)/3)/2 as Total
FROM students INNER JOIN marks as marks1 ON students.idStudent=marks1.idStudent
		INNER JOIN marks as marks2 ON students.idStudent=marks2.idStudent
WHERE marks1.Cohort=2014 AND marks2.Cohort=2014 AND marks1.seminar=1 AND marks2.seminar=2;

select * from studentsView;