<?php

class Subscription extends Record {
	public $id, $start_date, $end_date, $member_id, $member_name, $membership_type_id, $payment_method_id;
	public $price, $credit, $comments, $created_at, $updated_at;

	public $table = "subscriptions";

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public function text(){
        return "Du ".
            date_format(date_create_from_format('Y-m-d',$this->start_date), 'd/m/Y').
            " au ".
            date_format(date_create_from_format('Y-m-d',$this->end_date), 'd/m/Y');
	}

	public static function fetch($id) {
		// SQL SELECT subscriptions membership_types payment_methods
        $sql = " SELECT ms.id, start_date, end_date, ms.member_id, CONCAT(a.lastname, ' ', a.firstname) as member_name,
				ms.membership_type_id, mt.name as membership_type_name,
				ms.payment_method_id, pm.name as payment_method_name,
				ms.price, credit, ms.comments, ms.created_at, ms.updated_at,
				DATEDIFF(end_date, curdate()) as remaining_days
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
				ms.price, credit, ms.comments, ms.created_at, ms.updated_at,
				DATEDIFF(end_date, curdate()) as remaining_days
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
	
}

?>
