<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";

Class User_Control {

    protected $DB_connection;

    /**
     *  Username/Password paramaters will come from html forms via the  post method
     * @param string $username  
     * @param string $password
     */
    public function __construct() {
        $this->DB_connection = new Database_Connection();
    }

    /**
     * Method/function name: validate_User()
     * Description: a User_Control method which is intented to query the database and determine if the given password for said user is current.
     * @return boolean
     */
    public function validate_User($user, $password) {
        $Query_result = $this->DB_connection->query_Database("select * from users where username =\"" . $user . "\"");
        if ($Query_result == false) {
            return false;   
        } else {
            $User_row = $Query_result->fetch_assoc();
            
            $hashedPassword = crypt($password, '$1$CKgg8CRW$');
            if ($User_row['password'] === $hashedPassword) {
                $randomIntString = $this->generate_session_id(); 
                $_SESSION['sessionHash'] =$randomIntString;
                $this->DB_connection->Prepared_query_Database("UPDATE users SET sessionHash=?", array($randomIntString), array("s"));
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
    
    private function generate_session_id(){
        $randomIntString = "";
        for($i=0;$i<15;$i++){
            $randomIntString .= mt_rand(0, 9);
        }
        return $randomIntString;
    }

    /**
     * Method/function name: is_Session_Active()
     * Description:  When ever a php file is loaded, must ensure that A. the session_start() is present and that B. The session varaible "user_ID" is set, if not then it assumes that the user has logged out and will redirect to
     * the login page
     * @return boolean Returns true if the session is active and the key: "user_ID" is set, false otherwise
     */
    public function is_Session_Active() {
        if (isset($_SESSION['sessionHash'])) {
            $query = "select * from users where sessionHash=\"".$_SESSION['sessionHash']."\"";
            $result = $this->DB_connection->query_Database($query);
            if($result!=false){
                $row = $result->fetch_assoc();
                if($row['sessionHash'] == $_SESSION['sessionHash']){ return true;}
                else{ return false;}
            }
            else{return false;}
        } else {return false; }
    }
// come back too
    public function set_Cohort(){
        $query = "select cohort,semester from students order by cohort desc, semester desc limit 1";
        $result = $this->DB_connection->query_Database($query);
        if($result != false){
            $row = $result->fetch_assoc();
            $update_query = "update users set cohort=".$row['cohort'].",semester=".$row['semester'];
            $this->DB_connection->query_Database($update_query);
        }
    }
}
