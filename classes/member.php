<?php

class Member extends Record {
	public $id;
	public $lastname, $firstname, $birth_date, $address, $po_town;
	public $home_phone, $work_phone, $mobile_phone, $fax_phone, $comments;
	public $member_ref, $email, $newsletter, $other_members;
	public $deposit, $deposit_expiration_date;

	public $family_links;

	public $subscriptions, $loans;

	public $table = "members";

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

    public static function fetch($id) {
        // SQL SELECT members
        $sql = "SELECT id, firstname, lastname, birth_date, address, po_town,
            home_phone, work_phone, mobile_phone, fax_phone, comments, member_ref,
            email, newsletter, other_members, deposit, deposit_expiration_date,
			DATEDIFF(deposit_expiration_date, curdate()) as remaining_deposit_days,
			CONCAT(lastname, ' ', firstname) AS full_name
            FROM members
            WHERE id = ".$id;
        $GLOBALS["data"]->select($sql, $member, "Member");
        return $member;
    }

	public static function fetch_birthdays() {
		// from http://stackoverflow.com/a/28000048/1191256 - give credit where credit is due
		// SQL SELECT members family_members
		$sql = "SELECT CONCAT ( firstname, ' ', lastname, '(', YEAR(CURDATE())-YEAR(birth_date), ') ') AS title,
				DATE_ADD(
					birth_date, 
					INTERVAL YEAR(CURDATE())-YEAR(birth_date) YEAR
				) AS `date`,
				'true' AS `badge`
			FROM members 
			WHERE 
				`birth_date` IS NOT NULL
			HAVING 
				`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(CURDATE())
			UNION
			SELECT CONCAT ( firstname, ' ', lastname, '(', YEAR(CURDATE())-YEAR(birth_date), ') ') AS title,
				DATE_ADD(
					birth_date, 
					INTERVAL YEAR(CURDATE())-YEAR(birth_date) YEAR
				) AS `date`,
				'true' AS `badge`
			FROM family_members 
			WHERE 
				`birth_date` IS NOT NULL
			HAVING 
				`date` BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(CURDATE())
			ORDER BY `date`";
        $GLOBALS["data"]->select($sql, $rset);
		return $rset;
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

	public function has_valid_subscription() {
		$cr = false;
		if(sizeof($this->subscriptions)) {
			while(list($key, $val) = each($this->subscriptions)) {
				if($val->remaining_days > 0) {
					$cr = true;
				}
			}	
			reset($this->subscriptions);
		}
		if($this->deposit) {
			if($this->remaining_deposit_days < 0) {
				$cr = false;
			}
		} else {
			$cr = false;
		}
		return $cr;
	}

	public function create_loan() {
		$loan = new Loan();
		// ajust the end_date to be 21 days after if end_date == start_date
		if($_REQUEST["end_date"] == $_REQUEST["start_date"]) {
			$date = DateTime::createFromFormat ('d-m-Y', $_REQUEST["start_date"]);
			$date->add(new DateInterval('P21D'));
			$_REQUEST["end_date"] = $date->format('d-m-Y');
		}
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
			$not_back += ($val->is_back ? 0 : 1);
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

	public static function fetch_last(&$members) {
		$members = array();
        // SQL SELECT members
        $sql = "SELECT id, po_town, CONCAT(firstname, ' ', lastname) AS full_name
            FROM members
            ORDER BY created_at DESC
			LIMIT 0,10"; 
        $GLOBALS["data"]->select($sql, $members, "Member");
        return sizeof($members);
	}
}

?>
