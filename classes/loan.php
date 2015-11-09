<?php

class Loan {
	public $id_pret, $id_jeu, $id_adherent;
	public $date_pret, $date_retour, $rendu, $reglera;
	public $created_at, $updated_at;

	public $member_name;

	public function __construct($id = 0)
  	{
    	if (!$this->id_pret) {
			$this->id_pret = $id;
	    }
	}

	public static function fetch_all(&$loans, $member_id) {
        $subscriptions = array();
		// SQL SELECT prets jeu
        $sql = " SELECT id_pret, date_pret, date_retour, rendu, p.created_at, p.updated_at,
					g.nom as game_name
            FROM prets p, jeu g
            WHERE id_adherent = ".$member_id."
				AND g.id_jeu = p.id_jeu
				ORDER BY rendu ASC, date_pret DESC
				";
        $GLOBALS["data"]->select($sql, $loans, "Loan", true);
        return sizeof($loans);
    }

	public static function delete($id) {
		// SQL SELECT prets
		$sql = " SELECT id_pret
			FROM prets
			WHERE id_pret = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE prets
			$sql = " DELETE FROM prets
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
				if($var == "date_pret" || $var == "date_retour") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				$this->$var = $_REQUEST[$var];
				if($var == "date_pret" || $var == "date_retour") {
					$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
				}
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
			}
		}
		// SQL INSERT prets
		$sql = " INSERT INTO prets (".$fields_sql." created_at, updated_at)
			VALUES (".$datas_sql." now(), now())";
		return $this->id_pret = $GLOBALS["data"]->insert($sql);
	}

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(array_key_exists($var, $_REQUEST)) {
				if($var == "date_pret" || $var == "date_retour") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if($var == "date_pret" || $var == "date_retour") {
						$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE prets
			$sql = " UPDATE prets SET ".$update_sql." updated_at = now()
				WHERE id_pret = ".$this->id_pret;
        	return $GLOBALS["data"]->update($sql);
		}
	}

}

?>
