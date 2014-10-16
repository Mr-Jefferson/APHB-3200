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
        require(dirname(__FILE__)."/config.php");
        $this->database_object = new mysqli($host, $user, $password, $database);
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
            $ref_param = array();
            $types_string = "";
            for($i = 0; $i < count($types); $i++) {
              $types_string .= $types[$i];
            }
            
            $ref_param[] = & $types_string;
            
            for($i = 0; $i<count($types); $i++){
                $ref_param[] = & $parameters[$i];
            }
            
            call_user_func_array(array($prepared_statement, 'bind_param'), $ref_param);
            $prepared_statement->execute();
            
            //return $prepared_statement->fetch_assoc();
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
