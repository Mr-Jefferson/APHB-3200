<?php
/*
 * Page is dedicated to displaying the student/marker table
 */
if(strpos(php_uname(),'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/Page.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/User_Control.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/Table_Generation.php";
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/Page.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/User_Control.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/Table_Generation.php";
}

session_start();
$User_Check = new User_Control();
$User_Check_Outcome = $User_Check->is_Session_Active();
if($User_Check_Outcome == false){
    header('location:/CITS3200_Group_H/Library/Pages/Login.php');
}
else{
    
    $new_page = new Page("Students");
    $new_page->load_html_header();
    $new_page->load_body_wrapper();
    $new_page->load_shadow(2);
    $new_page->load_global_navigation_bar();
    $new_page->load_main_body_wrapper();
    if(isset($_GET['S_ID'])){   // could include a check to confirm the student ID is set and valid
        $new_page->load_page_title("Student: ". $_GET['S_ID']);
        $new_page->load_student_tables($_GET['S_ID']);
        
    }
    else{
        $new_page->load_page_title("Students");
        $new_page->load_table_nav_bar("Students_home");
        $new_page->load_table_body("Students_home");
    }
    $new_page->close_main_body_wrapper();
    $new_page->close_body_wrapper();    // might have to rename to something other than body wrapper, could change to body tag?
    $new_page->close_html();

    echo $new_page->return_Master_String();
}
