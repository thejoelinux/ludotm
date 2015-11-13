<?php

class Payment_Method extends Record {
	public $id, $name, $description;

	public $table = "payment_methods";

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

