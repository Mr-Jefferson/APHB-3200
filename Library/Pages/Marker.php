<?php

if (strpos(php_uname(), 'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/Page.php";
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/Helpers/User_Control.php";
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/Page.php";
    include_once "/var/www/html/CITS3200_Group_H/Library/Helpers/User_Control.php";
}

session_start();
$User_Check = new User_Control();
$User_Check_Outcome = $User_Check->is_Session_Active();
if ($User_Check_Outcome == false) {
    header('location:/CITS3200_Group_H/Library/Pages/Login.php');
} else {

    $new_page = new Page("Markers");
    $new_page->load_html_header();
    $new_page->load_body_wrapper();
    $new_page->load_global_navigation_bar();
    $new_page->load_shadow(1);
    $new_page->load_main_body_wrapper();
    if (isset($_GET['M_ID'])) {
        $new_page->load_page_title_name(1, $_GET['M_ID']);
        $new_page->load_marker_tables($_GET['M_ID']);
    } else {
        $new_page->load_page_title("Markers");
        $new_page->load_table_nav_bar("Marker_home");
        $new_page->load_table_body("Marker_home");
    }
    $new_page->close_main_body_wrapper();
    $new_page->close_body_wrapper();    // might have to rename to something other than body wrapper, could change to body tag?
    $new_page->close_html();

    echo $new_page->return_Master_String();
}
