<?php

class Esar_Category {
	public $id, $name, $label;

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$esar_categories, $fields = false) {
        $esar_categories = array();
        $sql = "SELECT id, name, label 
            FROM categorie_esar
            ORDER BY label"; 
        $GLOBALS["data"]->select($sql, $esar_categories, "Esar_Category");
        return sizeof($esar_categories);
    }
}
