<?php

class Loan {
	public $id, $game_id, $member_id;
	public $start_date, $end_date, $is_back;
	public $created_at, $updated_at;

	public $member_name, $is_late;

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
		// SQL INSERT loans
		$sql = " INSERT INTO loans (".$fields_sql." created_at, updated_at)
			VALUES (".$datas_sql." now(), now())";
		return $this->id = $GLOBALS["data"]->insert($sql);
	}

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(!is_array($this->$var) && array_key_exists($var, $_REQUEST)) {
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
			// SQL UPDATE loans
			$sql = " UPDATE loans SET ".$update_sql." updated_at = now()
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
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
