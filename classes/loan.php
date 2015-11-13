<?php

class Loan extends Record {
	public $id, $game_id, $member_id;
	public $start_date, $end_date, $is_back;
	public $created_at, $updated_at;

	public $member_name, $is_late;

	public $table = "loans";

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$loans, $member_id) {
        $loans = array();
		// SQL SELECT loans games
        $sql = " SELECT l.id, start_date, end_date, is_back, l.created_at, l.updated_at,
					g.name as game_name, CASE WHEN (end_date < curdate() AND is_back = 0) THEN 1 ELSE 0 END AS is_late
            FROM loans l, games g
            WHERE member_id = ".$member_id."
				AND g.id = l.game_id
				ORDER BY is_back ASC, start_date DESC
				";
        $GLOBALS["data"]->select($sql, $loans, "Loan", true);
        return sizeof($loans);
    }

	public static function fetch($id) {
		// SQL SELECT loans
		$sql = " SELECT l.id, start_date, end_date, is_back, l.created_at, l.updated_at, member_id,
					g.name as game_name
            FROM loans l, games g
            WHERE l.id = $id
			AND  g.id = l.game_id";
		$GLOBALS["data"]->select($sql, $loan, "Loan");
		return $loan;
	}

	public static function delete($id) {
		// SQL SELECT loans
		$sql = " SELECT id
			FROM loans
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE loans
			$sql = " DELETE FROM loans
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id");
		}
		return false;
	}

	function change_state($new_state) {
		// SQL UPDATE loans
		$sql = " UPDATE loans SET is_back = ".$new_state.",
					updated_at = now()
				WHERE id = ".$this->id;
       	return $GLOBALS["data"]->update($sql);
	}
}

?>
