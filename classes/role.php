<?php

class Role extends Record {
	public $id;
	public $name, $description;

	public $table = "roles";

	public function __construct($id = 0) {
		if (!$this->id) {
			$this->id = $id;
		}
	}

    public static function fetch_user_roles($user_id) {
		$roles = array();
        // SQL SELECT roles user_roles
        $sql = "SELECT r.id, r.name, r.description
            FROM roles r, user_roles ur
            WHERE r.id = ur.role_id
				AND ur.user_id = ".$user_id;
        $GLOBALS["data"]->select($sql, $roles, "Role");
        return $roles;
    }
}
