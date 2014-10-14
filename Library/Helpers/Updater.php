<?php
include_once "/var/www/html/APHB-3200/Library/DB/Database_Connection.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/User_Control.php";
include_once "/var/www/html/APHB-3200/Helpers/error_Handler.php";


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
    
    //echo $_SESSION['url'];
    if(isset($_GET['delete'])){
        $type_array = array("i");
        //delete student
        if(isset($_GET['S_ID'])){
            $query = "delete from students where id_student=?";
            $param_array = array($_GET['S_ID']);
            echo "1";
        }
        //delete marker
        if(isset($_GET['M_ID'])){
            $query = "delete from markers where id_marker=?";
            $param_array = array($_GET['M_ID']);
            echo "2";
        }
        //delete marks
        if(isset($_GET['Mark_ID'])){
            $query = "delete from marks where id_mark=?";
            $param_array = array($_GET['Mark_ID']);
            echo "3";
        }
        //$database_connection->Prepared_query_Database($query,$param_array,$type_array);
    }
    if(isset($_GET['update'])){
        // update marks
        if(isset($_GET['Mark_ID'])){
            $query = "update marks set mark_1=?, mark_2 =?, mark_3=?,seminar=?,id_student=?,id_marker=? where id_mark =?";
            $outcome = $error->validate_mark($_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3'],$_POST['marks_marker'],$_POST['marks_student'],$_POST['marks_sem_type'], $_GET['Mark_ID']);
            if($outcome == false){
                $boolean_flag = false;
                
            }
            $param_array = array($_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3'],$_POST['marks_sem_type'],$_POST['marks_student'],$_POST['marks_marker'], $_GET['Mark_ID']);
            $type_array = array("i","i","i","i","i","i","i");
            echo "4";
        }
        //update marker
        if(isset($_GET['M_ID'])){
            $query = "update markers set marker_first_name=?,marker_last_name=? where id_marker=?";
            $outcome = $error->new_marker_check($_POST['M_FN'],$_POST['M_LN']);
            if($outcome == false){
                $boolean_flag = false;
                
            }
            $param_array= array($_POST['M_FN'], $_POST['M_LN'],$_GET['M_ID']);
            $type_array = array("s","s","i");
            echo "5";
        }
        //update student
        if(isset($_GET['S_ID']) && isset($_POST['S_SD']) && isset($_POST['S_FN'])&&isset($_POST['S_LN']) && isset($_POST['year']) && isset($_POST['sem'])){
            $query = "update students set student_number=?, student_first_name=?, student_last_name=?,cohort=?, semester = ? where id_student =?";
            $outcome = $error->update_student_check($_POST['S_SD'],$_POST['S_FN'],$_POST['S_LN'],$current_cohort['cohort'],$current_cohort['semester']);
            if($outcome == false){
                $boolean_flag = false;
                
            }                
            $param_array = array($_POST['S_SD'],$_POST['S_FN'],$_POST['S_LN'],$_POST['year'],$_POST['sem'], $_GET['S_ID']);
            $type_array = array("i","s","s","i","i","i");
            echo "6";
        }else{
            
            
            
           //Update Current cohort
            if(isset($_POST['year']) && isset($_POST['sem']) ){
                $query = "update users set cohort=?,semester=?";
                $param_array = array($_POST['year'],$_POST['sem']);
                $type_array = array("i","i");
                echo "7";
            } 
        }
        
        //$database_connection->Prepared_query_Database($query,$param_array,$type_array);
    }
    if(isset($_GET['insert'])){
        //add student
        if(isset($_POST['S_SD']) && isset($_POST['S_FN']) && isset($_POST['S_LN'])){
            $outcome = $error->new_student_check($_POST['S_SD'], $_POST['S_FN'], $_POST['S_LN'], $current_cohort['cohort'], $current_cohort['semester']);
            if($outcome == false){
                $boolean_flag = false;
                
            }
            $new_id = $database_connection->return_new_id("student");     
            $query = "insert into students values (?,?,?,?,?,?);";
            $param_array = array($new_id,$_POST["S_FN"],$_POST['S_LN'],$_POST['S_SD'],$current_cohort['cohort'],$current_cohort['semester']);
            $type_array = array("i","s","s","i","i","i");
            
            echo "8";
        }
        //add marker
        if(isset($_POST['M_FN']) && isset($_POST['M_LN']) ){
            $new_id = $database_connection->return_new_id("marker");
            $outcome = $error->new_marker_check($_POST['M_FN'],$_POST['M_LN']);
            if($outcome == false){
                $boolean_flag = false;
               
            }
            $query = "insert into markers values (?,?,?);";
            $param_array = array($new_id,$_POST["M_FN"],$_POST['M_LN']);
            $type_array =array("i","s","s");
            echo "9";
        }
        //add marks
        if(isset($_POST['marks_student']) && isset($_POST['marks_marker']) && isset($_POST['marks_sem_type']) && isset($_POST['mark_1']) && isset($_POST['mark_2']) && isset($_POST['mark_3'])){
            $new_id = $database_connection->return_new_id("marks");
            $outcome = $error->validate_mark($_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3'],$_POST['marks_marker'],$_POST['marks_student'],$_POST['marks_sem_type'],-1);
            if($outcome == false){
                $boolean_flag = false;
                
                
            }
            $query = "insert into marks values (?,?,?,?,?,?,?);";
            $param_array = array($new_id,$_POST['mark_1'],$_POST['mark_2'],$_POST['mark_3'],$_POST['marks_sem_type'],$_POST['marks_student'], $_POST['marks_marker']);
            $type_array = array("i","i","i","i","i","i","i"); 
           
            echo "10 <br>";
        }
        //$database_connection->Prepared_query_Database($query,$param_array,$type_array);
    }
    if($boolean_flag == false){
        $redirect_URL = "location:".$_SESSION['ERROR_URL'];
        $_SESSION['ERROR'] = $error->return_error_string();
        echo $redirect_URL;
        //header($redirect_URL);
    }
    else{
        if(isset($_SESSION['url'])){
            $redirect_URL = "location:".$_SESSION['url'];
            unset($_SESSION['url']);
        
            if(isset($_GET['delete'])){
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