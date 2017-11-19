<?php
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/* Class for creating db and manipulating databases*/
class Lost_And_Found extends Callouts_Database
{
    public $id;
    public $area;
    public $heading;
    public $description;
    public $creator;

    protected static $current_db = "Callouts_DB";
    protected static $table_name = "lost_and_found";


    public function validate_callout_properties($flags = 0)
    {
        global $Session;
        $db = static::$current_db;
        global $$db;
        $DB = $$db;

        /*
        * Get specific rules and save as array
        */
        $result = $DB->run_query("DESCRIBE " . static::$table_name . "");
        for ($fields_info = array (); $row = $result->fetch_assoc(); $fields_info[] = $row);

        $result = $DB->run_query("SELECT * FROM fields_rules_table_" . static::$table_name . " ");
        for ($fields_specific_rules = array (); $row = $result->fetch_assoc(); $fields_specific_rules[] = $row);

        foreach ($this->get_table_columns() as $object_table_property) {
            /*
             * Search in the field info of the table itself
             * in order to find the column relevant for the current object property
             */
            foreach ($fields_info as $field_info) {
                if ($object_table_property == $field_info['Field']) {

                    /*
                     * Check if object property is empty and IF database table forbids it add an error
                     */
                    if ($field_info['Null'] == 'NO' && empty($this->$object_table_property)) {
                        $Session->add_form_field_error($object_table_property, $object_table_property . " cannot be empty!");
                    }
                    /*
                     * Check if field is not exceeding the max length
                     */
                    if ($field_info['Type'] = "text") {
//                        $field_allowed_length = 65535;
                        $field_allowed_length = 52;
                    } else {
                        preg_match_all('!\d+!', $field_info['Type'], $field_allowed_length);
                        $field_allowed_length = array_shift(array_shift($field_allowed_length));
                    }
                    if (strlen($this->$object_table_property) > $field_allowed_length) {
                        $Session->add_form_field_error($object_table_property, $object_table_property . " can be up to " . $field_allowed_length . " characters long!");
                    }

                    break;
                } else {
                    continue;
                }
            }

            /*
             * Search for specific rules for the current field
             */

            foreach($fields_specific_rules as $field_specific_rules) {
                if ($field_specific_rules['field_name'] == $object_table_property) {

                    if (strlen($this->$object_table_property) < $field_specific_rules['min_nof_characters']) {
                        $Session->add_form_field_error($object_table_property, $object_table_property . " should be at least  " . $field_specific_rules['min_nof_characters'] . " characters long!");
                    }
                    /*
                     * VALIDATE_ONLY_UNIQUE_IS_ID flag is used when updating.
                     * Than we want to avoid this check because we are going
                     * to do an update on an already existing row
                     */
                    if (!($flags & VALIDATE_ONLY_UNIQUE_IS_ID)) {
                        if ($field_specific_rules['is_unique']) {
                            if (is_numeric($this->$object_table_property)) {
                                $condition = "{$object_table_property}={$this->$object_table_property}";
                            } else {
                                $condition = "{$object_table_property}='{$this->$object_table_property}'";
                            }
                            $is_found_other_user = Lost_And_Found::get_by_sql("SELECT * FROM " . static::$table_name. " WHERE " . $condition );

                            if(!empty($is_found_other_user)>0)
                            {
                                $Session->add_form_field_error($object_table_property, " There is already a user with such {$object_table_property}! Please choose other.");
                            }
                        }
                    }

                    if (!empty($field_specific_rules['expected_chars'])) {
                        if (strpos($this->$object_table_property, $field_specific_rules['expected_chars']) == false) {
                            $Session->add_form_field_error($object_table_property, $object_table_property . " not valid  ");
                        }
                    }
                }
            }

        }

    }

}
?>
