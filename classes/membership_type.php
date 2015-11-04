<?php

class Membership_Type {
	public $id, $name, $description;

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$membership_types) {
        $membership_types = array();
        $sql = "SELECT id, name, description
            FROM membership_types
            ORDER BY name"; 
        $GLOBALS["data"]->select($sql, $membership_types, "Membership_Type");
        return sizeof($membership_types);
    }
}

