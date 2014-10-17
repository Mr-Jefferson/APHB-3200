<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/User_Control.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/Error_Handler.php";


session_start();
$User_Check = new User_Control();
$User_Check_Outcome = $User_Check->is_Session_Active();
if ($User_Check_Outcome == false) {
    header('location:/APHB-3200/Library/Pages/Login.php');
} 
else {
    $error = new error_handler();
    $database_connection = new Database_Connection();
    $result = $database_connection->query_Database("select cohort,semester from users");
    $current_cohort = $result->fetch_assoc();
    
    
    $boolean_flag = true;
    $delete_url_codition = false;
    $type_array = array();
    $param_array = array();
    $query = "";
    if(isset($_GET['delete'])){
        $type_array = array("i");
        //delete student
        if(isset($_GET['S_ID'])){
            $query = "delete from students where id_student=? and cohort=? and semester=?";
            $param_array = array($_GET['S_ID'],$current_cohort['cohort'], $current_cohort['semester']);
            $type_array = array("i","i","i");
            $delete_url_codition = true;
        }
        //delete marker
        elseif(isset($_GET['M_ID'])){
            $query = "delete from markers where id_marker=?";
            $param_array = array($_GET['M_ID']);
            $type_array = array("i");
            $delete_url_codition = true;
        }
        //delete marks
        elseif(isset($_GET['Mark_ID'])){
            $query = "delete from marks where id_mark=?";
            $param_array = array($_GET['Mark_ID']);
            $type_array = array("i");
        }
        else{
            $boolean_flag = false;
            $_SESSION['ERROR'] .= "Please fill in all form fields<br>";
        }
        
    }
    if(isset($_GET['update'])){
        // update marks
        if(isset($_GET['Mark_ID'])){
            $query = "update marks set mark_1=?, mark_2 =?, mark_3=?,seminar=?,id_student=?,id_marker=? where id_mark =?";
            $outcome = $error->validate_mark(array($_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3']),$_POST['marks_marker'],$_POST['marks_student'],$_POST['marks_sem_type'], $_GET['Mark_ID']);
            if($outcome == false){
                $boolean_flag = false;
                
            }
            $param_array = array($_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3'],$_POST['marks_sem_type'],$_POST['marks_student'],$_POST['marks_marker'], $_GET['Mark_ID']);
            $type_array = array("d","d","d","i","i","i","i");
        }
        //update marker
        if(isset($_GET['M_ID'])){
            if(empty($_POST['M_FN']) || empty($_POST['M_LN'])){
                $boolean_flag = false;
                $error->add_to_error("Please fill in all form fields<br>");
            }
            else{
                $query = "update markers set marker_first_name=?,marker_last_name=? where id_marker=?";
                $outcome = $error->new_marker_check($_POST['M_FN'],$_POST['M_LN'],$_GET['M_ID']);
                if($outcome == false){
                    $boolean_flag = false;

                }
                $param_array= array($_POST['M_FN'], $_POST['M_LN'],$_GET['M_ID']);
                $type_array = array("s","s","i");
            }
            
        }
        //update student
        if(isset($_GET['S_ID']) && isset($_POST['S_SD']) && isset($_POST['S_FN'])&&isset($_POST['S_LN']) && isset($_POST['year']) && isset($_POST['sem'])){
            if(empty($_POST['S_SD']) || empty($_POST['S_FN']) || empty($_POST['S_LN']) || empty($_POST['year']) || empty($_POST['sem'])){
                $boolean_flag = false;
                $error->add_to_error("Please fill in all form fields<br>");
            }
            else{
                $query = "update students set student_number=?, student_first_name=?, student_last_name=?,cohort=?, semester = ? where id_student =?";
                $outcome = $error->update_student_check($_POST['S_SD'],$_POST['S_FN'],$_POST['S_LN'],$current_cohort['cohort'],$current_cohort['semester'],(int)$_GET['S_ID']);
                if($outcome == false){
                    $boolean_flag = false;

                }                
                $param_array = array($_POST['S_SD'],$_POST['S_FN'],$_POST['S_LN'],$_POST['year'],$_POST['sem'], $_GET['S_ID']);
                $type_array = array("i","s","s","i","i","i");
            }
            
        }else{
            
            
            
           //Update Current cohort
            if(isset($_POST['year']) && isset($_POST['sem']) ){
                $query = "update users set cohort=?,semester=? where id_user=1 ";
                $param_array = array($_POST['year'],$_POST['sem']);
                $type_array = array("i","i");
            } 
        }
        
       
    }
    if(isset($_GET['insert'])){
        //add student
        if(isset($_POST['S_SD']) && isset($_POST['S_FN']) && isset($_POST['S_LN'])){
            if(empty($_POST['S_SD']) || empty($_POST['S_FN']) || empty($_POST['S_LN'])){
                $boolean_flag = false;
                $error->add_to_error("Please fill in all form fields<br>");
            }
            else{     
                $outcome = $error->new_student_check($_POST['S_SD'], $_POST['S_FN'], $_POST['S_LN'], $current_cohort['cohort'], $current_cohort['semester']);
                if($outcome == false){
                    $boolean_flag = false;
                }
                $new_id = $database_connection->return_new_id("student");     
                $query = "insert into students values (?,?,?,?,?,?);";
                $param_array = array($new_id,$_POST["S_FN"],$_POST['S_LN'],$_POST['S_SD'],$current_cohort['cohort'],$current_cohort['semester']);
                $type_array = array("i","s","s","i","i","i");
            }
        }
        //add marker
        if(isset($_POST['M_FN']) && isset($_POST['M_LN']) ){
            if(empty($_POST['M_FN']) || empty($_POST['M_LN'])){
                $error->add_to_error("Please fill in all form fields<br>");
                $boolean_flag = false;
            }
            else{
                $new_id = $database_connection->return_new_id("marker");
                $outcome = $error->new_marker_check($_POST['M_FN'],$_POST['M_LN'],-1);
                if($outcome == false){
                    $boolean_flag = false;
                }
                $query = "insert into markers values (?,?,?);";
                $param_array = array($new_id,$_POST["M_FN"],$_POST['M_LN']);
                $type_array =array("i","s","s");
                echo "10";
            }
            
        }
        //add marks
        if(isset($_POST['marks_student']) && isset($_POST['marks_marker']) && isset($_POST['marks_sem_type']) && isset($_POST['mark_1']) && isset($_POST['mark_2']) && isset($_POST['mark_3'])){
            $new_id = $database_connection->return_new_id("marks");
            $outcome = $error->validate_mark(array($_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3']),$_POST['marks_marker'],$_POST['marks_student'],$_POST['marks_sem_type'],-1);
            if($outcome == false){
                $boolean_flag = false;
            }
            $query = "insert into marks values (?,?,?,?,?,?,?);";
            $param_array = array($new_id,$_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3'],$_POST['marks_sem_type'],$_POST['marks_student'], $_POST['marks_marker']);
            $type_array = array("i","d","d","d","i","i","i");  
        }
    }
    
    if($boolean_flag == false){
        $redirect_URL = "location:".$_SESSION['ERROR_URL'];
        $_SESSION['ERROR'] = $error->return_error_string();
        header($redirect_URL);
    }
    else{
        $database_connection->Prepared_query_Database($query,$param_array,$type_array);
        if(isset($_SESSION['url'])){
            $redirect_URL = "location:".$_SESSION['url'];
            unset($_SESSION['url']);
        
            if($delete_url_codition == true){
                $new_url = explode("?",$redirect_URL);
                $redirect_URL = $new_url[0];
            }
            
            header($redirect_URL);
        }
        else{
            header('location:../Pages/Student.php');
        }
    }
    
    
}
