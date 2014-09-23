<?php
include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";

Class User_Control{
    
    protected $DB_connection;
    /**
     *  Username/Password paramaters will come from html forms via the  post method
     * @param string $username  
     * @param string $password
     */
    public function __construct(){
        $this->DB_connection = new Database_Connection();
    }
    
    /**
     * Method/function name: validate_User()
     * Description: a User_Control method which is intented to query the database and determine if the given password for said user is current.
     * @return boolean
     */
    public function validate_User($user,$password){
        $Query_result = $this->DB_connection->query_Database("select * from Users where username =\"".$user."\"");
        if($Query_result == false){
            return false;   // there wasn't any username in the DB with the username the current user provided 
        }
        else{
            $User_row = $Query_result->fetch_assoc();
            if($User_row['password'] === $password){
                return true;
            }
            else{
                return false;
            }
        }
        return false;
    }
    
    /**
     * Method/function name: generate_Session()
     * Description: Upon confirmation that the username/password provided by the user is valid, the session must initialize $_SESSION['user_ID']
     */
    public function generate_Session($user){
        session_start();
        $_SESSION['username'] = $user;
    }
    /**
     * Method/function name: is_Session_Active()
     * Description:  When ever a php file is loaded, must ensure that A. the session_start() is present and that B. The session varaible "user_ID" is set, if not then it assumes that the user has logged out and will redirect to
     * the login page
     * @return boolean Returns true if the session is active and the key: "user_ID" is set, false otherwise
     */
    public function is_Session_Active(){
        if(isset($_SESSION['username'])){
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
     * Method/function name: destroy_Session()
     * Description: Upon user logging out, destroy_Session is called to destroy the session which in turn returns the user to the login page
     */
    public function destroy_Session(){
        
    }
    
}

