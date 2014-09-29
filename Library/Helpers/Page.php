<?php
if(strpos(php_uname(),'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/Table_Generation.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
    
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/Table_Generation.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
}

class Page{
    
    protected $page_name;
    protected $Database_connection;
    protected $Table_generator;
    protected $Master_String;   // all functions will concationate to the end of this string. once all calls have been made, will return the master string to the PHP page
                                // calling it at which point it will be echo'ed to the browser
    
    public function __construct($page_title){
        $this->page_name = $page_title;
        $this->Table_generator = new Table_Generation();
        $this->Database_connection = new Database_Connection();
    }
    
    /**
     * Will append to the Master_String the usual <header></header> contents
     */
    public function load_html_header(){
        $this->Master_String .= 
                "<html>".
                
                    "<head>
                            <title>".$this->page_name."</title>".
                            "<link rel=\"stylesheet\" type=\"text/css\" href=\"/CITS3200_Group_H/Resources/StyleSheet/Project_StyleSheet.css\">".
                            "<script type=\"text/javascript\" src=\"/CITS3200_Group_H/Resources/JavaScript/shadow_Controls.js\"></script>".
                    "</head>";
    }
    
    /**
     * 
     * @param int $Page_type, Identifies what the shadow will be used for 
     * if $Page_type == 1 then it is indented to be used on the marker_home page.
     * if $Page_type == 2 then it is indented to be used for the Student_home.page
     */
    public function load_shadow($Page_type){
        $this->Master_String .=
                "<div id=\"hidden_form\">".
                "<div id=\"shadow\" onclick = \"Hide()\"> </div>".
                "<div id=\"add_wrapper\">";
                if($Page_type == 2){
                        
                            $this->Master_String .="<h2>Add Student</h2>
                            <form>
                                <div id =\"add_student\">
                                    <div id=\"SID\">
                                        Student Number: <input type=\"text\">
                                    </div>
                                    <div id=\"first_name\">
                                        First Name: <input type=\"text\">
                                    </div>
                                    <div id=\"last_name\">
                                        Last Name: <input type=\"text\">
                                    </div>
                                    <input type=\"submit\" value=\"create\">
                                </div>
                            </form>";
                        
                }
                if($Page_type == 1){
                        $this->Master_String .="<h2>Add Marker</h2>
                            <form>
                                <div id= \"add_marker\">
                                    <div id= \"first_name\">
                                        First name:  <input type =\"text\"></input>
                                    </div>
                                    <div id =\"last_name\">
                                        Last name:  <input type =\"text\"></input>
                                    </div>
                                    <input type=\"submit\" value=\"create\"></input>
                                </div>
                            </form>";
                                    
                }
                $this->Master_String .="</div></div>";
                        
    }
    /**
     * description: appends the closing </html> tag to the master string
     */
    public function close_html(){
        $this->Master_String .= "</html>";
    }
    /**
     * Load_login_page():
     * Description: Since the login page is a unique page, it's creation has been placed 
     * in a single function. Appends to the Master_String the appropriate html tags to 
     * generate the login page.
     */
    
    public function load_login_page(){
        $this->Master_String .= 
                "<div id=\"Login_outer_wrapper\">".
                    "<div id=\"Login_inner_wrapper\">".
                        "<h3 id=\"User_name_title\">Username:</h3>".
                        "<form method=\"post\" action=\"#\">".
                            "<input type=\"text\" id = \"username_form_input\" name =\"username\"></input>".
                        "<h3 id=\"password_title\">Password:</h3>".
                            "<input type=\"password\" id =\"password_form_input\" name =\"password\"></input>".
                            "<input type=\"submit\" id=\"user_login_submit\" value=\"Login\"></input>".
                    "</div>".
                    
                "</div>";
                
    /**
     * Load_main_body_wrapper():
     * Description: Append the appropriate div tag associated to the main content wrapper
     */                
                
    }
    public function load_main_body_wrapper(){
        $this->Master_String .=  "<div id=\"Main_content_wrapper\">";
        
    }
    /**
     * load_page_title($name):
     * @param String $name
     * Description: Appends a <title></title> tag to the master string to produce the page title
     */
    
    public function load_page_title($name){
        $this->Master_String .=  "<h3 id=\"page_title\">".$name."</h3>";
    }
    
    public function load_page_title_marker_student($type, $ID){
        if($type = 1){ // marker
            $query = "select marker_first_name, marker_last_name from markers where id_marker = " .$ID;
            $queryResult = $this->Database_connection->query_Database($query);
            if($queryResult !=false){
                $row = $queryResult->fetch_assoc();
                $this->Master_String .= "<h3 id=\"page_title\">"."Marker Name: ".$row['marker_first_name'] . " ".$row['marker_last_name']."</h3>";
                
            }
        }
        if($type = 2){ // student
            $query = "select student_first_name, student_last_name from student where id_student =" .$ID;
            $queryResult = $this->Database_connection->query_Database($query);
            if($queryResult !=false){
                $row = $queryResult->fetch_assoc();
                $this->Master_String .= "<h3 id=\"page_title\">".$row['marker_first_name'] . " ".$row['makrer_last_name']."</h3>";
                
            }           
        }
    }
    
    /**
     * Description: the partner function of load main body wrapper. Closes the tag with the appropriate html tag
     */
    public function close_main_body_wrapper(){
         $this->Master_String .= "</div>";
    }
    
    /**
     * load_table_body($table_type):
     * @param String $table_type
     * Description: Used by both the student/marker pages to display the tables of students/markers.
     * Based on the String passed, the function will append the appropriate html tags/elements to produce
     * the tables. 
     */
    
    public function load_table_body($table_type){

        if($table_type == "Students_home"){   
            $this->Master_String .= $this->Table_generator->generate_Student_View_All_Table();           
        }
        if($table_type == "Marker_home"){       
            $this->Master_String .= $this->Table_generator->generate_Marker_view_all_table();            
        }         
    }
    
    public function load_student_tables($Student_ID){
        $this->Master_String .= $this->Table_generator->generate_student_overall_table($Student_ID);
        $this->Master_String .= $this->Table_generator->generate_student_proposal_table($Student_ID);
        $this->Master_String .= $this->Table_generator->generate_student_final_table($Student_ID);
    }
    
    public function load_marker_tables($Marker_ID){
        // need a way to determine marker_ID/validate it.
        $this->Master_String .= $this->Table_generator->generate_marker_overall_table($Marker_ID);
        $this->Master_String .= $this->Table_generator->generate_marker_proposal_marks($Marker_ID);
        $this->Master_String .= $this->Table_generator->generate_marker_final_marks($Marker_ID);
    }
    
    /**
     * This function appends to the master_string the required html code to produce the global navigation bar which is located in the center, top half of the screen.
     * Its the navigation bar with "Seminar,Student,Markers,Logout" nav-options
     */
    public function load_global_navigation_bar(){
        $this->Master_String .=        
                "<div id = \"nav\">
                        <ul>
                            <li id =\"left_nav\"><a href=\"/CITS3200_Group_H/Library/Pages/Student.php\">Students</a></li>".
                            //<li id =\"middle_nav\"><a href=\"/CITS3200_Group_H/Library/Pages/Cohort_home.php\">Cohorts</a></li>
                            "<li id =\"middle_nav\"><a href=\"/CITS3200_Group_H/Library/Pages/Marker.php\">Markers</a></li>
                            <li id =\"middle_nav\"><a href=\"/CITS3200_Group_H/Library/Pages/dEntry.php\">Data Entry</a></li>
                            <li id = \"nav_bar_log_out\"><a href=\"#\">Log Out</a></li>
                            
                        </ul> 
                </div>";        
    }
    
    /**
     * not a necessary function but is used to make the page more readable. its only purpose is to append to the end of the string a <div id = "#"> tag
     */
    public function load_body_wrapper(){
        $this->Master_String .= "<body>";   
    }
    /**
     * Load_data_entry_page():
     * Description: Similar to the Login page, the data entry page is a unique page and as such its 
     * generating code is only located in one function. Contains all relevant html tags/elements 
     * to produce the Data entry page.
     */
    public function load_data_entry_page(){
        $this->Master_String.=  "<div id=\"data_entry_wrapper\">" .
                                    "<form>".
                                    "<div id =\"student_entry\">".
                                        "<h4>Student:</h4>".
                                        "<div id=\"Cohort_year_sem\">".
                                            "Cohort: <select></select>".
                                        "</div>".
                                        "<div id=\"Student_name\">".
                                            "Student Number: <select><option value = 1>Student name/number</option></select>".
                                        "</div>".
                                        "<button>add</button>".
                                    "</div>".
                                    "<div id=\"marker_entry\">".
                                        "<h4>Marker:</h4>".
                                        "<div id=\"marker_name\">".
                                            "Marker Name: <Select><option>marker name</option><select>".
                                        "</div>".
                                        "<button>add</button>".
                                    "</div>".
                                    "<div id =\"mark_entry\">".
                                        "<h4>Marks:</h4>".
                                        "<div id=\"seminar_type\">".
                                            "Seminar Type: <select><option value = 1>Proposal</option><option value = 2>Final</option></select>".
                                        "</div>".
                                        "<div id=\"mark1\">".
                                            "Quality of Oral Delivery: <Select><option value=1>1</option></select><br>".
                                        "</div>".
                                        "<div id=\"mark2\">".
                                            "Quality of Slides:  <Select><option value=1>1</option></select><br>".
                                        "</div>".
                                        "<div id=\"mark3\">".
                                            "Content: <Select><option value=1>1</option></select><br>".
                                        "</div>".
                                    "</div>".
                                        "<input type=\"submit\" value=\"Add Marks\">".
                                    "</form>".
                                    
                                "</div>";
                
    }
    
    /**
     * The partner method for load_body_wrapper, its only purpose is to append a </div> tag to the master string.
     */
    public function close_body_wrapper(){
        $this->Master_String .= "</body>";
    }
    /**
     * The navigation bar inside the Seminars tab on the home page requires an additional navigation bar which is tailored to the need of searching for a 
     * set of unique seminars. Ie search for all seminars in the winthrop hall... or look for all seminars on an exact date.
     */
    public function load_table_nav_bar($table_type){
        $this->Master_String.= "<div id=\"table_nav_wrapper\">";
        if($table_type == "Students_home"){
            $this->Master_String.= $this->generate_student_home_navigation_bar();
        }
        if($table_type == "Marker_home"){
            $this->Master_String .= $this->generate_marker_home_navigation_bar();
        }
        $this->Master_String.= "</div>";
    }
    
    /**
     * Description: a function paired to the load_table_nav_bar. based on the table type supplied,
     * the parent function will make the appropriate call. Function is designed to append to the 
     * Master String the appropriate html tag/elements to produce the sub table navigation bar.
     * @return String
     */
    
    private function generate_marker_home_navigation_bar(){
        return
                "<form method=\"post\" action=\"\">".
                    "<div id=\"Cohort_Search\">".
                        "Marker Name:  ".
                        "<input type=\"text\"></input>".
                        "<input type=\"submit\" value = \"search\"></input>".
                    "</div>".
                        
                "</form>".
                "<button onclick=\"display()\">Add</button>";
    }

        
     /**
     * Description: a function paired to the load_table_nav_bar. based on the table type supplied,
     * the parent function will make the appropriate call. Function is designed to append to the 
     * Master String the appropriate html tag/elements to produce the sub table navigation bar.
     * @return String
     */
    private function generate_student_home_navigation_bar(){
        return
                
                    "<form method=\"Post\" action =\"#\">".
                        "<div id=\"Student_Search\">".
                            "Student Number:  ".
                                "<input type=\"text\"></input>".
                            "  Cohort:  ".
                                "<select>
                                  <option value=\"2014\">2014</option>
                                </select>".
                            
                                "<select>
                                  <option value=\"1\">Semester 1</option>
                                  <option value=\"2\">Semester 2</option>
                                </select>".
                                "<input type=\"submit\" value = \"search\"></input>".
                                
                        "</div>".
                    "</form>".
                    "<button onclick=\"display()\">Add</button>";
        
    }
    

    /**
     * After all functions have been called and all strings appended to the master_String, the master string is called and returned to the caller to be echoed out to the browser 
     * @return type
     */
    public function return_Master_String(){
        return $this->Master_String;
    }

    
    
}

