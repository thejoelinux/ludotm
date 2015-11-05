<?php

class Member {
	public $id_adherent;
	public $nom, $prenom, $date_inscription, $date_naissance, $adresse, $cp_ville;
	public $tel_maison, $tel_travail, $tel_mobile, $tel_fax, $commentaire;
	public $num_adherent, $membership_type_id, $adhesion, $email, $newsletter, $autres, $caution;

	public $family_links;

	public function __construct($id = 0) {
    	if (!$this->id_adherent) {
			$this->id_adherent = $id;
	    }
		$this->family_links = array(
			1 => "Enfant",
			2 => "Conjoint",
			3 => "Autre");
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
				if($var == "date_naissance" || $var == "date_inscription") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				$this->$var = $_REQUEST[$var];
				if($var == "date_naissance" || $var == "date_inscription") {
					$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
				}
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
			}
		}
		// SQL INSERT adherent
		$sql = " INSERT INTO adherent (".substr($fields_sql, 0, -1).")
			VALUES (".substr($datas_sql, 0, -1).")";
		return $this->id_adherent = $GLOBALS["data"]->insert($sql);	
	}

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(array_key_exists($var, $_REQUEST)) {
				if($var == "date_naissance" || $var == "date_inscription") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if($var == "date_naissance" || $var == "date_inscription") {
						$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE adherent
			$sql = " UPDATE adherent SET ".substr($update_sql, 0, -1)."
				WHERE id_adherent = ".$this->id_adherent;
        	return $GLOBALS["data"]->update($sql);
		}
	}

    public static function fetch($id) {
        // SQL SELECT adherent
        $sql = "SELECT id_adherent, nom, prenom, date_inscription, date_naissance, adresse, cp_ville,
            tel_maison, tel_travail, tel_mobile, tel_fax, commentaire, num_adherent, membership_type_id,
            adhesion, email, newsletter, autres, caution
            FROM adherent
            WHERE id_adherent = ".$id;
        $GLOBALS["data"]->select($sql, $member, "Member");
        return $member;
    }

    public function render_json() {
        echo json_encode($this);
    }

    public static function fetch_all(&$members) {
        $members = array();
        // SQL SELECT adherent
        $sql = "SELECT id_adherent, nom, prenom, cp_ville
            FROM adherent
            ORDER BY nom"; 
        $GLOBALS["data"]->select($sql, $members, "Member");
        return sizeof($members);
    }
}

?>
