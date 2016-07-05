<?php

class PHPProject_Database_Table_RowObject extends PHPProject_Object {

    public function __construct(array $data = array(), $params = null) {
        parent::__construct($data, $params);
    }

    // Save a single row in a database
    public function save() {

        $return_message = new PHPProject_ReturnMessage(array(
            'success' => true,
            'message' => ""
        ));

        //Store the values for sql statement
        $valuesArray = array();

        // Start of the query.
        $query = "INSERT INTO ". $this->get_table_name() . " (";

        // Adding in keys, storing values
        foreach ($this->to_array() as $key => $value) {
          $query .= mysql_real_escape_string($key);
          $query .= ",";
          if($key == 'password') {
            $value = md5($value);
          }
          $valuesArray[] = mysql_real_escape_string($value);
        }

        // Getting rid of some dirt, adding some, and adding in values
        $query = substr_replace($query, "", -1);
        $query .= ") VALUES ('";
        $query .= implode($valuesArray, "','");
        $query .= "');";

        // The actual insert statement, in either case, a returnmessage is returned
        if(!mysql_query($query)){
              $return_message->success = false;
              $return_message->message = "Computer says no.";
        }

        return $return_message;
    }


    // TODO transform uppercase->underscore separated words.
    public function get_table_name() {
        $extracted_table_name = get_class($this);
        $extracted_table_name = trim($extracted_table_name, "_Object");
        $extracted_table_name .= "s";
        return strtolower($extracted_table_name);
    }


}
