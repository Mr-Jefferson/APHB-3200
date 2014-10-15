<?php

include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";

Class error_handler{
    
    protected $error_string;
    protected $database_connection; 
    
    public function __construct() {
        $this->error_string = "";
        $this->database_connection = new Database_Connection();
    }
    
    // checks the name from the $table table
    public function check_marker_name_exists($firstname, $lastname){
        $query = "select * from markers where marker_first_name=\"".$firstname."\" and marker_last_name =\"".$lastname."\"";
        $result = $this->database_connection->query_Database($query);
        if($result == false){
            return false;
        }
        else{
            return true;
        }
        
    }
    public function check_name($name){
        if(preg_match("/[0-9!@#$%^&*();\\/|<>\"\'_\-+=,.\s]/",$name)){
            return false;
        }
        else{
            return true;
        }
    }
    
    public function update_student_check($SN,$SFN,$SLN,$cohort,$semester){
        $boolean_flag = true;
        if($this->check_name($SFN) == false){
          $this->error_string .= "Invalid first name <br>";
          $boolean_flag = false;
        }
        if($this->check_name($SLN) == false){
            $this->error_string .= "Invalid last name <br>";
            $boolean_flag = false;
        }
        if(preg_match("/[a-zA-Z!@#$%^&*();\\/|<>\"\'_\-+=,.\s]/", $SN) == true){
            if($this->search_cohort_SN($SN, $cohort, $semester)){
                $boolean_flag = false;
            }
        }
        if(!$this->search_cohort_SN($SN,$cohort,$semester)){
            $boolean_flag = false;
        }
        
        return $boolean_flag;
    }
    
    public function search_cohort_SN($SN,$cohort,$semester){
        
        $query = "select * from students where student_number=".$SN." and cohort=".$cohort." and semester=".$semester;
        
        $result = $this->database_connection->query_Database($query);
        $row = $result->fetch_assoc();
            if($result != false && $row['student_number'] != $SN){
                $this->error_string .= "Student Number already exists for the cohort. <br>";  
                return false;
            }
        return true;
    }
    

    
    /*
     * SN = student number
     * Checks if student number already exists in the database for that cohort
     */
    public function new_student_check($SN,$SFN,$SLN,$cohort,$semester){
        $boolean_flag = true;
        
        if(preg_match("/[a-zA-Z!@#$%^&*();\\/|<>\"\'_\-+=,.\s]/", $SN) == false){
            if($this->search_cohort_SN($SN, $cohort, $semester)==false){
                $boolean_flag = false;
            }
        }
        else{    
            $this->error_string .= "Entered an invalid value for Student Number. Please provide a valid integer.<br>"; 
            $boolean_flag = false;
        }
        
        if($this->check_name($SFN) == false){
          $this->error_string .= "Invalid first name <br>";
          $boolean_flag = false;
        }
        if($this->check_name($SLN) == false){
            $this->error_string .= "Invalid last name <br>";
            $boolean_flag = false;
        }
        
        return $boolean_flag;
        
    }

    
    public function check_mark_values($M1,$M2,$M3){
        $boolean_flag = true;
        if(!is_numeric($M1)){
            $boolean_flag = false;
            echo "failed m1<br>";
            $this->error_string .= "Invalid value for Mark 1, please provide an integer or float value <br>";
        }
        if(!is_numeric($M2)){
            $boolean_flag = false;
            echo "failed m2<br>";
            $this->error_string .= "Invalid value for Mark 2, please provide an integer or float value <br>";
        }
        if(!is_numeric($M3)){
            $boolean_flag = false;
            echo "failed m3<br>";
            $this->error_string .= "Invalid value for Mark 3, please provide an integer or float value <br>";
        }
        
        return $boolean_flag;
    }
    
    public function is_already_associated($marker, $student,$type,$Mark_ID){
    
            $query = "select * from marks where id_marker=".$marker." and id_student=".$student. " and seminar=".$type . ";";
            echo $query . "<br>";
            $result = $this->database_connection->query_Database($query);
            $row = $result->fetch_assoc();
            if($result != false || $result->num_rows === 0){
                
                if($row['id_mark'] !== $Mark_ID){
                    $this->error_string .= "Association between marker, student have already been made in this cohort.<br>";
                    return true;
                }
            }
            else{
                return false;
            }
    }
    
    public function validate_mark($M1,$M2,$M3,$marker, $student,$sem_type, $Mark_ID){
        $boolean_flag = true;
        if(!$this->check_mark_values($M1, $M2, $M3)){
            $boolean_flag = false;
        }
        $query = "select * from marks where id_mark=".$Mark_ID;
        
        $result = $this->database_connection->query_Database($query);
        if($result != false){
            echo 2;
            if($this->is_already_associated($marker, $student,$sem_type,$Mark_ID)==true){
                $boolean_flag = false;
                echo 3;
            }
        }
        else{
            $this->error_string.= "Attempting to alter non existent mark, please provide valid mark identification<br>";
            $boolean_flag = false;
        }
        
        return $boolean_flag;
    }
    
    public function new_marker_check($MFN,$MLN,$M_ID){
        $boolean_flag = true;
        // intial test to check the form information
        if($this->check_name($MFN) == false){
            $this->error_string .= "Invalid first name <br>";
            $boolean_flag = false;
        }
        if($this->check_name($MLN) == false){
            $this->error_string .= "Invalid last name <br>";
            $boolean_flag = false;
        }
        
        if($boolean_flag == true){  // passed the intial test
            $query = "select * from markers where marker_first_name=\"".$MFN ."\" and marker_last_name=\"".$MLN ."\"";
            echo $query;
            $result = $this->database_connection->query_Database($query);
            if($result !=false ||$result->num_rows !== 0){
                $row = $result->fetch_assoc();
                if($M_ID !== $row['id_marker']){
                    $this->error_string.= "Marker already exists <br>";
                    $boolean_flag = false;
                }
            }
        }
        
        return $boolean_flag;
    }
    
    public function return_error_string(){
        return $this->error_string;
    }
    
    
}