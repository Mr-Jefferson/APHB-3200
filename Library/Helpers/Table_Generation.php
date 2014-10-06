<?php

if (strpos(php_uname(), 'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
}

class Table_Generation {

    protected $Database_connection; // required to interact with the database and obtain important table information 
    protected $current_cohort;
    protected $Master_String;

    public function __construct($cohort) {
        $this->Database_connection = new Database_Connection();
        $this->current_cohort = $cohort;
    }
    
    private function check_for_null($row){
        foreach ($row as $key => $value) {
            if($row[$key] == null){
                $row[$key] = "n/a";
            }
        }
        return $row;
    }

    private function print_Marker_Individual(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $return_string .=
                    "<tr>" .
                    "<td>" . $row['mark_1_average'] . "</td>" .
                    "<td>" . $row['mark_2_average'] . "</td>" .
                    "<td>" . $row['mark_3_average'] . "</td>" .
                    "<td>" . $row['overall_average'] . "</td>" .
                    "</tr>";
        }
        return $return_string;
    }

    private function print_Marker_Individual_Marks(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $return_string .=
                    "<tr>" .
                    "<td>" . $row['student_name'] . "</td>" .
                    "<td>" . $row['student_number'] . "</td>" .
                    "<td>" . $row['mark_1'] . "</td>" .
                    "<td>" . $row['mark_2'] . "</td>" .
                    "<td>" . $row['mark_3'] . "</td>" .
                    "<td>" . $row['mark_total'] . "</td>" .
                    "<td><a href=\"dEntry.php?Mark_ID=" . $row['id_mark'] . "\">Alter</a></td>" .
                    "</tr>";
        }
        return $return_string;
    }

    private function print_Marker_Overall(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $return_string .=
                    "<tr>" .
                    "<td>" . $row["marker_name"] . "</td>" .
                    "<td>" . $row["mark_1_average"] . "</td>" .
                    "<td>" . $row["mark_2_average"] . "</td>" .
                    "<td>" . $row["mark_3_average"] . "</td>" .
                    "<td>" . $row["overall_average"] . "</td>" .
                    "<td>" . $row["number_of_marks"] . "</td>" .
                    "<td>" . $row["minimum_mark"] . "</td>" .
                    "<td>" . $row["maximum_mark"] . "</td>" .
                    "<td>" . $row["standard_deviation"] . "</td>" .
                    "<td><a href=\"Marker.php?M_ID=" . $row['id_marker'] . "\">Inspect</a></td>" .
                    "</tr>";
        }
        return $return_string;
    }

    private function print_Student_Overall(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $row = $this->check_for_null($row);
            $return_string .=
                    "<tr>" .
                    "<td>" . $row["student_name"] . "</td>" .
                    "<td>" . $row["student_number"] . "</td>" .
                    "<td>" . $row["proposal_mark_1"] . "</td>" .
                    "<td>" . $row["proposal_mark_2"] . "</td>" .
                    "<td>" . $row["proposal_mark_3"] . "</td>" .
                    "<td>" . $row["proposal_total"] . "</td>" .
                    "<td>" . $row["final_mark_1"] . "</td>" .
                    "<td>" . $row["final_mark_2"] . "</td>" .
                    "<td>" . $row["final_mark_3"] . "</td>" .
                    "<td>" . $row["final_total"] . "</td>" .
                    "<td>" . $row["total"] . "</td>" .
                    "<td><a href=\"Student.php?S_ID=" . $row['id_student'] . "\">Inspect</a></td>" .
                    "</tr>";
        }
        return $return_string;
    }

    private function print_Student_Individual(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $return_string .=
                    "<tr>" .
                    "<td>" . $row["proposal_mark_1"] . "</td>" .
                    "<td>" . $row["proposal_mark_2"] . "</td>" .
                    "<td>" . $row["proposal_mark_3"] . "</td>" .
                    "<td>" . $row["proposal_total"] . "</td>" .
                    "<td>" . $row["final_mark_1"] . "</td>" .
                    "<td>" . $row["final_mark_2"] . "</td>" .
                    "<td>" . $row["final_mark_3"] . "</td>" .
                    "<td>" . $row["final_total"] . "</td>" .
                    "<td>" . $row["total"] . "</td>" .
                    "</tr>";
        }
        return $return_string;
    }

    private function print_Student_Individual_Marks(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $return_string .=
                    "<tr>" .
                    "<td>" . $row["marker_name"] . "</td>" .
                    "<td>" . $row["mark_1"] . "</td>" .
                    "<td>" . $row["mark_2"] . "</td>" .
                    "<td>" . $row["mark_3"] . "</td>" .
                    "<td>" . $row["mark_total"] . "</td>" .
                    "<td><a href=\"dEntry.php?Mark_ID=" . $row['id_mark'] . "\">Alter</a></td>" .
                    "</tr>";
        }
        return $return_string;
    }

    /**
     * The method used for generating the table on the marker tab from the global navigation menu.
     * Description: A mysql query to made to collect all markers and produce the appropriate statistics per marker
     * Author:  Arun Gimblett 
     * Started on: 24/09/2014, 4:30
     * Completed on: 24/9/2014, 5:19
     * Comment: added print_Marker_Overall 
     */
    public function generate_Marker_Overall() {
        $query = "select * from markers_overall";
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id=\"Table_wrapper\">" .
                "<table>" .
                "<tr>" .
                "<th class=\"subheading\">Name</th>" .
                "<th class=\"subheading\">AVG M1</th>" .
                "<th class=\"subheading\">AVG M2</th>" .
                "<th class=\"subheading\">AVG M3</th>" .
                "<th class=\"subheading\">AVG Overall</th>" .
                "<th class=\"subheading\">Count</th>" .
                "<th class=\"subheading\">Min</th>" .
                "<th class=\"subheading\">Max</th>" .
                "<th class=\"subheading\" style =\"border-right:1px solid #000066;\">SD</th>" .
                "<th class=\"subheading\"></th>" .
                "</tr>";
        if ($queryResult != false) {
            $return_string .= $this->print_Marker_Overall($queryResult);
        }
        $return_string .= "</table>" . "</div>";
        return $return_string;
    }

    /**
     * Description: produces the first of three tables displayed in the individual student page.
     * @param int $student_ID, the unique student identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_Student_Individual($student_ID) {
        $query = "select * from students_overall where id_student=" . $student_ID;
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id= \"student_overall_table_wrapper\">" .
                "<h4>Overall Seminar Marks:</h4>" .
                "<table>" .
                "<tr>" .
                "<th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>" .
                "<th colspan=\"4\" class=\"seminar_table_headings\">Final</th>" .
                "</tr>" .
                "<tr>" .
                "<th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1 /10</th>" .
                "<th class=\"subheading\">Mark 2 /10</th>" .
                "<th class=\"subheading\">Mark 3 /80</th>" .
                "<th class=\"subheading\" style=\"border-right:1px solid black;\">Total</th>" .
                "<th class=\"subheading\">Mark 1 /10</th>" .
                "<th class=\"subheading\">Mark 2 /10</th>" .
                "<th class=\"subheading\">Mark 3/80</th>" .
                "<th class=\"subheading\"style=\"border-right:1px solid black;\">Total</th>" .
                "<th class=\"subheading\"style=\"border:1px solid black;\"> Total</th>" .
                "</tr>";
        if ($queryResult != false) {
            $return_string .= $this->print_Student_Individual($queryResult);
        }
        $return_string .= "</table>" . "</div>";
        return $return_string;
    }

    /**
     * Description: produces the second of three tables displayed in the individual student page. Responcible for the display of all proposal marks 
     * @param int $student_ID, the unique student identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_Student_Individual_Marks($seminar, $student_ID) {
        $query = "select * from students_individual_marks where id_student = " . $student_ID . " and seminar = " . $seminar;
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "";
        if ($seminar == 1) {
            $return_string .= "<div id=\"student_proposal_table_wrapper\">" . "<h4>Proposal Seminar Marks:</h4>";
        }
        if ($seminar == 2) {
            $return_string .= "<div id=\"student_final_table_wrapper\">" . "<h4>Final Seminar Marks:</h4>";
        }
        $return_string .=
                "<table>" .
                "<tr>" .
                "<th class=\"subheading\">Marker Name</th>" .
                "<th class=\"subheading\">Mark 1</th>" .
                "<th class=\"subheading\">Mark 2</th>" .
                "<th class=\"subheading\">Mark 3</th>" .
                "<th class=\"subheading\">Total</th>" .
                "<th><a href=\"dEntry.php?S_ID=".$student_ID."&seminar=".$seminar."\">Add</a></th>" .
                "</tr>";
        if ($queryResult != false) {
            $return_string .= $this->print_Student_Individual_Marks($queryResult);
        }
        $return_string .= "</table>" . "</div>";
        return $return_string;
    }

    /**
     * The method used for generating the table on the Student tab from the global navigation menu.
     * Description: A mysql query to made to collect all Students from a cohort and display their marks for their proposal and/or final seminar 
     */
    public function generate_Student_Overall() {
        $query = "select * from students_overall where cohort =".$this->current_cohort['cohort']." and semester = ". $this->current_cohort['semester'];
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id=\"Table_wrapper\">" .
                "<table>" .
                "<tr>" .
                "<th colspan=\"1\"></th>" .
                "<th colspan=\"1\"></th>" .
                "<th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>" .
                "<th colspan=\"4\" class=\"seminar_table_headings\">Final</th>" .
                "</tr>" .
                "<tr>" .
                "<th class=\"subheading\">Student Name</th>" .
                "<th class=\"subheading\">Student Number</th>" .
                "<th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1</th>" .
                "<th class=\"subheading\">Mark 2</th>" .
                "<th class=\"subheading\">Mark 3</th>" .
                "<th class=\"subheading\" style=\"border-right:1px solid black;\">Total</th>" .
                "<th class=\"subheading\">Mark 1</th>" .
                "<th class=\"subheading\">Mark 2</th>" .
                "<th class=\"subheading\">Mark 3</th>" .
                "<th class=\"subheading\"style=\"border-right:1px solid black;\">Total</th>" .
                "<th class=\"subheading\"style=\"border-right:1px solid black;\"> Total</th>" .
                "<th class=\"subheading\"></th>" .
                "</tr>";
        if ($queryResult != false) {
            $return_string .= $this->print_Student_Overall($queryResult);
        }
        $return_string .= "</table>" . "</div>";
        return $return_string;
    }

    /**
     * Description: produces the first of three tables displayed in the individual Marker page.
     * @param int $Maker_ID, the unique Marker identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_Marker_Individual($marker_ID) {
        $query = "select * from markers_overall where id_marker = " . $marker_ID;
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id= \"student_overall_table_wrapper\">" .
                "<h4>Marker Average Marks:</h4>" .
                "<table>" .
                "<tr>" .
                "<th colspan=\"4\" class=\"seminar_table_headings\">Averages</th>" .
                "</tr>" .
                "<tr>" .
                "<th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1</th>" .
                "<th class=\"subheading\">Mark 2</th>" .
                "<th class=\"subheading\">Mark 3</th>" .
                "<th class=\"subheading\" style=\"border-right:1px solid black;\">Total</th>" .
                "</tr>";
        if ($queryResult != false) {
            $return_string .= $this->print_Marker_Individual($queryResult);
        }
        $return_string .= "</table>" . "</div>";
        return $return_string;
    }

    /**
     * Description: produces the second of three tables displayed in the individual Marker page.
     * @param int $Maker_ID, the unique Marker identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_Marker_Individual_Marks($seminar, $marker_ID) {
        $query = "select * from markers_individual_marks where id_marker = " . $marker_ID . " and seminar = " . $seminar;
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "";
        if ($seminar == 1) {
            $return_string .="<div id=\"student_proposal_table_wrapper\"><h4>Proposal Seminar Marks:</h4>";
        }
        if ($seminar == 2) {
            $return_string .="<div id=\"student_proposal_table_wrapper\"><h4>Final Seminar Marks:</h4>";
        }
        $return_string .=
                "<table>" .
                "<tr>" .
                "<th class=\"subheading\">Student Name</th>" .
                "<th class=\"subheading\">Student Number</th>" .
                "<th class=\"subheading\">Mark 1</th>" .
                "<th class=\"subheading\">Mark 2</th>" .
                "<th class=\"subheading\">Mark 3</th>" .
                "<th class=\"subheading\">Total</th>" .
                "<th><a href=\"dEntry.php?M_ID=".$marker_ID."&seminar=".$seminar."\"\">Add</a></th>" .
                "</tr>";
        if ($queryResult != false) {
            $return_string .= $this->print_Marker_Individual_Marks($queryResult);
        }
        $return_string .= "</table>" . "</div>";
        return $return_string;
    }

    public function return_Master_String() {
        return $this->Master_String;
    }

}
