<?php

include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";

Class error_handler{
    /**
     *
     * @var string
     */
    protected $error_string;    
    /**
     *
     * @var Database_Connection object
     */
    protected $database_connection; 
    
    /**
     *  Method: Initializes the object variables 
     */
    public function __construct() {
        $this->error_string = "";
        $this->database_connection = new Database_Connection();
    }
    
    /**
     *  Method: Looks at the marker table and checks if the supplied paramaters already exist in the table.
     * @param string $firstname
     * @param string $lastname
     * @return boolean
     */
    public function check_marker_name_exists( $firstname,  $lastname){
        $query = "select * from markers where marker_first_name=\"".$firstname."\" and marker_last_name =\"".$lastname."\"";
        $result = $this->database_connection->query_Database($query);
        if($result == false){ return false;}
        else{return true; }
    }
    
    /**
     * Method: runs the supplied name through a regular expression to check for illegal characters or numerical values
     * @param string $name
     * @return boolean
     */
    private function check_name( $name){
        if(!preg_match("/[^a-zA-Z]/",$name)){return false;}
        else{return true;}
    }
    
    /**
     * 
     * @param int $studentNumber
     * @param string $studentFirstName
     * @param string $studentLastName
     * @param int $cohort
     * @param int $semester
     * @param int $id_student
     * @return boolean
     */
    public function update_student_check( $studentNumber, $studentFirstName,  $studentLastName, $cohort, $semester, $studentID){
        $boolean_flag = true;
        if($this->check_name($studentFirstName) == false){
          $this->error_string .= "Invalid first name <br>";
          $boolean_flag = false;
        }
        if($this->check_name($studentLastName) == false){
            $this->error_string .= "Invalid last name <br>";
            $boolean_flag = false;
        }
        if(preg_match("/^[0-9]*$/", $studentNumber) == false){
            $this->error_string .= "Invalid student number <br>";
            $boolean_flag = false;
        }
         if($this->search_cohort_SN($studentNumber, $cohort, $semester, $studentID)==false){
             $boolean_flag = false; 
         }     
        return $boolean_flag;
    }
    
    /**
     * Method: Given the following parameters, searches all students within a given cohort and checks to see if a student number matches $studentNumber. 
     *               if so then it is assumed that the student is already apart of the cohort.
     * @param int $studentNumber
     * @param int $cohort
     * @param int $semester
     * @param int $id_student
     * @return boolean
     */
    private function search_cohort_SN( $studentNumber, $cohort, $semester, $id_student){
        $query = "select * from students where student_number=".$studentNumber." and cohort=".$cohort." and semester=".$semester;
        echo $query;
        $result = $this->database_connection->query_Database($query);
            if($result->num_rows !== 0){
                $row = $result->fetch_assoc();
                if($row['id_student'] != $id_student ){
                   $this->error_string .= "Student Number already exists for the cohort. <br>";  
                   return false; 
                }
                else{return true;} 
            }
        return true;
    }
   
    /**
     * 
     * @param int $studentNumber
     * @param string $studentFirstName
     * @param string $studentLastName
     * @param int $cohort
     * @param int $semester
     * @return boolean
     */
    public function new_student_check( $studentNumber, $studentFirstName,  $studentLastName, $cohort, $semester){
        $boolean_flag = true;
        if(!preg_match("/^[0-9]*$/", $studentNumber))
            {$this->error_string .= "Entered an invalid value for Student Number. Please provide a valid integer.<br>"; 
            $boolean_flag = false;}
        if($this->search_cohort_SN($studentNumber, $cohort, $semester, -1)==false){$boolean_flag = false;}
        if($this->check_name($studentFirstName) == false)
          {$this->error_string .= "Invalid first name <br>";
          $boolean_flag = false;}
        if($this->check_name($studentLastName) == false)
        {$this->error_string .= "Invalid last name <br>";
            $boolean_flag = false; }
        return $boolean_flag;  
    }

    /**
     * @param array $marks
     * @return boolean
     */
    private function check_mark_values(array $marks){
        $boolean_flag = true;
        for($i = 0; $i < count(marks);$i++){
            if(!is_numeric($marks[$i])){
                $this->error_string .= "Invalid value for Mark $i, please provide an integer or float value <br>";
                $boolean_flag = false;
            }
        }
        return $boolean_flag;
    }
    /**
     * 
     * @param int $marker
     * @param int $student
     * @param int $seminarType
     * @param int $markID
     * @return boolean
     */
    private function is_already_associated( $marker,  $student, $seminarType, $markID){
            $query = "select * from marks where id_marker=".$marker." and id_student=".$student. " and seminar=".$seminarType . ";";
            $result = $this->database_connection->query_Database($query);
            if($result->num_rows != 0){
                $row = $result->fetch_assoc();
                if($row['id_mark'] != $markID){
                    $this->error_string .= "Association between marker, student have already been made in this cohort.<br>";
                    return true;
                }
            }
            else{return false;}
    }
    /**
     * Method: allows pages such as Updater.php the option to add to the error_string
     * @param type $string
     */
    public function add_to_error($string){
        $this->error_string .= $string;
    }
    /**
     * 
     * @param int $markID
     * @return boolean
     */
    private function is_valid_mark_ID( $markID){
        $query = "select * from marks where id_mark=".$markID;
        $result = $this->database_connection->query_Database($query);
        if($result->num_rows == 1){ return true;}
        else{return false;}
    }
    /**
     * 
     * @param array $marks
     * @param int $marker
     * @param int $student
     * @param int $seminarType
     * @param int $markID
     * @return boolean
     */
    public function validate_mark(array $marks, $marker,  $student, $seminarType,  $markID){
        $boolean_flag = true;
        if($this->check_mark_values($marks) == false){$boolean_flag = false;}
        if(isset($_GET['Mark_ID'])){
            if($this->is_valid_mark_ID($markID)){
               if($this->is_already_associated($marker, $student,$seminarType,$markID)==true){$boolean_flag = false;}
            }
            else{
                $this->error_string.= "Attempting to alter non existent mark, please provide valid mark identification<br>";
                $boolean_flag = false;
            }
        }
        else{ 
            if($this->is_already_associated($marker, $student,$seminarType,$markID) == true){
                $boolean_flag = false;     
            }
        }     
        return $boolean_flag;
    }
    /**
     * 
     * @param type $markerFirstName
     * @param type $markerLastName
     * @param type $markerID
     * @return boolean
     */
    public function new_marker_check($markerFirstName,$markerLastName,$markerID){
        $boolean_flag = true;
        if($this->check_name($markerFirstName) == false){
            $this->error_string .= "Invalid first name <br>";
            $boolean_flag = false;
        }
        if($this->check_name($markerLastName) == false){
            $this->error_string .= "Invalid last name <br>";
            $boolean_flag = false;
        }
        if($boolean_flag == true){  // passed the intial test
            $query = "select * from markers where marker_first_name=\"".$markerFirstName ."\" and marker_last_name=\"".$markerLastName ."\"";
            $result = $this->database_connection->query_Database($query);
            if($result->num_rows != 0){
                $row = $result->fetch_assoc();
                if($markerID !== $row['id_marker']){
                    $this->error_string.= "Marker already exists <br>";
                    $boolean_flag = false;
                }
            }
        }
        return $boolean_flag;
    }
    
    /**
     * 
     * @return type
     */
    public function return_error_string(){
        return $this->error_string;
    }
    
    
}
