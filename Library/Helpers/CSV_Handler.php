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
        if(isset($_FILES["file"])){
            $return_string .= "<br>";
            move_uploaded_file($_FILES["file"]["tmp_name"],"C:\\xampp\\mysql\\data\\temp.csv");
            $fileName = str_replace("\\","\\\\",$_FILES["file"]["tmp_name"]);
            $return_string .= "Upload: " . $_FILES["file"]["name"] . "<br>";
            $return_string .= "Type: " . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION) . "<br>";
            
            $query = "LOAD DATA LOCAL INFILE " . 
                "\"C:\\\\xampp\\\\mysql\\\\data\\\\temp.csv\" " .
                "INTO TABLE students " .
                "FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' " .
                "LINES TERMINATED BY '\n' " .
                "(student_first_name,student_last_name,student_number,cohort,semester)";
            $this->Database_connection->query_Database($query);
            
            $return_string .= "If importing worked correctly, you should seem the values in the tables immediately.";
            return $return_string;
        }
    }
    public function file_Export() {
        
    }
}


