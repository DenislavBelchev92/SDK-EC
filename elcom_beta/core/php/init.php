<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/common/general_info.php";

	require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/defines/init_defs.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/defines/flags.php";

    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/database/database.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/database/users_register_database.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/database/callouts_database.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/database/lost_and_found.php";

    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/objects/session.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/objects/user.php";

    require_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/helpers/general.php";

    global $Session;

    global $Users_Register_DB;
    global $Callouts_DB;

    if (!isset($Session)) {
        $Session = new Session();
    }
    $Callouts_DB = new Callouts_Database();
    $Users_Register_DB  = new Users_Register_Database();

//    $ALL_USERS = User::get_all();
//    $VALID_USER_COLUMNS = User::get_table_columns();

?>