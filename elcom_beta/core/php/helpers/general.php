<?php
	function mysql_sanitize($db, $data) {
		return mysqli_real_escape_string($db, $data );
	}
	
	function redirect_to($location = '../index.html') {
		header('Location: ' . $location);
		exit;
	}
	
	function function_form_print_errors($errors= array()) {
		
		$output = "<div class=\"errors\">";
		$output .= "Please fix the following errors:";
		$output .= "<ul>";

        foreach ($errors as $key => $error)
        {
            $output .= "<li>{$error}</li>";
        }

		$output .= "</ul>";
		$output .= "</div>";
		
		return $output;
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

    function populate_form_fields ($users_db, $valid_fields, $clear_fields = false) {

        /*
         * Create the list of values to be printed in the form fields depending on the user selected
         */
        $users_columns_values = array();

        /*
         * No matter what If 'clear' is set clear the fields
         */
        if ($clear_fields){
            foreach ($valid_fields as $valid_users_col) {
                $users_columns_values["{$valid_users_col}"] = NULL;
            }

            $_SESSION['user_selected'] = NULL;
        } else {
            if (isset($_SESSION['user_selected'])) {
                $users_to_modify_data_array = $users_db->select_user($_SESSION['user_selected'], "")->fetch_assoc();
                foreach ($valid_fields as $valid_users_col) {
                    $users_columns_values["{$valid_users_col}"] = $users_to_modify_data_array["{$valid_users_col}"];
                }
            } else {
                foreach ($valid_fields as $valid_users_col) {
                    $users_columns_values["{$valid_users_col}"] = NULL;
                }
            }
        }

        $_SESSION['users_columns_values'] = $users_columns_values;
    }

    function choose_user_to_be_modified ($users_db) {
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

    function validate_form_input_fields($db, $valid_fields_array)
    {

        // Check relevant fields
        foreach ($valid_fields_array as $field) {
            /*
             * Get the field value
             */
            $value = trim($_POST[$field]);

            /*
             * Check if there is at all anything in the field.
             */

            if (!has_presence($value)) {
                array_push($_SESSION['message_info']['errors'], ucfirst($field) . ' cannot be blank!' );
            }

            /*
            * Make all specific checks per the type and the name of the field.
            */
            field_specific_validations($db, $field, $value);

        }

        if (!empty($_SESSION['message_info']['errors'])){
            return false;
        }

        return true;
    }

    function field_specific_validations($db, $tested_field, $tested_value)
    {

        $table_specific_rules = $db->get_table_specific_rules();

        while ($field_specific_rules = $table_specific_rules->fetch_assoc()) {

            if ($field_specific_rules['field_name'] == $tested_field) {

                $errors[$tested_field] = array();

                $value_nof_chars = strlen($tested_value);

                if ($value_nof_chars < $field_specific_rules['min_nof_characters']) {
                    array_push($_SESSION['message_info']['errors'], "field " . $tested_field . " should be at least " . $field_specific_rules['min_nof_characters'] . " characters long!");
                }

                if ($value_nof_chars > $field_specific_rules['max_nof_characters']) {
                    array_push($_SESSION['message_info']['errors'], "field " . $tested_field . " should not be more than " . $field_specific_rules['min_nof_characters'] . " characters long!");
                }

                if ($field_specific_rules['is_unique']) {
                    /*
                     * Check that database won't return more that 1 row with this query.
                     */

                    /*
                     * FIX ME! For now only username should be unique
                     */

                    if ($db->select_user($tested_value)->num_rows != 0 ) {
                        array_push($_SESSION['message_info']['errors'], "User with such " . $field_specific_rules['field_name'] . " already exists!");
                    }

                }
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
             * INIT Session message
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

    function display_message() {

    if (isset($_SESSION['message_info'])) {

        $output  = "<div class='row'>";
        $output .= "<div class='well well-sm' style='margin: 5px 0'>";
        $output .= "<b>";

        $output .= $_SESSION['message_info']['message'];

        if (isset($_SESSION['message_info']['errors'])) {
            $output .= "<br />";
            foreach($_SESSION['message_info']['errors'] as $error) {
                $output .= $error . " <br />";
            }
        }
        /*
         * Clear message info
         */
        foreach ($_SESSION['message_info'] as $info => $value) {
            $_SESSION['message_info'][$info] = NULL;
        }

        $output .= "</b>";
        $output .= "</div>";
        $output .= "</div>";

    } else {

        $output = "";
    }

    return $output;
}
?>