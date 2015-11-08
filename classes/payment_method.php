<?php

class Payment_Method {
	public $id, $name, $description;

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$payment_methods) {
        $payment_methods = array();
		// SQL SELECT payment_methods
        $sql = "SELECT id, name, description
            FROM payment_methods
            ORDER BY name"; 
        $GLOBALS["data"]->select($sql, $payment_methods, "Payment_Method");
        return sizeof($payment_methods);
    }

	public static function fetch($id) {
        // SQL SELECT payment_methods
        $sql = "SELECT id, name, description
            FROM payment_methods
            WHERE id = ".$id;
        $GLOBALS["data"]->select($sql, $payment_method, "Payment_Method");
        return $payment_method;
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
			// SQL UPDATE payment_methods
			$sql = " UPDATE payment_methods SET ".substr($update_sql, 0, -1)."
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
		// SQL INSERT payment_methods
		$sql = " INSERT INTO payment_methods (".substr($fields_sql, 0, -1).")
			VALUES (".substr($datas_sql, 0, -1).")";
		return $this->id = $GLOBALS["data"]->insert($sql);	
	}

	public static function delete($id) {
		// SQL SELECT payment_methods
		$sql = " SELECT id
			FROM payment_methods
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE payment_methods
			$sql = " DELETE FROM payment_methods
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id");
		}
		return false;
	}
}

