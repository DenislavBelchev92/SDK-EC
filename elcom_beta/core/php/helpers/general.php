<?php

    function __autoload ($class_name) {
        $class_name = strtolower($class_name);
        $path =  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/objects/{$class_name}.php";

        if(file_exists($path)) {
            require_once($path);
        } else {
            die("Path of class definition {$path} not found.");
        }
    }
	
	function redirect_to($location = '../index.html') {
		header('Location: ' . $location);
		exit;
	}

	function has_presence($value){
		return  isset($value) === true && $value !== "";
	}
	
    function arrayCopy( array $array ) {
        $result = array();
        foreach( $array as $key => $val ) {
            if( is_array( $val ) ) {
                $result[$key] = arrayCopy( $val );
            } elseif ( is_object( $val ) ) {
                $result[$key] = clone $val;
            } else {
                $result[$key] = $val;
            }
        }
        return $result;
    }

    function choose_user_to_be_modified () {

        global $users_db;
        /*
        * Choose user to modify
        */
        if (isset($_GET['user_selected'])) {
            $_SESSION['user_selected'] = mysql_sanitize($users_db->db_con, $_GET['user_selected']);

        } else {
            if (isset($_SESSION['user_selected'])) {
                /*
                 * DO nothing! Keep user.
                 */
            } else {
                $_SESSION['user_selected'] = NULL;
            }
        }

    }

    function choose_message_to_display ($current_page) {

	    /*FIX ME. FIND A BETTER WAY*/
	    $page_1 = array(
	        'page_name'         => "manage_users",
            'init_message'      => "About to modify users ",
            'dynamic_message'   => "About to modify user "
        );
        $page_2 = array(
            'page_name'         => "add_users",
            'init_message'      => "About to add new user ",
            'dynamic_message'   => "Using as template the info from "
        );

        $SUPPORTED_PAGES = array($page_1, $page_2);

        $page_found = false;
        foreach ($SUPPORTED_PAGES as $page) {
            if ($current_page === $page['page_name']) {
                $page_found = true;
                $init_message    = $page['init_message'];
                $dynamic_message = $page['dynamic_message'];
            }
        }

        if(!$page_found) {
            die("Internal error - page not found");
        }

        if(isset($_SESSION['message_info'])) {
            if ($_SESSION['message_info']['sql_status']) {
                /*
                 * Do nothing. Message is received from other page.
                 */
            } else {
                /*
                 * Local messages
                 */
                if (isset($_SESSION['user_selected'])) {
                    /*
                    * Set dynamic message
                    */
                    $_SESSION['message_info'] = array('sql_status' => false, 'message' => $dynamic_message . $_SESSION['user_selected']);

                } else {
                    /*
                    * Set init message
                    */
                    $_SESSION['message_info'] = array('sql_status' => false, 'message' => $init_message);
                }
            }

        } else {
            /*
             * INIT session message
             * sql_status - does the message carry also a result info from sql query.
             * message    - actual one-line message to be displayed in the info box.
             * errors     - array of all the errors occurred. Errors should be accumulated only in users_modify.php.
             *              INIT as empty array if no errors are present.
             */
            $_SESSION['message_info'] = array('sql_status' => false, 'message' => $init_message);

            if (isset($_SESSION['message_info']['errors'])) {
                /*
                 * Do nothing
                 */
            } else {
                $_SESSION['message_info']['errors'] = array();
            }
        }

    }

    function br() {
        echo "<br />";
    }

?>