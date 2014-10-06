<?php
if (strpos(php_uname(), 'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/User_Control.php";
    
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/User_Control.php";
}

class CSV_Handler {
    protected $Database_connection;
    
    public function __construct() {
        $this->Database_connection = new Database_Connection();
    }
        
    public function file_Import() {
        $return_string = "";
        if (!$_FILES["file"]["size"]>0) {
        } else {
            $return_string .= "Upload: " . $_FILES["file"]["name"] . "<br>";
            $return_string .= "Type: " . $_FILES["file"]["type"] . "<br>";
            $return_string .= "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            $return_string .= "Stored in: " . $_FILES["file"]["tmp_name"];
            $fileName = $_FILES["file"]["tmp_name"];
            $query = "LOAD DATA INFILE " . 
                $_FILES["file"]["tmp_name"] .
                "INTO TABLE students" .
                "FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'" .
                "LINES TERMINATED BY '\n'" .
                "(student_first_name,student_last_name,student_number,cohort,semester)";
            $this->Database_connection->query_Database($query);
            
            return $return_string;
        }
        return "";
    }
    public function file_Export() {
        
    }
}


