<?php
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/defines/sql_defs.php";
include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";

/* Class for creating db and manipulating databases*/
class Database {

    /*
     * OBJECT VARS
     */
    public $last_query;

    protected $db_connection;
    protected $id;

    /*
     * METHODS
     */
    public function __construct()
    {
        $this->open_connection();
    }

    public function __destruct()
    {
        $this->close_connection();
    }

    protected function open_connection(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME_USERS);

        if($this->db_connection->connect_errno){
            die("Database connection failed - " . $this->db_con->connect_error . "(" . mysqli_connect_errno() . ")");
        }
    }

    /*
     * Closes connection
     * Not really important!
     * SQL will be closed practically either way.
     */
    protected function close_connection(){

        if(isset($this->db_connection)){
            mysqli_close($this->db_connection);
            unset($this->db_connection);
        }
    }


    /*
     * { Basic query methods
     */
    /*
     * First line of protection for MSQL injection.
     * Escapes special characters in a string for use in an SQL statement
     */
    protected function mysql_prep_value($data) {
        return mysqli_real_escape_string($this->db_connection, $data);
    }

    /*
     * MAIN QUERY FUNCTION
     */
    protected function run_query($sql) {
        $this->last_query = $sql;

        $result = mysqli_query($this->db_connection, $sql);

        /*
         * DIE IF ERROR
         */
        $this->confirm_query($result);

        return $result;
    }

    protected function confirm_query ($query_returned_value) {
        /*
         * For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries, mysqli_query() will return a mysqli_result object.
         * For other successful queries mysqli_query() will return TRUE.
         * Both cases are checked with the following IF statement
         */
        if(!$query_returned_value) {

            $output = "Database query failed" . mysqli_error($this->db_connection);
            $output .= "<br />";
            $output .= "Last query is  " . $this->last_query;

            die($output);
        }
    }
    /*
     * } Basic query methods
     */


    /*
     * PUBLIC METHODS
     */

    /*
     * { Query information
     */
    protected function get_last_record_id() {
        return $this->db_connection->insert_id;
    }
    protected function get_nof_affected_rows() {
        return mysqli_affected_rows($this->db_connection);
    }
    /*
     * } Query information
     */
    /*
     * { Methods intended to be inherited
     */

    public function create() {
        /*
         * Get the relevant reference to one of the globally defined DBs
         */
        $db = static::$current_db;
        global $$db;
        $DB = $$db;

        $current_child_table_name = static::$table_name;
        $table_columns_array = self::get_table_columns();

        /*
        * { - Create query - end
        */
        $query  = "INSERT into ";
        $query .= $current_child_table_name . " ( ";

        $table_columns_str = implode(", ", $table_columns_array);
        $query .= "{$table_columns_str}) ";
        $query .= "VALUES (";

        // Create Values string
        $values_str_arr = array();
        $arr_idx = 0;
        foreach ($table_columns_array as $table_column) {

            $table_column_value = $DB->mysql_prep_value($this->$table_column);

            if (is_string($table_column_value)){
                $values_str_arr[$arr_idx] = "'{$table_column_value}'";
            } else {
                $values_str_arr[$arr_idx] = $table_column_value;
            }
            $arr_idx ++;
        }
        $values_str = implode(", ",$values_str_arr);

        $query .= "{$values_str}) ";

        /*
        * } - Create query - end
        */
        if($DB->run_query($query)) {
            $this->id = $DB->get_last_record_id();
        } else {
            return false;
        }
    }

    public function update() {
        /*
         * Get the relevant reference to one of the globally defined DBs
         */
        $db = static::$current_db;
        global $$db;
        $DB = $$db;

        $current_child_table_name = static::$table_name;
        $table_columns_array = self::get_table_columns();
        /*
        * { - Create query - end
        */
        $query  = "UPDATE {$current_child_table_name} SET ";

        $values_str_arr = array();

        $arr_idx = 0;
        foreach ($table_columns_array as $table_column) {

            $values_str_arr[$arr_idx] = "{$table_column} = ";
            if (is_string($this->$table_column)){
                $values_str_arr[$arr_idx] .= "'{$this->$table_column}'";
            } else {
                $values_str_arr[$arr_idx] .= $this->$table_column;
            }
            $arr_idx++;
        }

        print_r($values_str_arr);

        // Create update values string
        $values_str = implode(", ",$values_str_arr);

        $query .= "{$values_str} ";

        $query .= "WHERE id = {$this->id}";

        echo $query;

        /*
        * } - Create query - end
        */

        $DB->run_query($query);

        if ($DB->get_nof_affected_rows() == 1){
            return true;
        } else {
            return false;
        }

    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function delete() {
        /*
         * Get the relevant reference to one of the globally defined DBs
         */
        $db = static::$current_db;
        global $$db;
        $DB = $$db;

        $current_child_table_name = static::$table_name;

        /*
        * { - Create query - end
        */
        $query  = "DELETE FROM ";
        $query .= $current_child_table_name . " ";
        $query .= "WHERE id=" . $DB->mysql_prep_value($this->id) . " ";
        $query .= "LIMIT 1";

        /*
        * } - Create query - end
        */
        if($DB->run_query($query)) {
            br();
            echo "User with id" . $this->id . "was successfully deleted";
        } else {
            return false;
        }
    }

    /*
     * MAIN METHOD for query
     *  Will return array of objects for each database table row which the query will return.
     */
    public static function get_by_sql($sql) {
        /*
         * Get the relevant reference to one of the globally defined DBs
         */
        $db = static::$current_db;
        global $$db;
        $DB = $$db;
        $object_array = array();

        $result = $DB->run_query($sql);

        while($row = $result->fetch_assoc()){
            $object_array[] = static::instantiate($row);
        }

        return $object_array;
    }

    public static function get_all() {
        $result_array = static::get_by_sql("SELECT * FROM " . static::$table_name);

        return $result_array;
    }

    public static function get_by_id($id) {

        $result_array = static::get_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id};");

        return !empty($result_array) ? array_shift($result_array) : false;
    }

    /*
     * { Methods to give MISC table information
     */

    public static function get_table_columns()
    {
        /*
         * Get the relevant reference to one of the globally defined DBs
         */
        $db = static::$current_db;
        global $$db;
        $DB = $$db;

        $table_columns_array = array();
        $result = $DB->run_query("SHOW COLUMNS FROM " . static::$table_name);

        while($column_info = $result->fetch_assoc()){
            // Escape the user_id Key field
            if ($column_info['Key'] != '') continue;

            array_push($table_columns_array, $column_info['Field']);

        }
        return $table_columns_array;
    }

    public static function instantiate($table_record) {
        $object_name = get_called_class();

        $object = new $object_name;
        $object_properties  = get_object_vars( $object );
        /*
         * Try to populate the all of the object properties
         * Using the table record provided
         */
        foreach ($table_record as $field=>$field_value) {
            if (array_key_exists($field, $object_properties )){
                $object->$field= $field_value;
            }
        }

        /*
         * FIX ME - See what merit is to actually add last_query value also here.
         */

        return $object;

    }

    public static function instantiate_from_post_variables() {

        $object_name = get_called_class();
        $object = new $object_name;
        $object_properties  = get_object_vars( $object );

        /*
         * Try to populate the all of the object properties
         * Using the table record provided
         */
        foreach($object_properties as $object_property=>$object_property_value) {
            if(isset($_POST[$object_property])) {
                $object->$object_property= $_POST[$object_property];
            }
        }

        return $object;

    }

    public static function update_from_post_variables($object) {

        $object_properties  = get_object_vars( $object );

        /*
         * Try to populate the all of the object properties
         * Using the table record provided
         */
        foreach($object_properties as $object_property=>$object_property_value) {
            if(isset($_POST[$object_property])) {
                $object->$object_property= $_POST[$object_property];
            }
        }

        return $object;

    }
    /*
     * } Methods to give MISC table information
     */
}



?>
