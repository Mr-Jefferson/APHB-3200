<?php

/**
 * The login.php page will consist of conditional statments and echo statements to produce the final page which is then pushed to the browser.
 */
include_once "/var/www/html/APHB-3200/Library/Helpers/Page.php";
include_once "/var/www/html/APHB-3200/Library/Helpers/User_Control.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $new_user = new User_Control();
    $outcome = $new_user->validate_User($_POST['username'], $_POST['password']);

    if ($outcome == true) {
        $new_user->generate_Session($_POST['username']);
        $new_user->set_Cohort();
    
        header('location:Student.php');
    } else {
        header('location:Login.php');
    }
}

$new_page = new Page("Login");
$new_page->load_html_header();
$new_page->load_body_wrapper();
$new_page->load_login_page();
$new_page->close_body_wrapper();
$new_page->close_html();

echo $new_page->return_Master_String();
?>