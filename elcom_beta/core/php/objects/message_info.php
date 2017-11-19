<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/29/2017
 * Time: 9:27 AM
 */

class message_info
{
    public $message = 'init_message';
    public $errors = array();

    /*
     * SQL specific
     */
    public $sql_status;

    /*
     * Form input handling
     */
    public $form_fields_status_objects = array();
    public function add_form_field_error ($form_field_name, $error, $form_is_OK = false)
    {

        /*
         * If an error object already exits we only have to add an error to the exiting array
         */
        $is_found = false;
        foreach ($this->form_fields_status_objects as $form_field_status) {
            if ($form_field_status->field_name === $form_field_name) {

                array_push($form_field_status->field_errors, $error);
                $is_found = true;
            }
        }

        /*
         * If this is the first error for this form field initialize an error object first
         */
        if (!$is_found) {
            $form_field_status = new form_field_status;

            $form_field_status->field_name = $form_field_name;
            array_push($form_field_status->field_errors, $error);
            $form_field_status->field_status_is_OK = $form_is_OK;

            array_push($this->form_fields_status_objects, $form_field_status);

        }

    }

    public function get_all_field_errors () {
        $all_errors = array();
        foreach ($this->form_fields_status_objects as $form_field_status) {
            if (!empty($form_field_status->field_errors)) {
                foreach ($form_field_status->field_errors as $field_error)
                array_push($all_errors, $field_error);
            }
        }
        return $all_errors;
    }

    public function get_form_field_errors ($form_field_name) {
        foreach ($this->form_fields_status_objects as $form_field_status) {

            if ($form_field_status->field_name == $form_field_name) {
                return $form_field_status->field_errors;
            }
        }
        return array();
    }

    public function get_form_field_status ($form_field_name) {
        /*
         * Go over all form field statuses and if the provided field name match
         * return its status.
         * Else if an error object for this form field is not created return true which means OK.
         */

        foreach ($this->form_fields_status_objects as $form_field_status) {

            if ($form_field_status->field_name == $form_field_name) {
                $a = $form_field_status->field_status_is_OK;
                return $a;
            }
        }

        return true;
    }
}

class form_field_status {
    public $field_name;
    public $field_status_is_OK;
    public $field_errors = array();
}

?>