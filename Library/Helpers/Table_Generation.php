<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";

class Table_Generation {

    protected $Database_connection; // required to interact with the database and obtain important table information 
    protected $current_cohort;

    public function __construct($cohort) {
        $this->Database_connection = new Database_Connection();
        $this->current_cohort = $cohort;
    }
    
    private function check_Row_Null($row){
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
            $array = ["proposal_mark_1_average","proposal_mark_2_average","proposal_mark_3_average","proposal_overall_average","final_mark_1_average","final_mark_2_average","final_mark_3_average","final_overall_average"];
            $row = $this->check_Row_Null($row);
            $return_string .= "<tr>";
            for($col=0;$col<count($array);$col++) {
                $return_string .= "<td>".$row[$array[$col]]."</td>";
            }
            $return_string .= "</tr>";
        }
        return $return_string;
    }

    private function print_Marker_Individual_Marks(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $array = ["student_name","student_number","mark_1","mark_2","mark_3","mark_total"];
            $row = $this->check_Row_Null($row);
            $return_string .= "<tr>";
            for($col=0;$col<count($array);$col++) {
                $return_string .= "<td>".$row[$array[$col]]."</td>";
            }
            $return_string .= "<td><a href=\"dEntry.php?Mark_ID=$row[id_mark]\">Alter</a></td></tr>";
        }
        return $return_string;
    }

    private function print_Marker_Overall(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $array = ["marker_name","mark_1_average","mark_2_average","overall_average","number_of_marks","minimum_mark","maximum_mark","standard_deviation"];
            $row = $this->check_Row_Null($row);
            $return_string .= "<tr>";
            for($col=0;$col<count($array);$col++) {
                $return_string .= "<td>".$row[$array[$col]]."</td>";
            }
            $return_string .= "<td><a href=\"Marker.php?M_ID=$row[id_marker]\">Inspect</a></td></tr>";
        }
        return $return_string;
    }

    private function print_Student_Overall(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $array = ["student_name","student_number","proposal_mark_1","proposal_mark_2","proposal_mark_3","proposal_total","final_mark_1","final_mark_2","final_mark_3","final_total"];
            $row = $this->check_Row_Null($row);
            $return_string .= "<tr>";
            for($col=0;$col<count($array);$col++) {
                $return_string .= "<td>".$row[$array[$col]]."</td>";
            }
            $return_string .= "<td><a href=\"Student.php?S_ID=$row[id_student]\">Inspect</a></td></tr>";
        }
        return $return_string;
    }

    private function print_Student_Individual(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $array = ["proposal_mark_1","proposal_mark_2","proposal_mark_3","proposal_total","final_mark_1","final_mark_2","final_mark_3","final_total"];
            $row = $this->check_Row_Null($row);
            $return_string .= "<tr>";
            for($col=0;$col<count($array);$col++) {
                $return_string .= "<td>".$row[$array[$col]]."</td>";
            }
            $return_string .= "</tr>";
        }
        return $return_string;
    }

    private function print_Student_Individual_Marks(mysqli_result $query_outcome) {
        $return_string = "";
        while ($row = $query_outcome->fetch_assoc()) {
            $array = ["marker_name","mark_1","mark_2","mark_3","mark_total"];
            $row = $this->check_Row_Null($row);
            $return_string .= "<tr>";
            for($col=0;$col<count($array);$col++) {
                $return_string .= "<td>".$row[$array[$col]]."</td>";
            }
            $return_string .= "<td><a href=\"dEntry.php?Mark_ID=$row[id_mark]\">Alter</a></td></tr>";
        }
        return $return_string;
    }

    public function generate_Marker_Overall($seminar) {
        $query = "";
        if($seminar==1) $query .= "SELECT * FROM markers_overall_proposal";
        if($seminar==2) $query .= "SELECT * FROM markers_overall_final";
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id=\"inner_table_wrapper\">";
        if($seminar==1) $return_string .= "<h4>Proposal Seminar Marks:</h4>";
        if($seminar==2) $return_string .= "<h4>Final Seminar Marks:</h4>";
        $return_string .= "<table><tr>
            <th class=\"subheading\">Name</th>
            <th class=\"subheading\">AVG M1 (10%)</th>
            <th class=\"subheading\">AVG M2 (10%)</th>
            <th class=\"subheading\">AVG M3 (80%)</th>
            <th class=\"subheading\">AVG Overall (100%)</th>
            <th class=\"subheading\">Count</th>
            <th class=\"subheading\">Min</th>
            <th class=\"subheading\">Max</th>
            <th class=\"subheading\" style =\"border-right:1px solid #000066;\">SD</th>
            <th class=\"subheading\"></th></tr>";
        if ($queryResult != false) { $return_string .= $this->print_Marker_Overall($queryResult); }
        return $return_string .= "</table></div>";
    }

    public function generate_Student_Individual($student_ID) {
        $query = "SELECT * FROM students_overall WHERE id_student=$student_ID";
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id=\"inner_table_wrapper\"><h4>Overall Seminar Marks:</h4><table><tr>
            <th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>
            <th colspan=\"4\" class=\"seminar_table_headings\">Final</th></tr><tr>
            <th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\" style=\"border-right:1px solid black;\">Total (100%)</th>
            <th class=\"subheading\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\"style=\"border-right:1px solid black;\">Total (100%)</th></tr>";
        if ($queryResult != false) { $return_string .= $this->print_Student_Individual($queryResult); }
        return $return_string .= "</table></div>";
    }

    public function generate_Student_Individual_Marks($seminar, $student_ID) {
        $query = "SELECT * FROM students_individual_marks WHERE id_student = $student_ID AND seminar = $seminar";
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id=\"inner_table_wrapper\">";
        if ($seminar == 1) { $return_string .= "<h4>Proposal Seminar Marks:</h4>"; }
        if ($seminar == 2) { $return_string .= "<h4>Final Seminar Marks:</h4>"; }
        $return_string .= "<table><tr>
            <th class=\"subheading\">Marker Name</th>
            <th class=\"subheading\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\">Total (100%)</th>
            <th><a href=\"dEntry.php?S_ID=".$student_ID."&seminar=".$seminar."\">Add</a></th></tr>";
        if ($queryResult != false) { $return_string .= $this->print_Student_Individual_Marks($queryResult); }
        return $return_string .= "</table></div>";
    }

    public function generate_Student_Overall() {
        $query = "SELECT * FROM students_overall where cohort=".$this->current_cohort['cohort'] ." and semester=".$this->current_cohort['semester'];
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id=\"inner_table_wrapper\"><table><tr>
            <th colspan=\"1\"></th>
            <th colspan=\"1\"></th>
            <th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>
            <th colspan=\"4\" class=\"seminar_table_headings\">Final</th></tr><tr>
            <th class=\"subheading\">Student Name</th>
            <th class=\"subheading\">Student Number</th>
            <th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\" style=\"border-right:1px solid black;\">Total (100%)</th>
            <th class=\"subheading\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\"style=\"border-right:1px solid black;\">Total (100%)</th>
            <th class=\"subheading\"></th></tr>";
        if ($queryResult != false) { $return_string .= $this->print_Student_Overall($queryResult); }
        return $return_string .= "</table></div>";
    }

    public function generate_Marker_Individual($marker_ID) {
        $query = "SELECT * FROM markers_individual WHERE id_marker = $marker_ID";
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = "<div id= \"inner_table_wrapper\"><h4>Marker Average Marks:</h4><table><tr>
            <th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>
            <th colspan=\"4\" class=\"seminar_table_headings\">Final</th></tr><tr>
            <th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\" style=\"border-right:1px solid black;\">Total (100%)</th>
            <th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1  (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\" style=\"border-right:1px solid black;\">Total (100%)</th></tr>";
        if ($queryResult != false) { $return_string .= $this->print_Marker_Individual($queryResult); }
        return $return_string .= "</table></div>";
    }

    public function generate_Marker_Individual_Marks($seminar, $marker_ID) {
        $query = "SELECT * FROM markers_individual_marks WHERE id_marker = $marker_ID AND seminar = $seminar";
        $queryResult = $this->Database_connection->query_Database($query);
        $return_string = 
            "<div id=\"inner_table_wrapper\">";
        if ($seminar == 1) { $return_string .= "<h4>Proposal Seminar Marks:</h4>"; }
        if ($seminar == 2) { $return_string .= "<h4>Final Seminar Marks:</h4>"; }
        $return_string .= "<table><tr>
            <th class=\"subheading\">Student Name</th>
            <th class=\"subheading\">Student Number</th>
            <th class=\"subheading\">Mark 1 (10%)</th>
            <th class=\"subheading\">Mark 2 (10%)</th>
            <th class=\"subheading\">Mark 3 (80%)</th>
            <th class=\"subheading\">Total (100%)</th>
            <th><a href=\"dEntry.php?M_ID=$marker_ID&seminar=$seminar\"\">Add</a></th></tr>";
        if ($queryResult != false) { $return_string .= $this->print_Marker_Individual_Marks($queryResult); }
        return $return_string .= "</table></div>";
    }
}
