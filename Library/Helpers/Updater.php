<?php
if (strpos(php_uname(), 'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/User_Control.php";
    
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/User_Control.php";
}


session_start();
$User_Check = new User_Control();
$User_Check_Outcome = $User_Check->is_Session_Active();
if ($User_Check_Outcome == false) {
    header('location:/CITS3200_Group_H/Library/Pages/Login.php');
} 
else {
    $database_connection = new Database_Connection();
    $result = $database_connection->query_Database("select cohort,semester from users");
    $current_cohort = $result->fetch_assoc();
    
    if(isset($_POST['year']) && isset($_POST['sem'])){
        $query = "update users set cohort=".$_POST['year'].",semester=".$_POST['sem'];
        $database_connection->query_Database($query);

        
    }
    if(isset($_POST['S_SD']) && isset($_POST['S_FN']) && isset($_POST['S_LN'])){
        $new_id = $database_connection->return_new_id("student");
        $query = "insert into students values (".$new_id.",\"".$_POST["S_FN"]."\",\"".$_POST['S_LN']."\",\"".$_POST['S_SD']."\",".$current_cohort['cohort'].",".$current_cohort['semester'].");";
        $database_connection->query_Database($query);
        
    }
    
    if(isset($_POST['M_FN']) && isset($_POST['M_LN'])){
        $new_id = $database_connection->return_new_id("marker");
        $query = "insert into markers values (".$new_id.",\"".$_POST["M_FN"]."\",\"".$_POST['M_LN']."\");";
        $database_connection->query_Database($query);
        
    }
    
    if(isset($_POST['marks_student']) && isset($_POST['marks_marker']) && isset($_POST['marks_sem_type']) && isset($_POST['mark_1']) && isset($_POST['mark_1']) && isset($_POST['mark_2']) && isset($_POST['mark_3'])){
        $new_id = $database_connection->return_new_id("marks");
        $query = "insert into marks values (".$new_id.",".$_POST['mark_1'] .",".$_POST['mark_2'].",".$_POST['mark_3'].",".$_POST['marks_sem_type'].",".$_POST['marks_student'].",".$_POST['marks_marker']." )";
        $database_connection->query_Database($query);
        
    }
    
    if(isset($_GET['url'])){
        $redirect_URL = "location:".$_GET['url'];
        header($redirect_URL);
    }
    else{
        header('location:Student.php');
    }
}