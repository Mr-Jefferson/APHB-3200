DROP VIEW IF EXISTS seminarmarks.markersView;
CREATE VIEW seminarmarks.markersView AS
SELECT 	marks.idMarker,
		CONCAT(MarkerFirstName, ' ', MarkerLastName) AS MarkerName,
		AVG(Mark1) AS Mark1Average,
		AVG(Mark2) AS Mark2Average,
		AVG(Mark3) AS Mark3Average,
		AVG(Mark1)+AVG(Mark2)+AVG(Mark3) AS OverallAverage,
		COUNT(Mark1) AS NumberOfMarks,
		MIN(Mark1+Mark2+Mark3) AS MinimumMark,
		MAX(Mark1+Mark2+Mark3) AS MaximumMark,
		STDDEV(Mark1+Mark2+Mark3) AS StdDeviation
		FROM marks INNER JOIN markers ON markers.idMarker = marks.idMarker GROUP BY marks.idMarker;