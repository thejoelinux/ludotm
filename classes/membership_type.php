<?php

class Membership_Type extends Record {
	public $id, $name, $description, $price;

	public $table = "membership_types";

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$membership_types) {
        $membership_types = array();
		// FIXME : this request should include the number of current membership for
		// every type. It could be an indication of wether you could delete it or not.
		// SQL SELECT membership_types
        $sql = "SELECT id, name, description, price
            FROM membership_types
            ORDER BY name"; 
        $GLOBALS["data"]->select($sql, $membership_types, "Membership_Type");
        return sizeof($membership_types);
    }

	public static function fetch($id) {
        // SQL SELECT membership_types
        $sql = "SELECT id, name, description, price
            FROM membership_types
            WHERE id = ".$id;
        $GLOBALS["data"]->select($sql, $membership_type, "Membership_Type");
        return $membership_type;
    }

	public static function delete($id) {
		// SQL SELECT membership_types
		$sql = " SELECT id
			FROM membership_types
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE membership_types
			$sql = " DELETE FROM membership_types
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id");
		}
		return false;
	}
}

