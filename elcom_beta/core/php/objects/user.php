<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/5/2017
 * Time: 5:45 PM
 *
 * Class for the table "users" in the users_register DataBase
 */

class User extends Users_Register_Database
{

    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $email;
    public $is_admin;

    protected static $current_db = "Users_Register_DB";
    protected static $table_name = "users";

    /*
    * { PUBLIC
    */
    public function show_full_name()
    {
        echo $this->first_name . " " . $this->last_name;
    }

    public function create() {

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        parent::create();
    }

    public function update() {
        echo "Received password is $this->password";
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        echo "After hashing password is $this->password";

        parent::update();
    }

    public function validate_user_properties($flags = 0)
    {
        global $Session;
        global $Users_Register_DB;

        /*
        * Get specific rules and save as array
        */
        $result = $Users_Register_DB->run_query("DESCRIBE " . static::$table_name . "");
        for ($fields_info = array (); $row = $result->fetch_assoc(); $fields_info[] = $row);

        $result = $Users_Register_DB->run_query("SELECT * FROM fields_rules_table_" . static::$table_name . " ");
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
                     * Check if object property is empty and IF database table forbids it add an error
                     */
                    preg_match_all('!\d+!', $field_info['Type'], $field_allowed_length);
                    $field_allowed_length = array_shift(array_shift($field_allowed_length));
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
                    if (!($flags & VALIDATE_ONLY_UNIQUE_IS_ID)) {
                        if ($field_specific_rules['is_unique']) {
                            if (is_numeric($this->$object_table_property)) {
                                $condition = "{$object_table_property}={$this->$object_table_property}";
                            } else {
                                $condition = "{$object_table_property}='{$this->$object_table_property}'";
                            }
                            $is_found_other_user = User::get_by_sql("SELECT * FROM " . static::$table_name. " WHERE " . $condition );

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


    public static function get_by_username($username) {

        $result_array = self::get_by_sql("SELECT * FROM " . self::$table_name . " WHERE username='{$username}';");

        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function columns_get_by_username($username, $columns_arr = array()) {
        global $Users_Register_DB;
        /*
        * { - Create query - start
        */
        $query  = "SELECT ";

        if (empty($columns_arr)) {
            $columns = " * ";
        } else {
            $columns = implode(", ",$columns_arr);
        }
        $query .= "{$columns}";
        $query .= " FROM users ";

        if ($username == "*")
        {
            // Do nothing
        } else
        {
            $query .= "WHERE username='{$username}'";
        }

        /*
        * } - Create query - end
        */
        $selected_user_row = $Users_Register_DB->run_query($query);

        if ($selected_user_row->num_rows == 0) {
            /*
             * Go to the referring page
             */
            redirect_to($_SERVER['HTTP_REFERER']);
        } else {
            return $selected_user_row->fetch_assoc();
        }

    }

    public static function authenticate($username, $password) {
        global $Users_Register_DB;

        $username = $Users_Register_DB->mysql_prep_value($username);
        $password = $Users_Register_DB->mysql_prep_value($password);

        /*
         * Get hashed password from the database
         */
        $user_found = self::get_by_username($username);

        // Check password

        if ($user_found) {
            if (password_verify($password, $user_found->password)) {

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }


    }

    /*
    * } STATIC
    */

    /*
    * { SESSION
    */


    /*
    * } SESSION
    */

}
