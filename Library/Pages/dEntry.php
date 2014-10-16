<?php
include_once "/var/www/html/APHB-3200/Library/Helpers/Page.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/User_Control.php";

session_start();
$User_Check = new User_Control();
$User_Check_Outcome = $User_Check->is_Session_Active();
if ($User_Check_Outcome == false) {
    header('location:/APHB-3200/Library/Pages/Login.php');
} else {

    $new_page = new Page("Data Entry");
    $new_page->load_html_header();
    $new_page->load_body_wrapper();
    $new_page->set_error_url();
    if(!isset($_GET['Mark_ID']) && !isset($_GET['M_ID']) && !isset($_GET['S_ID'])){
        $new_page->set_url();
    }
    
    if(isset($_SESSION['ERROR'])){
        $new_page->load_shadow(array("cohort_select","import","error"));
    }
    else{
        $new_page->load_shadow(array("cohort_select","import"));
    }
    
    $new_page->load_global_navigation_bar();

    $new_page->load_data_entry_page();
    
    $new_page->close_body_wrapper();    // might have to rename to something other than body wrapper, could change to body tag?
    $new_page->close_shadow();
    $new_page->close_html();

    echo $new_page->return_Master_String();
}
