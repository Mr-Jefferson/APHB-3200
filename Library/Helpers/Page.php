<?php
include_once "/var/www/html/APHB-3200/Library/Helpers/Table_Generation.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/CSV_Handler.php";
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";

class Page {

    protected $page_name;
    protected $Database_connection;
    protected $Table_generator;
    protected $CSV_handler;
    protected $current_cohort;
    protected $mysql_result_holder;
    protected $Master_String;   // all functions will concationate to the end of this string. once all calls have been made, will return the master string to the PHP page

    // calling it at which point it will be echo'ed to the browser

    public function __construct($page_title) {
        $this->page_name = $page_title;       
        $this->Database_connection = new Database_Connection();
        $this->current_cohort = $this->get_current_cohort();
        $this->Table_generator = new Table_Generation($this->current_cohort);
        
        if(isset($_GET['Mark_ID'])){
            $result = $this->Database_connection->query_Database("select * from marks where id_mark =".$_GET['Mark_ID']);
            if($result!=false){
                $this->mysql_result_holder = $result->fetch_assoc();
            }
        }
        if(isset($_GET['S_ID'])){
            $result = $this->Database_connection->query_Database("select * from students where id_student =".$_GET['S_ID']);
            if($result!=false){
                $this->mysql_result_holder = $result->fetch_assoc();
            }
        }
        if(isset($_GET['M_ID'])){
            $result = $this->Database_connection->query_Database("select * from markers where id_marker =".$_GET['M_ID']);
            if($result!=false){
                $this->mysql_result_holder = $result->fetch_assoc();
            }
        }
        
                    
    }
   
    public function load_update_button($type){
        $this->Master_String.= "<div id=\"update_individual_button\">";
                    if($type == "student"){
            $this->Master_String.=  "<button onclick=\"display('update_student')\">Update Student </button>";
                    }
                    if($type == "marker"){
            $this->Master_String.=  "<button onclick=\"display('update_marker')\"> Update Marker</button>";            
                    }
        $this->Master_String.= "</div>";
    }
    
    private function get_current_cohort(){
        $query = "select cohort,semester from users";
        $result = $this->Database_connection->query_Database($query);
        if($result!=false){
            return $result->fetch_assoc();
        }
    }
    
    /**
     * Will append to the Master_String the usual <header></header> contents
     */
    public function load_html_header() {
        $this->Master_String .=
                "<html>" .
                "<head>
                            <title>" . $this->page_name . "</title>" .
                "<link rel=\"stylesheet\" type=\"text/css\" href=\"/APHB-3200/Resources/StyleSheet/Project_StyleSheet.css\">" .
                "<script type=\"text/javascript\" src=\"/APHB-3200/Resources/JavaScript/utilities.js\"></script>" .
                "</head>";
    }

    
     private function populate_cohort_year_dropdown(){
         $return_string = "";
         $result = $this->Database_connection->query_Database("select distinct cohort from students order by cohort ASC");
         if($result != false){
             while($row = $result->fetch_assoc()){
                 if($this->current_cohort['cohort'] == $row['cohort']){
                     $return_string .= "<option selected = selected value=".$row['cohort'].">".$row['cohort'] . "</option>";
                 }
                 else{
                     $return_string .= "<option value=".$row['cohort'].">".$row['cohort'] . "</option>";
                 }                 
             }             
         }         
         return $return_string;            
     }
     
   private function populate_cohort_semester_dropdown(){
        $return_string = "";
            for($i = 1; $i<=2; $i++){
                 if($this->current_cohort['semester'] == $i){
                     $return_string .= "<option selected = selected value=".$i.">".$i."</option>";
                 }
                 else{
                     $return_string .= "<option value=".$i.">".$i. "</option>";
                 }
            }         
         return $return_string; 
   }
   
   public function set_url(){
       $_SESSION['url'] = $_SERVER['REQUEST_URI'];
   }
   
   public function set_error_url(){
       $_SESSION['ERROR_URL'] = $_SERVER['REQUEST_URI'];
   }
    /**
     * 
     * @param int $Page_type, Identifies what the shadow will be used for 
     * if $Page_type == 1 then it is indented to be used on the marker_home page.
     * if $Page_type == 2 then it is indented to be used for the Student_home.page
     */
    public function load_shadow($required_shadows) {
        if(isset($_SESSION['ERROR'])){
            $this->Master_String .=
                "<div id=\"hidden_form\" >
                    <div id=\"shadow\" style=\"display:block;z-index:7\" onclick = \"Hide()\"> </div>";
        }
        else{
            $this->Master_String .=
                "<div id=\"hidden_form\">
                    <div id=\"shadow\" onclick = \"Hide()\"> </div>";
        }
        
        
        if(in_array("cohort_select", $required_shadows)){
            $this->Master_String .=
                        "<div id =\"shadow_cohort_select\">
                            <h2>Select Cohort</h2>
                            <form method=\"post\" action=\"../Helpers/Updater.php?update=1\">
                                <div id =\"select_cohort\">
                                    Year: <select name =\"year\">";
                    $this->Master_String .= $this->populate_cohort_year_dropdown();                        
                    $this->Master_String .=  "</select> 
                                   Semester: <select name =\"sem\">";
                    $this->Master_String .= $this->populate_cohort_semester_dropdown();                           
                    $this->Master_String .=  "</select>           
                                </div>
                                <input type=\"submit\" value=\"Update\"></input>
                            </form>
                        </div>";
        }
        if(in_array("add_student", $required_shadows)){
            $this->Master_String .=
                    "<div class=\"shadow\" id=\"shadow_add_student\">
                            <h2>Add Student</h2>
                            <form action=\"../Helpers/Updater.php?insert=1\" method=\"post\">
                                <div id =\"add_student\">
                                    <div id=\"SID\">
                                        Student Number: <input type=\"text\" name = \"S_SD\">
                                    </div>
                                    <div id=\"first_name\">
                                        First Name: <input type=\"text\" name = \"S_FN\">
                                    </div>
                                    <div id=\"last_name\">
                                        Last Name: <input type=\"text\" name =\"S_LN\">
                                    </div>
                                    <input type=\"submit\" value=\"create\">
                                </div>
                            </form>
                    </div>";
        }
        if(in_array("add_marker", $required_shadows)){
            $this->Master_String .=
                    "<div class=\"shadow\" id=\"shadow_add_marker\">
                            <h2>Add Marker</h2>
                            <form action=\"../Helpers/Updater.php?insert=1\" method=\"post\">
                                <div id= \"add_marker\">
                                    <div id= \"first_name\">
                                        First name:  <input type =\"text\" name= \"M_FN\"></input>
                                    </div>
                                    <div id =\"last_name\">
                                        Last name:  <input type =\"text\" name=\"M_LN\"></input>
                                    </div>
                                    <input type=\"submit\" value=\"create\"></input>
                                </div>
                            </form>
                    </div>";
        }
        if(in_array("import", $required_shadows)){     
            $this->Master_String .=
                        "<div class=\"shadow\" id = \"shadow_import\">
                            <h2>Import Data</h2><br>
                            <div id = \"radio_buttons\">
                                Import markers:
                                <form action=\"../Pages/Student.php?import=markers\" method=\"post\" enctype=\"multipart/form-data\">
                                    <input type=\"file\" name=\"file\" id=\"file\">
                                    <input type=\"submit\" name=\"submit\" value=\"submit\">
                                </form>
                                Import students:
                                <form action=\"../Pages/Student.php?import=students\" method=\"post\" enctype=\"multipart/form-data\">
                                    <input type=\"file\" name=\"file\" id=\"file\">
                                    <input type=\"submit\" name=\"submit\" value=\"submit\">
                                </form>
                                Import marks:
                                <form action=\"../Pages/Student.php?import=marks\" method=\"post\" enctype=\"multipart/form-data\">
                                    <input type=\"file\" name=\"file\" id=\"file\">
                                    <input type=\"submit\" name=\"submit\" value=\"submit\">
                                </form>
                            </div>
                        </div>";
        }           
        if(in_array("update_marker", $required_shadows)){     
            $this->Master_String .=
                        "<div id=\"shadow_update_marker\">
                            <h2>Update Markers</h2>";
                            if(isset($_GET['M_ID'])){
                            $this->Master_String .=    
                            "<form action=\"../Helpers/Updater.php?M_ID=".$_GET['M_ID']."&update=1\" method=\"post\">
                                    <div id= \"add_marker\">
                                        <div id= \"first_name\">
                                            First name:  <input type =\"text\" name= \"M_FN\" value=\"".$this->mysql_result_holder['marker_first_name'] ."\"></input>
                                        </div>
                                        <div id =\"last_name\">
                                            Last name:  <input type =\"text\" name=\"M_LN\" value=\"".$this->mysql_result_holder['marker_last_name'] ."\"></input>
                                        </div>
                                        <div id=\"delete_button\">
                                            <a href=\"../Helpers/Updater.php?M_ID=".$_GET['M_ID'] ."&delete=1". "\">Delete</a>
                                        </div>
                                        <input type=\"submit\" value=\"Update\"></input>
                                    </div>
                            </form>";
                            }
                 $this->Master_String .=             
                        "</div>";
        }
        if(in_array("update_student", $required_shadows)){  
            $this->Master_String .=
                        "<div id=\"shadow_update_student\">
                            <h2>Update Student</h2>";
                    
                    if(isset($_GET['S_ID'])){
                        $this->Master_String .= 
                            "<form action=\"../Helpers/Updater.php?S_ID=".$_GET['S_ID'] ."&update=1 \" method=\"post\">
                                <div id =\"add_student\">
                                    <div id=\"SID\">
                                        Student Number: <input type=\"text\" name = \"S_SD\" value=".$this->mysql_result_holder['student_number'] .">
                                    </div>
                                    <div id=\"first_name\">
                                        First Name: <input type=\"text\" name = \"S_FN\" value=\"".$this->mysql_result_holder['student_first_name'] ."\">
                                    </div>
                                    <div id=\"last_name\">
                                        Last Name: <input type=\"text\" name =\"S_LN\" value=\"".$this->mysql_result_holder['student_last_name'] ."\">
                                    </div>
                                
                                <div id =\"select_cohort\">
                                <h4>Cohort:</h4>
                                    Year: <select name =\"year\">";
                    $this->Master_String .= $this->populate_cohort_year_dropdown($this->mysql_result_holder['cohort']);                        
                $this->Master_String .=  "</select> 
                                   Semester: <select name =\"sem\">";
                    $this->Master_String .= $this->populate_cohort_semester_dropdown($this->mysql_result_holder['semester']);                           
                $this->Master_String .=  "</select>           
                                </div>
                                    <div id=\"delete_button\">
                                                <a href=\"../Helpers/Updater.php?S_ID=".$_GET['S_ID'] ."&delete=1". "\">Delete</a>".
                                            "</div>
                                    <input type=\"submit\" value=\"Update\">
                                </div>
                            </form>";
                    } 
                $this->Master_String .= 
                       "</div>";
        }
        
        if(in_array("error",$required_shadows)){
            if(isset($_SESSION['ERROR'])){
            $this->Master_String .= 
                    "<div id=\"shadow_error\">".
                        "<h2> Error Report: </h2>".
            
                        "<div id=\"error_report\">".
                                $_SESSION['ERROR'].
                        "</div>".        
                    "</div>";
                        unset($_SESSION['ERROR']);
            }
        }
        $this->Master_String .=                   
                    "</div>";
                
    }
    public function close_shadow(){
        $this->Master_String .=                   
                    "</div>";
    }
    /**
     * description: appends the closing </html> tag to the master string
     */
    public function close_html() {
        $this->Master_String .= "</html>";
    }

    /**
     * Load_login_page():
     * Description: Since the login page is a unique page, it's creation has been placed 
     * in a single function. Appends to the Master_String the appropriate html tags to 
     * generate the login page.
     */
    public function load_login_page() {
        $this->Master_String .=
                "<div id=\"Login_outer_wrapper\">" .
                    "<div id=\"Login_inner_wrapper\">" .
                            "<h3 id=\"User_name_title\">Username:</h3>" .
                        "<form method=\"post\" action=\"#\">" .
                                "<input type=\"text\" id = \"username_form_input\" name =\"username\"></input>" .
                            "<h3 id=\"password_title\">Password:</h3>" .
                                "<input type=\"password\" id =\"password_form_input\" name =\"password\"></input>" .
                            "<input type=\"submit\" id=\"user_login_submit\" value=\"Login\"></input>" .
                        "</form>".
                    "</div>" .
                "</div>";

        /**
         * Load_main_body_wrapper():
         * Description: Append the appropriate div tag associated to the main content wrapper
         */
    }

    public function load_main_body_wrapper() {
        $this->Master_String .= "<div id=\"Main_content_wrapper\">";
        $this->CSV_handler = new CSV_Handler($this->current_cohort);
        $this->Master_String .= $this->CSV_handler->file_manager();
    }

    /**
     * load_page_title($name):
     * @param String $name
     * Description: Appends a <title></title> tag to the master string to produce the page title
     */
    public function load_page_title($name) {
        $this->Master_String .= "<h3 id=\"page_title\">" . $name . "</h3>";
    }

    public function load_page_title_name($type, $ID) {
        $query = "";
        if ($type == 1) {
            $query .= "select concat(marker_first_name, ' ', marker_last_name) as name from markers where id_marker = " . $ID;
        }
        if ($type == 2) {
            $query .= "select concat(student_first_name, ' ', student_last_name) as name from students where id_student =" . $ID;
        }
        $queryResult = $this->Database_connection->query_Database($query);
        if ($queryResult != false) {
            $row = $queryResult->fetch_assoc();
            $this->Master_String .= "<h3 id=\"page_title\">";
            if ($type == 1) {
                $this->Master_String .= "Marker";
            }
            if ($type == 2) {
                $this->Master_String .= "Student";
            }
            $this->Master_String .= " Name: " . $row['name'] . "</h3>";
        }
    }

    /**
     * Description: the partner function of load main body wrapper. Closes the tag with the appropriate html tag
     */
    public function close_main_body_wrapper() {
        $this->Master_String .= "</div>";
    }

    /**
     * load_table_body($table_type):
     * @param String $table_type
     * Description: Used by both the student/marker pages to display the tables of students/markers.
     * Based on the String passed, the function will append the appropriate html tags/elements to produce
     * the tables. 
     */
    public function load_table_body($table_type) {

        if ($table_type == "Students_home") {
            $this->Master_String .= $this->Table_generator->generate_Student_Overall();
            $this->Master_String .= $this->Table_generator->generate_Student_Overall_Stats();
        }
        if ($table_type == "Marker_home") {
            $this->Master_String .= $this->Table_generator->generate_Marker_Overall(1);
            $this->Master_String .= $this->Table_generator->generate_Marker_Overall(2);
        }
    }

    public function load_student_tables($Student_ID) {
        $this->Master_String .= $this->Table_generator->generate_Student_Individual($Student_ID);
        $this->Master_String .= $this->Table_generator->generate_Student_Individual_Marks(1, $Student_ID);
        $this->Master_String .= $this->Table_generator->generate_Student_Individual_Marks(2, $Student_ID);
    }

    public function load_marker_tables($Marker_ID) {
        // need a way to determine marker_ID/validate it.
        $this->Master_String .= $this->Table_generator->generate_Marker_Individual($Marker_ID);
        $this->Master_String .= $this->Table_generator->generate_Marker_Individual_Marks(1, $Marker_ID);
        $this->Master_String .= $this->Table_generator->generate_Marker_Individual_Marks(2, $Marker_ID);
    }

    /**
     * This function appends to the master_string the required html code to produce the global navigation bar which is located in the center, top half of the screen.
     * Its the navigation bar with "Seminar,Student,Markers,Logout" nav-options
     */
    public function load_global_navigation_bar() {
        $this->Master_String .=
                "<div id = \"nav\">
                        <ul>
                            <li id =\"left_nav\"><a href=\"/APHB-3200/Library/Pages/Student.php\">Students</a></li>" .
                            

                            "<li id =\"middle_nav\"><a href=\"/APHB-3200/Library/Pages/Marker.php\">Markers</a></li>".
                            "<li id =\"middle_nav\" style = \"border-right:2px solid black\" onclick=\"display('cohort_select')\">Set Cohort</li>".
                            "<li id =\"data_import_menu\" ><a href=\"/APHB-3200/Library/Pages/dEntry.php\">Data Management</a>".
                            
                                "<ul>".
                                    "<li onclick=\"display('import')\">Import</li>".
                                    "<li><a href=\"/APHB-3200/Library/Pages/Student.php?export=marks\">Export</a></li>".
                                "</ul></li>".
                            "<li id = \"nav_bar_log_out\" style = \"border-left:2px solid black\"><a href=\"Login.php?logOut=1\">Log Out</a></li>".
                            
                        "</ul>". 
                "</div>";
        

    }

    /**
     * not a necessary function but is used to make the page more readable. its only purpose is to append to the end of the string a <div id = "#"> tag
     */
    public function load_body_wrapper() {
        $this->Master_String .= "<body onload=\"adjust_shadow_height_width()\">";
    }

    private function compare_ID($id1,$id2){
        if($id1 == $id2){
            return "selected=selected";
        }
        else{
            return "";
        }
    }
    
    private function return_marker_option($row,$identifier){
        $selected =" ";
        if($identifier == "Mark_ID"){
            $selected = $this->compare_ID($row['id_marker'], $this->mysql_result_holder['id_marker']);
        }
        if($identifier == "M_ID"){      
            $selected = $this->compare_ID($_GET['M_ID'], $row['id_marker']); 
        }
        if($identifier == "S_ID"){
            $selected = " ";
        }  
        $value = $row['id_marker'];
        $name = $row['marker_first_name']. " " . $row['marker_last_name'];
        return "<option ".$selected." value=".$value.">".$name."</option>";
    }
    
    private function return_student_option($row,$identifier){
        $selected =" ";
        if($identifier == "Mark_ID"){
            $selected = $this->compare_ID($row['id_student'], $this->mysql_result_holder['id_student']);
        }
        if($identifier == "S_ID"){      
            $selected = $this->compare_ID($_GET['S_ID'], $row['id_student']); 
        }   
        $value = $row['id_student'];
        $name = $row['student_first_name']." ".$row['student_last_name']."(".$row['student_number'].")";
        return "<option ".$selected." value=".$value.">". $name."</option>";
    }
    
    private function populate_student_d_entry(){
        $return_string = "";
        $query = "select student_first_name,student_last_name,student_number,id_student from students where cohort=".$this->current_cohort['cohort']." and semester=".$this->current_cohort['semester'];
        $result = $this->Database_connection->query_Database($query);
        if($result !=false){
            while($row = $result->fetch_assoc()){
               if(isset($_GET['S_ID'])){
                    $return_string .= $this->return_student_option($row, "S_ID");
               }
               if(isset($_GET['Mark_ID'])){
                   $return_string .= $this->return_student_option($row, "Mark_ID");
               }
               if(!isset($_GET['Mark_ID']) &&!isset($_GET['S_ID'])){
                   $return_string .= "<option value=".$row['id_student'].">".$row['student_first_name']." ".$row['student_last_name']."(".$row['student_number'].")"."</option>";
               }
            }            
        }
        return $return_string;
    }
    
    private function populate_marker_d_entry(){
        $return_string = "";
        $query = "select marker_first_name,marker_last_name,id_marker from markers";
        $result = $this->Database_connection->query_Database($query);
        if($result!=false){
            while($row = $result->fetch_assoc()){
                if(isset($_GET['Mark_ID'])){
                    $return_string .= $this->return_marker_option($row,"Mark_ID");
                }
                if(isset($_GET['M_ID'])){
                    $return_string .= $this->return_marker_option($row,"M_ID");
                }
                if(isset($_GET['S_ID'])){
                    $return_string .= $this->return_marker_option($row,"S_ID");
                }
                if(!isset($_GET['Mark_ID']) &&! isset($_GET['M_ID'])&&!isset($_GET['S_ID'])){
                    $return_string .= "<option value=".$row['id_marker']."> ".$row['marker_first_name']. " " . $row['marker_last_name']."</option>"; 
                }
                
                
                    
                
            }
        }
        return $return_string;
    }

    
    /**
     * Load_data_entry_page():
     * Description: Similar to the Login page, the data entry page is a unique page and as such its 
     * generating code is only located in one function. Contains all relevant html tags/elements 
     * to produce the Data entry page.
     */
    public function load_data_entry_page() {
        $this->Master_String.= 
                "<div id=\"data_entry_wrapper\" >";
        if(isset($_GET['Mark_ID'])){
            $this->Master_String.= "<form method=\"post\" action=\"../Helpers/Updater.php?update=1&Mark_ID=".$_GET['Mark_ID']. "\">";
        }
        
        if(isset($_GET['S_ID'])){
            $this->Master_String.= "<form method=\"post\" action=\"../Helpers/Updater.php?insert=1&S_ID=".$_GET['S_ID']. "\">";
        }
        else{
            $this->Master_String.= "<form method=\"post\" action=\"../Helpers/Updater.php?insert=1\">";
        }
        $this->Master_String.=             
                        "<div id =\"student_entry\">" .
                            "<h4>Student:</h4>" .
                            "<div id=\"Cohort_year_sem\">" .
                                "Cohort: <div id=\"cohort_text\"> Year: ".$this->current_cohort['cohort']." Semester: ".$this->current_cohort['semester'] ."</div>".
                            "</div>" .
                            "<div id=\"Student_name\">" .
                                "Student Number: ".
                                "<select name=\"marks_student\">";
        
            $this->Master_String.= $this->populate_student_d_entry();
        
                
        $this->Master_String.=  "</select>" .
                            "</div>" .
                            //"<button>add</button>" .
                        "</div>" .
                        "<div id=\"marker_entry\">" .
                            "<h4>Marker:</h4>" .
                            "<div id=\"marker_name\">" .
                                "Marker Name: ".
                                "<Select name =\"marks_marker\">";
                $this->Master_String.= $this->populate_marker_d_entry();
        $this->Master_String.=  "<select>" .
                            "</div>" .
                            //"<button>add</button>" .
                        "</div>" .
                        "<div id =\"mark_entry\">" .
                            "<h4>Marks:</h4>" .
                            "<div id=\"seminar_type\">".
                                "Seminar Type: ".
                                "<select name=\"marks_sem_type\">";
                            if(isset($_GET['Mark_ID']) || isset($_GET['S_ID']) || isset($_GET['M_ID'])){
                                if(isset($_GET['seminar'])){//($this->mysql_result_holder['seminar'] == 1) || 
                                    if(( $_GET['seminar'] == 1)){
                                        $this->Master_String.="<option selected=selected value=1>Proposal</option> <option value=2>Final</option>";
                                    }
                                    else{
                                        $this->Master_String.="<option value=1>Proposal</option><option selected=selected value=2>Final</option>";
                                    }
                                }
                                else{
                                    if($this->mysql_result_holder['seminar'] == 1){
                                        $this->Master_String.="<option selected=selected value=1>Proposal</option> <option value=2>Final</option>";
                                    }
                                    else{
                                        $this->Master_String.="<option value=1>Proposal</option><option selected=selected value=2>Final</option>";
                                    }
                                }
                            }
                            else{
                                $this->Master_String.="<option value = 1>Proposal</option> <option value = 2>Final</option>";
                                
                            }
                                
        $this->Master_String.=  "</select>" .
                            "</div>";
        
                        if(isset($_GET['Mark_ID'])){
        $this->Master_String.=
                            "<div id=\"mark1\">" .
                                "Quality of Oral Delivery: <input type=\"text\" name =\"mark_1\" value=\"". $this->mysql_result_holder['mark_1']. "\"></input><br>" .
                            "</div>" .
                            "<div id=\"mark2\">" .
                                "Quality of Slides:  <input type=\"text\" name =\"mark_2\"  value=\"". $this->mysql_result_holder['mark_2']. "\"></input><br>" .
                            "</div>" .
                            "<div id=\"mark3\">" .
                                "Content: <input type=\"text\" name =\"mark_3\" value=\"". $this->mysql_result_holder['mark_3']. "\"></input><br>" .
                            "</div>";
                        }
                        else{
        $this->Master_String.=    
                            "<div id=\"mark1\">" .
                                "Quality of Oral Delivery: <input type=\"text\" name =\"mark_1\"></input><br>" .
                            "</div>" .
                            "<div id=\"mark2\">" .
                                "Quality of Slides:  <input type=\"text\" name =\"mark_2\" ></input><br>" .
                            "</div>" .
                            "<div id=\"mark3\">" .
                                "Content: <input type=\"text\" name =\"mark_3\"></input><br>" .
                            "</div>";
                        }
        $this->Master_String.=                    
                        "</div>";
                
                if(isset($_GET['Mark_ID'])){
                    $this->Master_String.=  "<div id=\"delete_button\">".
                                                "<a href=\"../Helpers/Updater.php?Mark_ID=".$_GET['Mark_ID'] ."&delete=1". "\">Delete</a>".
                                            "</div>";
                    $this->Master_String.= "<input type=\"submit\" value=\"Update\">";
                }
                else{
                    $this->Master_String.= "<input type=\"submit\" value=\"Add Marks\">";
                }
                $this->Master_String.=
                    "</form>" .
                "</div>";
    }

    /**
     * The partner method for load_body_wrapper, its only purpose is to append a </div> tag to the master string.
     */
    public function close_body_wrapper() {
        $this->Master_String .= "</body>";
    }

    /**
     * The navigation bar inside the Seminars tab on the home page requires an additional navigation bar which is tailored to the need of searching for a 
     * set of unique seminars. Ie search for all seminars in the winthrop hall... or look for all seminars on an exact date.
     */
    public function load_table_nav_bar($table_type) {
        if ($table_type == "Students_home") {
            $this->Master_String.= "<div id=\"table_nav_wrapper\">" . $this->generate_student_home_navigation_bar() . "</div>";
        }
        
        if ($table_type == "Marker_home") {
            $this->Master_String.= "<div id=\"table_nav_wrapper\">" . $this->generate_marker_home_navigation_bar() . "</div>";
        }
    }

    /**
     * Description: a function paired to the load_table_nav_bar. based on the table type supplied,
     * the parent function will make the appropriate call. Function is designed to append to the 
     * Master String the appropriate html tag/elements to produce the sub table navigation bar.
     * @return String
     */
    private function generate_marker_home_navigation_bar() {
        return
                
                "<div id=\"Cohort_Search\">" .
                    "  Cohort: " . $this->current_cohort['cohort']. " Semester ".$this->current_cohort['semester'].
                "</div>".
                "<button onclick=\"display('add_marker')\">Add Marker</button>";
    }

    /**
     * Description: a function paired to the load_table_nav_bar. based on the table type supplied,
     * the parent function will make the appropriate call. Function is designed to append to the 
     * Master String the appropriate html tag/elements to produce the sub table navigation bar.
     * @return String
     */
    private function generate_student_home_navigation_bar() {
        return

                
                "<div id=\"Student_Search\">" .
                
                "  Cohort: " . $this->current_cohort['cohort']. " Semester ".$this->current_cohort['semester'].
                "</div>" .
                "<button onclick=\"display('add_student')\">Add Student</button>";
    }

    /**
     * After all functions have been called and all strings appended to the master_String, the master string is called and returned to the caller to be echoed out to the browser 
     * @return type
     */
    public function return_Master_String() {
        return $this->Master_String;
    }

}
