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
