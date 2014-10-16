<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/User_Control.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/error_Handler.php";
include_once "/var/www/html/APHB-3200/Library/Include/PHPExcel.php";
include_once "/var/www/html/APHB-3200/Library/Include/PHPExcel/IOFactory.php";

/*
 * Class for handling CSV import and XLS output
 */
class CSV_Handler {
    protected $Database_connection; //Connection to MySQL database
    protected $current_cohort; //Current cohort variable'
    protected $Error_Handler; //Error handler
    
    /**
     * Initialize variables
     * 
     * @param type $cohort Current cohort variable
     */
    public function __construct($cohort) {
        $this->Database_connection = new Database_Connection();
        $this->current_cohort = $cohort;
        $this->Error_Handler = new error_Handler();
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
    
    public function import() {
        $return_string = "";
        
        $temp = "/var/www/html/APHB-3200/Temp/".$_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"],$temp);
        $objPHPExcel = PHPExcel_IOFactory::load($temp);
        $import = $_GET["import"];
        
        if($import == "markers") {
            $return_string .= $this->import_markers($objPHPExcel);
        } else if($import == "students") {
            $return_string .= $this->import_students($objPHPExcel);
        } else if($import == "marks") {
            $return_string .= $this->import_marks($objPHPExcel);
        } else {
            $return_string .= "<br>Only students, markers, and marks import is available.";
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
        $return_string = "";
        $lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        for($i = 2; $i<$lastRow+1; $i++) {
            $row = $objPHPExcel->getActiveSheet()->rangeToArray("A$i:E$i");
            if($this->Error_Handler->new_student_check($row[0][2], $row[0][3],  $row[0][4], $row[0][0], $row[0][1])) {
                $new_id = $this->Database_connection->return_new_id('student');
                $query = "INSERT INTO seminar_marks.students VALUES (".$new_id.",\"".$row[0][3]."\",\"".$row[0][4]."\",".$row[0][2].",".$row[0][0].",".$row[0][1].")";
                $this->Database_connection->query_Database($query);
                if($new_id != $this->Database_connection->return_new_id('student')) {
                    $return_string .= "Student ".$row[0][3]." ".$row[0][4].", SN: ".$row[0][2]." added successfully!<br>";
                } else {
                    $return_string .= "Student ".$row[0][3]." ".$row[0][4].", SN: ".$row[0][2]." failed to be added to the database.<br>";
                }
            } else {
                $return_string .= "Student ".$row[0][3]." ".$row[0][4].", SN: ".$row[0][2]." failed due to bad data in row.<br>";
            }
        }
        return $return_string;
    }
    
    public function import_markers($objPHPExcel) {
        $return_string = "";
        $lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        for($i = 2; $i<$lastRow+1; $i++) {
            $row = $objPHPExcel->getActiveSheet()->rangeToArray("A$i:B$i");
            $new_id = $this->Database_connection->return_new_id('marker');
            if($this->Error_Handler->new_marker_check($row[0][0],$row[0][1],$new_id)) {
                $query = "INSERT INTO seminar_marks.markers VALUES (".$new_id.",\"".$row[0][0]."\",\"".$row[0][1]."\")";
                $this->Database_connection->query_Database($query);
                if($new_id != $this->Database_connection->return_new_id('student')) {
                    $return_string .= "Marker ".$row[0][0]." ".$row[0][1]." added successfully!<br>";
                } else {
                    $return_string .= "Marker ".$row[0][0]." ".$row[0][1]." failed to be added to the database.<br>";
                }
            } else {
                $return_string .= "Marker ".$row[0][0]." ".$row[0][1]." failed, due to either bad data in row or marker already exists.<br>";
            }
        }
        return $return_string;
    }
    
    public function import_marks($objPHPExcel) {
        $return_string = "";
        $lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
        for($i = 2; $i<$lastRow+1; $i++) {
            $row = $objPHPExcel->getActiveSheet()->rangeToArray("A$i:I$i");
            $id_student_query = "SELECT id_student FROM students WHERE cohort = ".$row[0][0]." AND semester = ".$row[0][1]." AND student_number = ".$row[0][2];
            $id_student_result = $this->Database_connection->query_Database($id_student_query);
            $id_student_row = $result->fetch_assoc();
            $id_student = $id_student_row['id_student'];
            $id_marker_query = "SELECT id_marker FROM markers WHERE marker_first_name = \"".$row[0][7]."\" AND marker_last_name = \"".$row[0][8]."\"";
            $id_marker_result = $this->Database_connection->query_Database($id_marker_query);
            $id_marker_row = $result->fetch_assoc();
            $id_marker = $rid_marker_ow['id_marker'];
            $new_id = $this->Database_connection->return_new_id('marks');
            if($this->Error_Handler->validate_mark(array($row[0][3],$row[0][4],$row[0][5]),$id_marker,$id_student,$row[0][6],$new_id)) {
                $query = "INSERT INTO seminar_marks.marks VALUES (".$new_id.",".$row[0][3].",".$row[0][4].",".$row[0][5].",".$row[0][6].",".$id_student.",".$id_marker;
                $this->Database_connection->query_Database($query);
                if($new_id != $this->Database_connection->return_new_id('student')) {
                    $return_string .= "Mark by ".$row[0][7]." ".$row[0][8]." on student ".$row[0][2]." added successfully!<br>";
                } else {
                    $return_string .= "Mark by ".$row[0][7]." ".$row[0][8]." on student ".$row[0][2]." failed to be added to the database.<br>";
                }
            } else {
                $return_string .= "Mark by ".$row[0][7]." ".$row[0][8]." on student ".$row[0][2]." failed, due to either bad data in row or mark already exists.<br>";
            }
        }
        return $return_string;
    }
}