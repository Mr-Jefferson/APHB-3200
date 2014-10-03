<?php
if (strpos(php_uname(), 'NICK') !== false) {
    include_once "C:/xampp/htdocs/CITS3200_Group_H/Library/DB/Database_Connection.php";
} else {
    include_once "/var/www/html/CITS3200_Group_H/Library/DB/Database_Connection.php";
}

$database_connection = new Database_Connection();

if(isset($_POST['Cohort']) && isset($_POST['semester'])){
    $query = "update users set cohort=".$_POST['cohort'].",semester=".$_POST['semester'];
    $database_connection->query_Database($query);
    header('location:Login.php');
}
