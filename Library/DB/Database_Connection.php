<?php

class Database_Connection{
    
    protected $database_object;
    
    /**
     * Method/function name: __construct
     * Description: Simply initializes the $database_object by creating a mysqli object
     * 
     * The mysqli() paramaters will be hard coded into the class as it removes the need to constantly restate the same parameters 
        */
    public function __construct() {
        $this->database_object = new mysqli("128.199.218.6", "myuser" ,"D34thByWater" , "seminarmarks");
        //$host, $user, $password, $database, $port, $socket
    }
    
    /**
     * Method/function name: query_Database
     * Description: Passing a query string to the mysqli_object to allow a query to be made to the database
     * 
     * @param String $query_string
     * @return mysql_result object or if an object couldn't be created, false is returned
     */
    public function query_Database($query_string){
        return $this->database_object->query($query_string);
    }
}

