<?php

class Esar_Category extends Record {
	public $id, $name, $label;

    public $table = "esar_categories";

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$esar_categories, $fields = false) {
        $esar_categories = array();
		// SQL SELECT esar_categories
        $sql = "SELECT id, name, label 
            FROM esar_categories
            ORDER BY label"; 
        $GLOBALS["data"]->select($sql, $esar_categories, "Esar_Category");
        return sizeof($esar_categories);
    }

    public static function fetch($id) {
        // SQL SELECT esar_categories
        $sql = "SELECT id, name, label
            FROM esar_categories
            WHERE id = ".$id;
        $GLOBALS["data"]->select($sql, $esar_category, "Esar_Category");
        return $esar_category;
    }

	public static function delete($id) {
		// SQL SELECT esar_categories
		$sql = " SELECT id
			FROM esar_categories
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE esar_categories
			$sql = " DELETE FROM esar_categories
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id");
		}
		return false;
	}
}
