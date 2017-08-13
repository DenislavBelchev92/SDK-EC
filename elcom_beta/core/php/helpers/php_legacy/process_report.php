<?php

// Process the input from the form in report_problem.php

//include_once "header.php";
//include_once("../defines/sql_defs.php");
//include_once "database.php";
//include_once "form_processing_helpers.php";

header('Content-Type: text/html;charset=utf-8');

//Connect to the Database
$db = new Database();

if(isset($_POST['report_issue'])) {

    // Make validity checks
    $issue_name = process_form_input($_POST['issue_name'],$db->link);
    $issue_location = process_form_input($_POST['issue_location'],$db->link);
    $issue_area = process_form_input($_POST['issue_area'],$db->link);
    $issue_detailed_description = process_form_input($_POST['issue_detailed_description'],$db->link);
    $issue_type = process_form_input($_POST['issue_type'],$db->link);
    $user = $_SESSION['username'];

    $query = "INSERT INTO basic_data (Name, Location, Area, Creator, Detailed_description, Type)
     VALUES ('$issue_name', '$issue_location', '$issue_area', '$user', '$issue_detailed_description', '$issue_type')";

    //All needed checks are included in the object
    $db->insert($query);

}

?>
