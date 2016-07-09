<?php

class PHPProject_Database_Table  {
    public $table_name;
    public $primary_key = 'id';
    protected $_object_class;
    protected $_set_class;
    
    
    const DEFAULT_PAGE_SIZE = 10;
    
    public function __construct() {
        $this->table_name = $this->_get_table_name();
    }
    
    public function get_all_rows() {
        $query = "SELECT * FROM `$this->table_name`";
        $rows = $this->set_query($query);
        
        return $rows;
    }
    
    public function get_page($page_number, $page_size = Self::DEFAULT_PAGE_SIZE) {
        
    }
    
    public function object_query($query) {
        $result = mysql_query($query);
        $row = new $_object_class(mysql_fetch_assoc($result));
        return $row;
    }
    
    public function set_query($query) {
        $result = mysql_query($query);
        $row = new $_set_class(mysql_fetch_assoc($result));
        return $rows;
    }
    
    public function find($id){
        try {
            $id = (int)$id;
            $query = "SELECT * FROM `$this->table_name` WHERE `$this->primary_key` = $id";
            $row = $this->object_query($query);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $row;
    }
    
    public function get_online_users() {
        $query = "SELECT * FROM `$this->table_name` WHERE `is_online` = 1;";
        $select = mysql_query($query);
        
        $return_online_users = array();
        
        while ($rows = mysql_fetch_assoc($select)) {
            $return_online_users[] = $rows;
        }
        
        return $return_online_users;
    }
        
    public function find_max($column_name='id') {
        $select = "SELECT MAX(" . $column_name . ") FROM " . $this->_get_table_name() .";";
        $return = mysql_fetch_assoc(mysql_query($select));
        return (int) $return['MAX(id)'];
    }
    
    public function create($data = array()) {
        $return = false;
        $insert = "INSERT INTO `$this->table_name` ";
        $values = "VALUES (";
        $fields = "(";
        $length = count($data) - 1;
        foreach($data as $key => $value) {
            $value = mysql_real_escape_string($value);
            $fields .= $key;                       
            $values .= "'".$value."'"; 
            if($length){
                $values .= ",";
                $fields .= ",";
                $length--;
            }
        }
        $values .= ")";
        $fields .= ")";
        $insert .= $fields . ' ' . $values;
        echo $insert;
        $result = mysql_query($insert);
        var_dump($result);
        try {
        if ($result) {
            $id = mysql_insert_id();
            var_dump($id);
            if (!$id) {
                $return = false;
            } else {
                $return = $this->find($id);
            }
            
            var_dump($return);
        }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        return $return;
    }
    
    protected function _get_table_name() {
        $extract_table_name = get_class($this);
        $extract_table_name = trim($extract_table_name, "_Object");
        $extracted_table_name = preg_replace('/\B([A-Z])/', '_$1', $extract_table_name);
        return strtolower($extracted_table_name);
    }
    
    protected function _get_set_name() {
        
    }
    protected function _get_object_name() {
        
    }
}
