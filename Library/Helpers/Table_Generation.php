<?php
if(strpos(php_uname(),'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
}

class Table_Generation{
    
    protected $Database_connection; // required to interact with the database and obtain important table information 
    protected $Master_String;
    
    public function __construct(){
        $this->Database_connection = new Database_Connection();
    }
    
    

    
    private function print_Marker_Overall_Rows(mysqli_result $query_outcome){
        $return_string = "";
        while($row = $query_outcome->fetch_assoc()){
            $return_string .= "<tr>".
                                "<td>".$row["marker_name"]. " </td>".
                                "<td>".$row["mark_1_average"]."</td>".
                                "<td>".$row["mark_2_average"]."</td>".
                                "<td>".$row["mark_3_average"]."</td>".
                                "<td>".$row["overall_average"]."</td>".
                                "<td>".$row["number_of_marks"]."</td>".
                                "<td>".$row["minimum_mark"]."</td>".
                                "<td>".$row["maximum_mark"]."</td>".
                                "<td>".$row["standard_deviation"]."</td>".
                                "<td>0</td>".
                                "<td><a href=\"Marker.php?M_ID=1\">Inspect</a></td>".
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
     * Comment: added print_Marker_Overall_Rows 
     */
    public function generate_Marker_view_all_table(){
        
        $query =  "select markers_view";
        $queryResult = $this->Database_connection->query_Database($query);
        
        
        $return_string =
                "<div id=\"Table_wrapper\">".
                        "<table>"
                            . "<tr>"
                            .   "<th class=\"subheading\">Name</th>"
                            .   "<th class=\"subheading\">AVG M1</th>"
                            .   "<th class=\"subheading\">AVG M2</th>"
                            .   "<th class=\"subheading\">AVG M3</th>"
                            .   "<th class=\"subheading\">AVG Overall</th>"
                            .   "<th class=\"subheading\">Count</th>"
                            .   "<th class=\"subheading\">Min</th>"
                            .   "<th class=\"subheading\">Max</th>"
                            .   "<th class=\"subheading\" style =\"border-right:1px solid #000066;\">SD</th>"
                            .   "<th class=\"subheading\"></th>"
                            .  "</tr>";
                            
        if($queryResult != false ){
            $return_string .= $this->print_Marker_Overall_Rows($queryResult);
        }
                        
        $return_string .=  "</table>".
                "</div>";
        
        return $return_string;
    }
    
    /**
     * Description: produces the first of three tables displayed in the individual student page.
     * @param int $student_ID, the unique student identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    
    public function generate_student_overall_table($student_ID){
        $Return_String = "";
        $Return_String .=
                "<div id= \"student_overall_table_wrapper\">".
                    "<h4>Overall Seminar Marks:</h4>".
                    "<table>".
                              "<tr>"
                            .   "<th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>"
                            .   "<th colspan=\"4\" class=\"seminar_table_headings\">Final</th>"
                            . "</tr>" 
                            . "<tr>"
                            .   "<th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1 /10</th>"
                            .   "<th class=\"subheading\">Mark 2 /10</th>"
                            .   "<th class=\"subheading\">Mark 3 /80</th>"
                            .   "<th class=\"subheading\" style=\"border-right:1px solid black;\">Total</th>"
                            .   "<th class=\"subheading\">Mark 1 /10</th>"
                            .   "<th class=\"subheading\">Mark 2 /10</th>"
                            .   "<th class=\"subheading\">Mark 3/80</th>"
                            .   "<th class=\"subheading\"style=\"border-right:1px solid black;\">Total</th>"
                            .   "<th class=\"subheading\"style=\"border:1px solid black;\"> Total</th>"
                            .   "</tr>"
                            .   "<tr>"
                            // A call to " "
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .   "</tr>"
                    ."</table>"
                ."</div>";
               
                
                
        
        return $Return_String;
    }
    
         /**
     * Description: produces the second of three tables displayed in the individual student page. Responcible for the display of all proposal marks 
     * @param int $student_ID, the unique student identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_student_proposal_table($student_ID){
        $return_string ="";
        $return_string .="<div id=\"student_proposal_table_wrapper\">"
                    ."<h4>Proposal Seminar Marks:</h4>"
                    ."<table>"
                        ."<tr>"
                            ."<th class=\"subheading\">Marker Name</th>"
                            ."<th class=\"subheading\">Mark 1</th>"
                            ."<th class=\"subheading\">Mark 2</th>"
                            ."<th class=\"subheading\">Mark 3</th>"
                            ."<th class=\"subheading\">Total</th>"
                            ."<th><a href=\"dEntry.php\">Add</a></th>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                    ."</table>"
                ."</div>";
        return $return_string;
    }
         /**
        * Description: produces the third of the  three tables displayed in the individual student page. Responcible for the display of all final marks 
        * @param int $student_ID, the unique student identifier. Used in the DB query
        * @return string, the overall string to produce the table
        */    
    public function generate_student_final_table($student_ID){
        $return_string ="";
        $return_string .="<div id=\"student_final_table_wrapper\">"
                    ."<h4>Final Seminar Marks:</h4>"
                    ."<table>"
                        ."<tr>"
                            ."<th class=\"subheading\">Marker Name</th>"
                            ."<th class=\"subheading\">Mark 1</th>"
                            ."<th class=\"subheading\">Mark 2</th>"
                            ."<th class=\"subheading\">Mark 3</th>"
                            ."<th class=\"subheading\">Total</th>"
                            ."<th><a href=\"dEntry.php\">Add</a></th>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                    ."</table>"
                ."</div>";
        return $return_string;
    }
      /**
     * The method used for generating the table on the Student tab from the global navigation menu.
     * Description: A mysql query to made to collect all Students from a cohort and display their marks for their proposal and/or final seminar 
     */
    public function generate_Student_View_All_Table(){
        $Return_string = "";
        $Return_string .= 
                                
                    "<div id=\"Table_wrapper\">".
                        "<table>"
                            . "<tr>"
                            .   "<th colspan=\"1\"></th>"
                            .   "<th colspan=\"1\"></th>"
                            .   "<th colspan=\"4\" class=\"seminar_table_headings\">Proposal</th>"
                            .   "<th colspan=\"4\" class=\"seminar_table_headings\">Final</th>"
                            . "</tr>"
                            . "<tr>"
                            .   "<th class=\"subheading\">Student Name</th>"
                            .   "<th class=\"subheading\">Student Number</th>"
                            .   "<th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1</th>"
                            .   "<th class=\"subheading\">Mark 2</th>"
                            .   "<th class=\"subheading\">Mark 3</th>"
                            .   "<th class=\"subheading\" style=\"border-right:1px solid black;\">Total</th>"
                            .   "<th class=\"subheading\">Mark 1</th>"
                            .   "<th class=\"subheading\">Mark 2</th>"
                            .   "<th class=\"subheading\">Mark 3</th>"
                            .   "<th class=\"subheading\"style=\"border-right:1px solid black;\">Total</th>"
                            .   "<th class=\"subheading\"style=\"border-right:1px solid black;\"> Total</th>"
                            .   "<th class=\"subheading\"></th>"
                            .   "</tr>";
      
        
         // everything below will be swithced out for a for loop which will iterate over the mysql_result object.                   
                            
        $Return_string .=     "<tr>"
                                . "<td>Arun Gimblett</td>"
                                . "<td>21136295</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td><a href=\"Student.php?S_ID=21136295\">Inspect</a></td>"
                            . "</tr>"
                            . "<tr>"
                                . "<td>Arun Gimblett</td>"
                                . "<td>21136295</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td>0</td>"
                                . "<td><a href=\"Student.php?S_ID=21136295\">Inspect</a></td>"
                            . "</tr>";
     
               
        $Return_string .= "</table>".
                    "</div>";
        
        return $Return_string;
               
    }
    
      /**
     * Description: produces the first of three tables displayed in the individual Marker page.
     * @param int $Maker_ID, the unique Marker identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_marker_overall_table($Marker_ID){
        $Return_String = "";
        $Return_String .=
                "<div id= \"student_overall_table_wrapper\">".
                    "<h4>Marker Average Marks:</h4>".
                    "<table>".
                              "<tr>"
                            .   "<th colspan=\"4\" class=\"seminar_table_headings\">Averages</th>"
                            . "</tr>" 
                            . "<tr>"
                            .   "<th class=\"subheading\" style=\"border-left:1px solid black;\">Mark 1</th>"
                            .   "<th class=\"subheading\">Mark 2</th>"
                            .   "<th class=\"subheading\">Mark 3</th>"
                            .   "<th class=\"subheading\" style=\"border-right:1px solid black;\">Total</th>"
                            .   "</tr>"
                            .   "<tr>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .       "<td>0</td>"
                            .   "</tr>"
                    ."</table>"
                ."</div>";
               
                
                
        
        return $Return_String;
    }
      /**
     * Description: produces the second of three tables displayed in the individual Marker page.
     * @param int $Maker_ID, the unique Marker identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */    
    public function generate_marker_proposal_marks($marker_ID){
       $return_string ="";
        $return_string .="<div id=\"student_proposal_table_wrapper\">"
                    ."<h4>Proposal Seminar Marks:</h4>"
                    ."<table>"
                        ."<tr>"
                            ."<th class=\"subheading\">Student Name</th>"
                            ."<th class=\"subheading\">Student Number</th>"
                            ."<th class=\"subheading\">Mark 1</th>"
                            ."<th class=\"subheading\">Mark 2</th>"
                            ."<th class=\"subheading\">Mark 3</th>"
                            ."<th class=\"subheading\">Total</th>"
                            ."<th><a href=\"dEntry.php\">Add</a></th>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>21136295</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        
               
                    ."</table>"
                ."</div>";
        return $return_string; 
    }
          /**
     * Description: produces the third of three tables displayed in the individual Marker page.
     * @param int $Maker_ID, the unique Marker identifier. Used in the DB query
     * @return string, the overall string to produce the table
     */
    public function generate_marker_final_marks($Marker_ID){
        $return_string ="";
        $return_string .="<div id=\"student_final_table_wrapper\">"
                    ."<h4>Final Seminar Marks:</h4>"
                    ."<table>"
                        ."<tr>"
                            ."<th class=\"subheading\">Student Name</th>"
                            ."<th class=\"subheading\">Student Number</th>"
                            ."<th class=\"subheading\">Mark 1</th>"
                            ."<th class=\"subheading\">Mark 2</th>"
                            ."<th class=\"subheading\">Mark 3</th>"
                            ."<th class=\"subheading\">Total</th>"
                            ."<th><a href=\"dEntry.php\">Add</a></th>"
                        ."</tr>"
                        ."<tr>"
                        .   "<td>Test</td>"
                        .   "<td>21136295</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td>0</td>"
                        .   "<td><a href=\"dEntry.php\">Alter</a></td>"
                        ."</tr>"
                        
                    ."</table>"
                ."</div>";
        return $return_string;
        
    }
   
    
    public function return_Master_String(){
        return $this->Master_String;
    }
    
    
    
    
    
    
    
    
    
}
