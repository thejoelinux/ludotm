<?php

class User extends Record {
	public $id;
	public $name, $password_digest, $email, $active;

	public $alert_msg = "";

	public $roles;

	public $table = "users";

	public function __construct($id = 0) {
		if (!$this->id) {
			$this->id = $id;
		}
		$this->roles = array();
	}

    public static function fetch($id) {
        // SQL SELECT users
        $sql = "SELECT id, name, password_digest, email, active
            FROM users
            WHERE id = ".$id;
        $GLOBALS["data"]->select($sql, $user, "User");
		if($user->id != 0) {
			$user->roles = Role::fetch_user_roles($user->id);
		}
        return $user;
    }

	public static function fetch_all(&$users) {
        $users = array();
        // SQL SELECT users
        $sql = "SELECT id, name, email, active,
				created_at, updated_at
            FROM users
            ORDER BY name"; 
        $GLOBALS["data"]->select($sql, $users, "User", true);
        return sizeof($users);
    }

	public static function validate($name, $password) {
		// SQL SELECT users
		$sql = "SELECT id, name, email, active
			FROM users
			WHERE name = '".$name."'
				AND password_digest = '".crypt($name, $password)."'";
		$GLOBALS["data"]->select($sql, $user, "User");
		if($user->id == 0) {
			$user = new User(0);
			$user->alert_msg = "Echec de l'authentification";
		} else {
			$user->roles = Role::fetch($user->id);
		}
		return $user;
	}

	public static function fetch_by_name($user) {
        // SQL SELECT users
        $sql = "SELECT id, name, password_digest, email, active
            FROM users
			WHERE name = '".$user."'";
        $GLOBALS["data"]->select($sql, $users, "User");
        return sizeof($users);
	}

	public function has_role($role_name) {
		while(list($key, $val) = each($this->roles)) {
			if($val->name == $role_name) {
				reset($this->roles);
				return true;
			}
		}
		reset($this->roles);
		return false;
	}
}

?>
