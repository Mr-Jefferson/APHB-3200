<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/User_Control.php";
include_once "/var/www/html/APHB-3200/Library/Include/PHPExcel.php";
include_once "/var/www/html/APHB-3200/Library/Include/PHPExcel/IOFactory.php";

/*
 * Class for handling CSV import and XLS output
 */
class CSV_Handler {
    protected $Database_connection; //Connection to MySQL database
    protected $current_cohort; //Current cohort variable
    
    /**
     * Initialize variables
     * 
     * @param type $cohort Current cohort variable
     */
    public function __construct($cohort) {
        $this->Database_connection = new Database_Connection();
        $this->current_cohort = $cohort;
    }
    
    /**
     * Deletes first line of a file
     * 
     * @param type $filename File path to file that first line is deleted from
     */
    private function delete_First_Line($filename) {
        $file = file($filename);
        unset($file[0]);
        file_put_contents($filename, $file);
    }
    
    /**
     * Edits student csv import file for data import into MySQL
     * 
     * @param type $filename File path to csv import file
     * @return int Number of rows in csv import file
     */
    private function edit_Students($filename) {
        $file = file($filename);
        $i=0;
        for(; $i<count($file); $i++) {
            $line = str_getcsv($file[$i],",");
            $new_id_student = $this->Database_connection->return_new_id("student") + $i;
            $file[$i] = $new_id_student . ",$line[0],$line[1],$line[2],$line[3],$line[4] ";
        }
        file_put_contents($filename, $file);
        return $i;
    }
    
    /**
     * Edits markers csv import file for data import into MySQL
     * 
     * @param type $filename File path to csv import file
     * @return int Number of rows in csv import file
     */
    private function edit_Markers($filename) {
        $file = file($filename);
        $i=0;
        for(; $i<count($file); $i++) {
            $line = str_getcsv($file[$i],",");
            $new_id_marker = $this->Database_connection->return_new_id("marker") + $i;
            $file[$i] =  $new_id_marker . ",$line[0],$line[1] ";
        }
        file_put_contents($filename, $file);
        return $i;
    }
    
    /**
     * Edits marks csv import file for data import into MySQL
     * 
     * @param type $filename File path to csv import file
     * @return int Number of rows in csv import file
     */
    private function edit_Marks($filename) {
        $file = file($filename);
        $i=0;
        for(; $i<count($file); $i++) {
            $line = str_getcsv($file[$i],",");
            $new_id_mark = $this->Database_connection->return_new_id("marks") + $i;
            $file[$i] = $new_id_mark . ",$line[3],$line[4],$line[5],$line[6],";
            $student_query = "SELECT id_student FROM students WHERE cohort = $line[0] AND semester = $line[1] AND student_number = $line[2]";
            $student_result = $this->Database_connection->query_Database($student_query);
            $student_row = $student_result->fetch_assoc();
            $file[$i] .= $student_row['id_student'] . ",";
            $marker_query = "SELECT id_marker FROM markers WHERE marker_first_name = \"$line[7]\" AND marker_last_name = \"$line[8]\"";
            $marker_result = $this->Database_connection->query_Database($marker_query);
            $marker_row = $marker_result->fetch_assoc();
            $file[$i] .= $marker_row['id_marker'] . " ";
        }
        file_put_contents($filename, $file);
        return $i;
    }
    
    /**
     * Edits marks xls export file
     * Exports from MySQL into the xls file
     * Saves marks.xls in a downloadable location, appending download link to served page
     * 
     * @return string $return_string HTML href to download export file
     */
    private function edit_Export() {
        $return_string = "";
        $relation = $_GET["export"];

        if($relation == "marks") {
            $template = "/var/www/html/APHB-3200/Temp/template.xls";
            $output = "/var/www/html/APHB-3200/Temp/marks.xls";
            $send = "/APHB-3200/Temp/marks.xls";
            $objPHPExcel = PHPExcel_IOFactory::load($template);

            $query = "SELECT * FROM students_overall_output WHERE cohort=".$this->current_cohort['cohort'] ." and semester=".$this->current_cohort['semester'];
            $result = $this->Database_connection->query_Database($query);

            $rowCount = 3;
            while($row = $result->fetch_assoc()) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['student_last_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['student_first_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['student_number']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['proposal_mark_1_2_average']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['proposal_mark_3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['proposal_mark_1_2_3_weighted']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['final_mark_1_2_average']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['final_mark_3']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['final_mark_1_2_3_weighted']);
                $rowCount++;
            }
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save($output);
            $return_string .= "<br><a href=\"$send\" download>Click to download marks file!</a>";
        } else {
            $return_string = "<br>Only marks export is available.";
        }
        return $return_string;
    }
    
    /**
     * Manages what type of importing or exporting has been requested:
     * Students import, Markers import, Marks import
     */
    public function import() {
        $return_string = "";
        
        $temp = "/var/www/html/APHB-3200/Temp/".$_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"],$temp);
        $objPHPExcel = PHPExcel_IOFactory::load($temp);
        $import = $_GET["import"];
        
        /**if($import == "marks") {
            $before = $this->Database_connection->return_new_id("marks");
            $return_number = $this->edit_Marks($temp);
            for($i = 0; $i<count($return_number);$i++){
                $return_string .= $return_number[$i];
            }
            $query .= "(id_mark, mark_1, mark_2, mark_3, seminar, id_student, id_marker)";
            $this->Database_connection->query_Database($query);
            $after = $this->Database_connection->return_new_id("marks");
            $added = $after - $before;
            $return_string .= "<br>Marks in file: $return_number <br>Marks added to database: $added";
        } else **/
        if($import == "students") {
            $return_string .= $this->import_students($objPHPExcel);
            /**
            $before = $this->Database_connection->return_new_id("student");
            $return_number = $this->edit_Students($temp);
            $query .= "(id_student, cohort, semester, student_number, student_first_name, student_last_name)";
            $this->Database_connection->query_Database($query);
            $after = $this->Database_connection->return_new_id("student");
            $added = $after - $before;
            $return_string .= "<br>Students in file: $return_number <br>Students added to database: $added";
             **/
        } /**else if($import == "markers") {
            $before = $this->Database_connection->return_new_id("marker");
            $return_number = $this->edit_Markers($temp);
            $query .= "(id_marker, marker_first_name, marker_last_name)";
            $this->Database_connection->query_Database($query);
            $after = $this->Database_connection->return_new_id("marker");
            $added = $after - $before;
            $return_string .= "<br>Markers in file: $return_number <br>Markers added to database: $added";
        } **/else {
            $return_string .= "<br>Only student, marker, and mark import is available (UNDER EDIT NICK)";
        }
        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);
        return $return_string;
    }
    
    public function export() {
        $return_string = $this->edit_Export();
        return $return_string;
    }
    
    public function import_students($objPHPExcel) {
        $lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        $string = "";
        for($i = 2; $i<$lastRow+1; $i++) {
            $array = $objPHPExcel->getActiveSheet()->rangeToArray("A$i:E$i");
            
            $string .= var_export($array);
        }
        return $string."HELLO";
    }
}