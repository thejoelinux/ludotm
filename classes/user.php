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
			$user->roles = Role::fetch_user_roles($user->id);
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
				return $val->selected == $this->id;
			}
		}
		reset($this->roles);
		return false;
	}

    public function update_roles() {
        if(!array_key_exists("roles", $_REQUEST) || !is_array($_REQUEST["roles"])) {
            // no roles posted : delete all and return
            // SQL DELETE user_roles
            $sql = " DELETE FROM user_roles WHERE user_id = ".$this->id;
            return $GLOBALS["data"]->delete($sql);
        } else {
            $list_to_delete = "";
            while(list($key, $val) = each($this->roles)) {
                if($val->selected && !in_array($val->name, $_REQUEST["roles"])) {
                    $list_to_delete .= $val->id.",";
                }
            }
            reset($this->roles);
            if($list_to_delete != "") {
                // SQL DELETE user_roles
                $sql = " DELETE FROM user_roles WHERE user_id = ".$this->id.
                       " AND role_id IN ( ".substr($list_to_delete, 0, -1).") ";
                $GLOBALS["data"]->delete($sql);
            }
            $list_to_add = "";
            while(list($key, $val) = each($_REQUEST["roles"])) {
                if(!$this->has_role($val)) {
                    $list_to_add .= "'".$val."',";
                }
            }
            if($list_to_add != "") {
                // SQL INSERT user_roles SELECT roles
                $sql = " INSERT INTO user_roles (user_id, role_id, created_at) 
                    SELECT ".$this->id.", id, now()
                    FROM roles
                    WHERE name IN (".substr($list_to_add, 0, -1).")";
                $GLOBALS["data"]->insert($sql);
            }
        }
        return true;
    }

    function change_state($new_state) {
		// SQL UPDATE users
		$sql = " UPDATE users SET active = ".$new_state.",
					updated_at = now()
				WHERE id = ".$this->id;
       	return $GLOBALS["data"]->update($sql);
	}
}

?>
