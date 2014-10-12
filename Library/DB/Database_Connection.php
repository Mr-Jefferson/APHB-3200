<?php

class Database_Connection {

    protected $database_object;

    /**
     * Method/function name: __construct
     * Description: Simply initializes the $database_object by creating a mysqli object
     * 
     * The mysqli() paramaters will be hard coded into the class as it removes the need to constantly restate the same parameters 
     */
    public function __construct() {
        $this->database_object = new mysqli("128.199.218.6", "sqluser", "D34thByWater", "seminar_marks");
        //$this->database_object = new mysqli("localhost", "root", "", "seminar_marks");
        //$host, $user, $password, $database, $port, $socket
    }

    /**
     * Method/function name: query_Database
     * Description: Passing a query string to the mysqli_object to allow a query to be made to the database
     * 
     * @param String $query_string
     * @return mysql_result object or if an object couldn't be created, false is returned
     */
    public function query_Database($query){
        return $this->database_object->query($query);
    }
    
    
    public function Prepared_query_Database($query, $parameters, $types) {
        $prepared_statement = $this->database_object->prepare($query);
        if(count($parameters) == count($types)){
            for($i = 0; $i < count($parameters); $i++){
                $prepared_statement->bind_param($types[$i], $parameters[$i]);
            }
            $prepared_statement->execute();
        }
        else{
            return false;
        }
        
        
            
        
    }
    
    public function return_new_id($type){
        if($type == "student"){
            $new_ID_query = $this->query_Database("select max(id_student) as ID from students");
        }
        if($type=="marker"){
            $new_ID_query = $this->query_Database("select max(id_marker) as ID from markers");
        }
        if($type=="marks"){
            $new_ID_query = $this->query_Database("select max(id_mark) as ID from marks");
        }
        
        if($new_ID_query == false){
            $new_id = 1;
        }
        else{
            $outcome = $new_ID_query->fetch_assoc();
            return $outcome['ID'] + 1;
        }
    }

}
