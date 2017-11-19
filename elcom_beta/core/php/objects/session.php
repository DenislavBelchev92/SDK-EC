<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/10/2017
 * Time: 10:57 AM
 */

class Session
{
    private $logged_in = false;

    public $user_id;

    function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->check_login();
        if($this->logged_in) {

        } else {

        }
    }

    /*
    * PRIVATE METHODS
    */
    private function check_login() {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }

    /*
     * PUBLIC METHODS
     */
    public function login($user) {
        //Database should find the user by username and password
        $user = User::get_by_username($user->username);

        if($user) {
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->logged_in = true;
        }
    }

    public function logout() {
        unset($this->user_id);
        unset($_SESSION['user_id']);
        $this->logged_in = false;
    }

    public function is_logged_in() {
        return $this->logged_in;
    }

    /*
     * { ERROR HANDLING
     */
    public function set_message($message) {
        $_SESSION['message'] = $message;
    }

    public function display_message($pretty = false) {

        $output = "";

        if (isset($_SESSION['message'])) {

            $output .= "<div>";
            if ($pretty) {
                $output .= "<div class='well well-sm' style='margin: 5px 0'>";
            }
            $output .= "<b>";

            $output .= $_SESSION['message'];

            /*
             * Clear message
             */
            unset($_SESSION['message']);


            $output .= "</b>";
            if ($pretty) {
                $output .= "</div>";
            }
            $output .= "</div>";
        }

        echo $output;
    }

    public static function display_current_field_errors($field_errors) {

        $output = "";
        if(!empty($field_errors)){
            $output .= "<div class='alert alert-warning'>";

            foreach($field_errors as $error){
                $output .= "<strong>ERROR! </strong> ";
                $output .= $error;
                $output .= "<br /> ";
            }
            $output .= "</div>";

        }

        echo $output;
    }

    public function add_form_field_error($field_name, $error) {
        if (isset($_SESSION['form_fields_errors'][$field_name])) {
            array_push($_SESSION['form_fields_errors'][$field_name], $error);
        } else {
            $_SESSION['form_fields_errors'][$field_name][] = $error;
        }
    }

    public function get_form_field_errors($field_name) {
        if (isset($_SESSION['form_fields_errors'][$field_name])) {
            return $_SESSION['form_fields_errors'][$field_name];
        } else {
            return false;
        }
    }

    public function get_all_form_field_errors() {
        if (isset($_SESSION['form_fields_errors'])) {
            return $_SESSION['form_fields_errors'];
        } else {
            return NULL;
        }
    }

    public function clear_form_field_errors() {
        unset($_SESSION['form_fields_errors']);
    }


    /*
     * } ERROR HANDLING
     */

    /*
     * { ADMIN ONLY
     */
    /*
     *  { USERS
     */
    /*
     * Saves a User object to be modified
     */
    public function save_user_id_to_modify($user_id) {
        $_SESSION['user_id'] = $user_id;
    }

    public function get_user_id_to_modify() {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return false;
        }

    }

    public function free_user_id_to_modify() {
        unset($_SESSION['user_id']);
    }
    /*
     *  } USERS
     */
    /*
     *  { CALLOUTS
     */
    public function save_callout_id_to_modify($user_id) {
        $_SESSION['callout_id'] = $user_id;
    }

    public function get_callout_id_to_modify() {
        if (isset($_SESSION['callout_id'])) {
            return $_SESSION['callout_id'];
        } else {
            return false;
        }

    }

    public function free_callout_id_to_modify() {
        unset($_SESSION['callout_id']);
    }


    public function save_callout_filter($area) {
        $_SESSION['area'] = $area;
    }

    public function get_callout_filter() {
        if (isset($_SESSION['area'])) {
            return $_SESSION['area'];
        } else {
            return false;
        }

    }

    public function free_callout_filter() {
        unset($_SESSION['area']);
    }
    /*
     *  } CALLOUTS
     */
    /*
    * } ADMIN ONLY
    */
}