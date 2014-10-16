<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";

Class User_Control {

    protected $DB_connection;

    public function __construct() {
        $this->DB_connection = new Database_Connection();
    }

    /**
     * Method: Given a password/username fetched from the login form, checks to ensure the password is correct and if true then sets up the session variables
     * 
     * @param string $user
     * @param string $password
     * @return boolean
     */
    public function validate_User($user, $password) {
        $result = $this->DB_connection->Prepared_query_Database("select * from users where username=?", array($user), array("s"));
        
        $Query_result = $this->DB_connection->query_Database("select * from users where username =\"" . $user . "\"");
        if ($Query_result == false) {
            return false;   
        } else {
            $User_row = $Query_result->fetch_assoc();
            require(dirname(__FILE__)."/config.php");
            
            $hashedPassword = crypt($password, $hashString);
            echo $hashedPassword;
            
            if ($User_row['password'] === $hashedPassword) {
                $randomIntString = $this->generate_session_id(); 
                
                $_SESSION['session_hash'] =$randomIntString;
                $this->DB_connection->Prepared_query_Database("UPDATE users SET session_hash=?", array($randomIntString), array("s"));
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    
    /**
     * Method: if the validate_user function returns true, calls generate_session_id to generate a 15 character session key.
     * 
     * @return string
     */
    private function generate_session_id(){
        $randomIntString = "";
        for($i=0;$i<15;$i++){
            $randomIntString .= mt_rand(0, 9);
        }
        return $randomIntString;
    }
    
    /**
     * Method: destroy session and delete the sessionHash column in the users table
     */
    public function destroy_session(){
        if(isset($_SESSION['session_hash'])){
            $this->DB_connection->Prepared_query_Database("UPDATE users SET session_hash=?", array(""), array("s"));
            session_destroy();
            header('location:Login.php');
        }
    }

    /**
     * 
     * Method:  When ever a php file is loaded, must ensure that A. the session_start() is present and that B. The session varaible "user_ID" is set, if not then it assumes that the user has logged out and will redirect to
     * the login page
     * @return boolean Returns true if the session is active and the key: "user_ID" is set, false otherwise
     */
    public function is_Session_Active() {
        if (isset($_SESSION['session_hash'])) {
            $query = "select * from users where session_hash=\"".$_SESSION['session_hash']."\"";
            $result = $this->DB_connection->query_Database($query);
            if($result!=false){
                $row = $result->fetch_assoc();
                if($row['session_hash'] == $_SESSION['session_hash']){ return true;}
                else{ return false;}
            }
            else{return false;}
        } else {return false; }
    }
    

    /*
    public function set_Cohort(){
        $query = "select cohort,semester from students order by cohort desc, semester desc limit 1";
        $result = $this->DB_connection->query_Database($query);
        if($result != false){
            $row = $result->fetch_assoc();
            $update_query = "update users set cohort=".$row['cohort'].",semester=".$row['semester'];
            $this->DB_connection->query_Database($update_query);
        }
    }*/
}
