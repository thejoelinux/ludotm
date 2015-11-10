<?php

class Subscription {
	public $id, $start_date, $end_date, $member_id, $member_name, $membership_type_id, $payment_method_id;
	public $price, $credit, $comments, $created_at, $updated_at;

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public function text(){
		return "Du ".$this->start_date." au ".$this->end_date;
	}

	public static function fetch($id) {
		// SQL SELECT subscriptions membership_types payment_methods
        $sql = " SELECT ms.id, start_date, end_date, ms.member_id, CONCAT(a.lastname, ' ', a.firstname) as member_name,
				ms.membership_type_id, mt.name as membership_type_name,
				ms.payment_method_id, pm.name as payment_method_name,
				ms.price, credit, ms.comments, ms.created_at, ms.updated_at
            FROM subscriptions ms, adherent a, membership_types mt, payment_methods pm
            WHERE ms.id = ".$id."
				AND ms.member_id = a.id
				AND ms.membership_type_id = mt.id
				AND ms.payment_method_id = pm.id
				";
        $GLOBALS["data"]->select($sql, $subscription, "Subscription");
		return $subscription;
	}

	public static function fetch_all(&$subscriptions, $member_id) {
        $subscriptions = array();
		// SQL SELECT subscriptions adherent membership_types payment_methods
        $sql = " SELECT ms.id, start_date, end_date, ms.member_id, CONCAT(m.lastname, ' ', m.firstname) as member_name,
				ms.membership_type_id, mt.name as membership_type_name,
				ms.payment_method_id, pm.name as payment_method_name,
				ms.price, credit, ms.comments, ms.created_at, ms.updated_at
            FROM subscriptions ms, members m, membership_types mt, payment_methods pm
            WHERE member_id = ".$member_id."
				AND ms.member_id = m.id
				AND ms.membership_type_id = mt.id
				AND ms.payment_method_id = pm.id
				ORDER BY end_date
				";
        $GLOBALS["data"]->select($sql, $subscriptions, "Subscription", true);
        return sizeof($subscriptions);
    }

	public static function delete($id) {
		// SQL SELECT subscriptions
		$sql = " SELECT id
			FROM subscriptions
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE subscription
			$sql = " DELETE FROM subscriptions
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id");
		}
		return false;
	}

	public function create() {
		$fields_sql = $datas_sql = "";
		foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value is not empty
			if(array_key_exists($var, $_REQUEST) && $_REQUEST[$var] != "") {
				if($var == "start_date" || $var == "end_date") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				$this->$var = $_REQUEST[$var];
				if($var == "start_date" || $var == "end_date") {
					$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
				}
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
			}
		}
		// SQL INSERT subscriptions
		$sql = " INSERT INTO subscriptions (".$fields_sql." created_at, updated_at)
			VALUES (".$datas_sql." now(), now())";
		return $this->id = $GLOBALS["data"]->insert($sql);
	}

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(array_key_exists($var, $_REQUEST)) {
				if($var == "start_date" || $var == "end_date") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if($var == "start_date" || $var == "end_date") {
						$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE subscriptions
			$sql = " UPDATE subscriptions SET ".$update_sql." updated_at = now()
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
	}

}

?>
