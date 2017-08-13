<?php

// Makes sure that nothing harmfull to the page will be submited via the form inputs
function process_form_input($input, $db_connection) {

    $input = strip_tags(($input));

    $input = stripslashes(($input));

    $input = mysqli_real_escape_string($db_connection,$input);

    return  $input;
}

// Encrypts the password with md5 algorthm
function encrypt($password) {

    $password = md5($password);

    return $password;
}


?>