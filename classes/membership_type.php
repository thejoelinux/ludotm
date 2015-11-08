<?php

class Membership_Type {
	public $id, $name, $description, $price;

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

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(array_key_exists($var, $_REQUEST)) {
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE membership_types
			$sql = " UPDATE membership_types SET ".substr($update_sql, 0, -1)."
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
	}

	public function create() {
		$fields_sql = $datas_sql = "";
		foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value is not empty
			if(array_key_exists($var, $_REQUEST) && $_REQUEST[$var] != "") {
				$this->$var = $_REQUEST[$var];
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
			}
		}
		// SQL INSERT membership_types
		$sql = " INSERT INTO membership_types (".substr($fields_sql, 0, -1).")
			VALUES (".substr($datas_sql, 0, -1).")";
		return $this->id = $GLOBALS["data"]->insert($sql);	
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

