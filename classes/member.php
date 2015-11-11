<?php

class Member {
	public $id;
	public $lastname, $firstname, $subscribe_date, $birth_date, $address, $po_town;
	public $home_phone, $work_phone, $mobile_phone, $fax_phone, $comments;
	public $member_ref, $membership_type_id, $subscription_label, $email, $newsletter, $other_members, $deposit;

	public $family_links;

	public $subscriptions, $loans;

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
		$this->family_links = array(
			1 => "Enfant",
			2 => "Conjoint",
			3 => "Autre");
		$this->subscriptions = array();
		$this->loans = array();
	}

	public static function get_family_link_name($id = 0) {
		$family_links = array(
			1 => "Enfant",
			2 => "Conjoint",
			3 => "Autre");
		if(array_key_exists($id, $family_links)) {
			return $family_links[$id];
		} else {
			return false;
		}
	}

	public function create() {
		$fields_sql = $datas_sql = "";
		foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value is not empty
			if(array_key_exists($var, $_REQUEST) && $_REQUEST[$var] != "") {
				if($var == "birth_date" || $var == "date_inscription") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				$this->$var = $_REQUEST[$var];
				if($var == "birth_date" || $var == "date_inscription") {
					$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
				}
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
			}
		}
		// SQL INSERT members
		$sql = " INSERT INTO members (".substr($fields_sql, 0, -1).")
			VALUES (".substr($datas_sql, 0, -1).")";
		return $this->id = $GLOBALS["data"]->insert($sql);	
	}

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(!is_array($this->$var) && array_key_exists($var, $_REQUEST)) {
				if($var == "birth_date" || $var == "date_inscription") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if($var == "birth_date" || $var == "date_inscription") {
						$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE members
			$sql = " UPDATE members SET ".substr($update_sql, 0, -1)."
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
	}

    public static function fetch($id) {
        // SQL SELECT members
        $sql = "SELECT id, firstname, lastname, subscribe_date, birth_date, address, po_town,
            home_phone, work_phone, mobile_phone, fax_phone, comments, member_ref, membership_type_id,
            subscription_label, email, newsletter, other_members, deposit, CONCAT(lastname, ' ', firstname) AS full_name
            FROM members
            WHERE id = ".$id;
        $GLOBALS["data"]->select($sql, $member, "Member");
        return $member;
    }

	public function fetch_subscriptions() {
		Subscription::fetch_all($this->subscriptions, $this->id);
	}

	public function create_subscription() {
		$subscription = new Subscription();
		$subscription->create();
	}

	public function update_subscription() {
		$subscription = Subscription::fetch($GLOBALS["data"]->db_escape_string($_REQUEST["i"]));
		$subscription->update();
	}

	public function fetch_loans() {
		Loan::fetch_all($this->loans, $this->id);
	}

	public function create_loan() {
		$loan = new Loan();
		$loan->create();
	}

	public function update_loan() {
		$loan = Loan::fetch($GLOBALS["data"]->db_escape_string($_REQUEST["i"]));
		$loan->update();
	}

	public function loans_text() {
		// count in loans the games not restitued and/or late
		$not_back = $late = 0;
		while(list($key, $val) = each($this->loans)) {
			$not_back += $val->is_back;
			$late += $val->is_late;
		}

		if ($not_back > 0) {
			$msg = $not_back." jeu(x)";
			if($late > 0) {
				$msg .= " dont ".$late." en retard.";
			}
		} else {
			$msg = "Pas d'emprunt en cours.";
		}
		return $msg;
	}

    public function render_json() {
        echo json_encode($this);
    }

    public static function fetch_all(&$members) {
        $members = array();
        // SQL SELECT members
        $sql = "SELECT id, lastname, firstname, po_town, CONCAT(firstname, ' ', lastname) AS full_name
            FROM members
            ORDER BY lastname"; 
        $GLOBALS["data"]->select($sql, $members, "Member");
        return sizeof($members);
    }
}

?>
