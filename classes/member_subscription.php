<?php

class Member_Subscription {
	public $id, $start_date, $end_date, $member_id, $member_name, $membership_type_id, $payment_method_id;
	public $price, $credit, $comments, $created_at, $updated_at;

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function get_current(&$member_subscription, $member_id) {
		$member_subscription = "Aucune souscription trouvée.";
		// SQL SELECT member_subscriptions membership_types payment_methods
        $sql = " SELECT ms.id, end_date,
					ms.credit, mt.name as membership_type_name
            FROM member_subscriptions ms, membership_types mt
            WHERE member_id = ".$member_id."
				AND ms.membership_type_id = mt.id
				AND end_date > curdate()
				ORDER BY end_date
				LIMIT 0,1";
        $GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
	        return "Souscription de type ".$rset->value("membership_type_name").
				" jusqu'au ".$rset->value("end_date");
		}
		return $member_subscription;
	}

	public static function fetch_all(&$member_subscriptions, $member_id) {
        $member_subscriptions = array();
		// SQL SELECT member_subscriptions adherent membership_types payment_methods
        $sql = " SELECT ms.id, start_date, end_date, ms.member_id, CONCAT(a.nom, ' ', a.prenom) as member_name,
				ms.membership_type_id, mt.name as membership_type_name,
				ms.payment_method_id, ms.name as payment_method_name,
				price, credit, ms.comments, ms.created_at, ms.updated_at
            FROM member_subscriptions ms, adherent a, membership_types mt, payment_methods pm
            WHERE member_id = ".$member_id."
				AND ms.member_id = a.id_adherent
				AND ms.membership_type_id = mt.id
				ANS ms.payment_method_id = pm.id
				";
        $GLOBALS["data"]->select($sql, $member_subscriptions, "Member_Subscription", true);
        return sizeof($member_subscriptions);
    }

	public static function delete($id) {
		// SQL SELECT member_subscriptions
		$sql = " SELECT id
			FROM member_subscriptions
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE member_subscription
			$sql = " DELETE FROM member_subscriptions
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
		// SQL INSERT member_subscriptions
		$sql = " INSERT INTO member_subscriptions (".$fields_sql." created_at, updated_at)
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
			// SQL UPDATE member_subscriptions
			$sql = " UPDATE member_subscriptions SET ".$update_sql." updated_at = now()
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
	}

}

?>
