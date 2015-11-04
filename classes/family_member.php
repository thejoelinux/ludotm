<?php

class Family_Member {
	public $id, $id_adherent, $firstname, $lastname, $birthdate, $link_id, $link_name;

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
		$this->link_name = Member::get_family_link_name($this->link_id);
	}

	public static function fetch_all(&$family_members, $member_id) {
        $family_members = array();
		// SQL SELECT family_members
        $sql = " SELECT id, firstname, lastname, birthdate, link_id
            FROM family_members
            WHERE id_adherent = ".$member_id;
        $GLOBALS["data"]->select($sql, $family_members, "Family_Member", true);
        return sizeof($family_members);
    }

	public static function delete($id) {
		// SQL SELECT family_members
		$sql = " SELECT id_adherent
			FROM family_members
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			// SQL DELETE family_members
			$sql = " DELETE FROM family_members
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id_adherent");
		}
		return false;
	}

	public function create($firstname, $lastname, $birthdate, $link_id) {
		// date transformation from displayable to database
		$birthdate = date_format(date_create_from_format('d-m-Y', $birthdate),'Y-m-d');
		// SQL INSERT family_members
		$sql = " INSERT INTO family_members (firstname, lastname, birthdate, 
						link_id, id_adherent)
				VALUES ('".$firstname."', '".$lastname."', '".$birthdate."',
					'".$link_id."', ".$_REQUEST["i"].")";
		return $this->id = $GLOBALS["data"]->insert($sql);
	}
}
?>
