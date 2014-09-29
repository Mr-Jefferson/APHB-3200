DROP VIEW IF EXISTS seminar_marks.markers_view;
CREATE VIEW seminar_marks.markers_view AS
SELECT  marks.id_marker,
        CONCAT(marker_first_name, ' ', marker_last_name) AS marker_name,
        AVG(mark_1) AS mark_1_average,
        AVG(mark_2) AS mark_2_average,
        AVG(mark_3) AS mark_3_average,
        AVG(mark_1) + AVG(mark_2) + AVG(mark_3) AS overall_average,
        COUNT(mark_1) AS number_of_marks,
        MIN(mark_1 + mark_2 + mark_3) AS minimum_mark,
        MAX(mark_2 + mark_3) AS maximum_mark,
        STDDEV(mark_1 + mark_2 + mark_3) AS standard_deviation
        FROM marks INNER JOIN markers ON markers.id_marker = marks.id_marker GROUP BY marks.id_marker;