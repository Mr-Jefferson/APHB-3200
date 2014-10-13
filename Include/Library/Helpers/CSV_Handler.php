<?php
if (strpos(php_uname(), 'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/User_Control.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Include/PHPExcel.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Include/PHPExcel/IOFactory.php";

} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/User_Control.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Include/PHPExcel.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Include/PHPExcel/IOFactory.php";
}

class CSV_Handler {
    protected $Database_connection;
    
    private function delete_first_line($filename) {
        $file = file($filename);
        unset($file[0]);
        file_put_contents($filename, $file);
    }
    
    private function editMarks($filename) {
        $file = file($filename);
        $return_string = "";
        for($i=0; $i<count($file); $i++) {
            $line = str_getcsv($file[$i],",");
            $file[$i] = $line[3] . "," . $line[4] . "," . $line[5] . "," . $line[6] . ",";
            
            $student_query = "SELECT id_student FROM students WHERE cohort = " . $line[0] . " AND semester = " . $line[1] . " AND student_number = " . $line[2];
            $student_result = $this->Database_connection->query_Database($student_query);
            $student_row = $student_result->fetch_assoc();
            $file[$i] .= $student_row['id_student'] . ",";
            
            $marker_query = "SELECT id_marker FROM markers WHERE marker_first_name = \"$line[7]\" AND marker_last_name = \"$line[8]\"";
            $marker_result = $this->Database_connection->query_Database($marker_query);
            $marker_row = $marker_result->fetch_assoc();
            $file[$i] .= $marker_row['id_marker'] . "\n";
            
            $return_string .= $file[$i];
        }
        file_put_contents($filename, $file);
        return $return_string;
    }
    
    public function __construct() {
        $this->Database_connection = new Database_Connection();
    }
    
    public function file_manager() {
        $return_string = "";
        if(isset($_FILES["file"])){
            $temp = "/var/www/html/APHB-3200/temp.csv";
            //$temp = "C:\\xampp\\mysql\\data\\temp.csv";
            move_uploaded_file($_FILES["file"]["tmp_name"],$temp);
            $this->delete_first_line($temp);
            $relation = $_GET["import"];
            
            $return_string .= "<br>";
            $return_string .= "Upload: " . $_FILES["file"]["name"] . "<br>";
            
            $return_string .= "Temporary file location: " . $temp . "<br>";
            
            $query = "LOAD DATA LOCAL INFILE " . 
                    "\"C:\\\\xampp\\\\mysql\\\\data\\\\temp.csv\" " .
                    "INTO TABLE " . $relation . " " .
                    "FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' " .
                    "LINES TERMINATED BY '\n' ";
            
            if($relation == "marks") {
                $this->editMarks($temp);
                $query .= "(mark_1, mark_2, mark_3, seminar, id_student, id_marker)";
            } else if($relation == "students") {
                $query .= "(cohort,semester,student_number,student_first_name,student_last_name)";
            } else if($relation == "markers") {
                $query .= "(marker_first_name,marker_last_name)";
            }
            $return_string .= "If importing worked correctly, you should see the values in the tables.";
            $this->Database_connection->query_Database($query);
        }
        if(isset($_GET["export"])) {
            $relation = $_GET["export"];
            $template = "/var/www/html/APHB-3200/template.xls";
            //$template = "C:/xampp/htdocs/CITS3200_Group_H/Template.xls";
            
            if($relation == "marks") {
                $output = "/var/www/html/APHB-3200/marks.xls";
                //$output = "C:/xampp/htdocs/CITS3200_Group_H/marks.xls";
                $objPHPExcel = PHPExcel_IOFactory::load($template);
                
                $query = "SELECT * FROM students_overall_output";
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
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                $objWriter->save($output);
                $return_string .= "<br><a href=\"$output\" download>Click to download marks file!</a>";
            }
        }
        return $return_string;
    }
    public function file_Export() {
        
    }
}


