DROP VIEW IF EXISTS seminarmarks.studentsView;
CREATE VIEW seminarmarks.studentsView AS
SELECT 	CONCAT(StudentFirstName, ' ', StudentLastName) AS StudentName,
		StudentNumber,
		AVG(ProposalMarks.Mark1) AS ProposalMark1,
		AVG(ProposalMarks.Mark2) AS ProposalMark2,
		AVG(ProposalMarks.Mark3) AS ProposalMark3,
		AVG(ProposalMarks.Mark1) + AVG(ProposalMarks.Mark2) + AVG(ProposalMarks.Mark3) AS ProposalTotal,
		AVG(FinalMarks.Mark1) AS FinalMark1,
		AVG(FinalMarks.Mark2) AS FinalMark2,
		AVG(FinalMarks.Mark3) AS FinalMark3,
		AVG(FinalMarks.Mark1) + AVG(FinalMarks.Mark2) + AVG(FinalMarks.Mark3) AS FinalTotal,
		AVG(ProposalMarks.Mark1) + AVG(ProposalMarks.Mark2) + AVG(ProposalMarks.Mark3) + AVG(FinalMarks.Mark1) + AVG(FinalMarks.Mark2) + AVG(FinalMarks.Mark3) as Total
FROM students 
INNER JOIN marks as ProposalMarks ON students.idStudent=ProposalMarks.idStudent
INNER JOIN marks as FinalMarks ON students.idStudent=FinalMarks.idStudent
WHERE ProposalMarks.seminar=1 AND FinalMarks.seminar=2
GROUP BY students.idStudent;

select * from studentsView;