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

    /* fetch ALL the roles, with the selected field = user_id if the
     user has the role, NULL otherwise.
     Be sure to use user->has_role to check if a user has a role.
     */
    public static function fetch_user_roles($user_id) {
        $roles = array();
        // SQL SELECT roles user_roles
        $sql = "SELECT r.id, r.name, r.description, ur.user_id AS selected
            FROM roles r
                LEFT OUTER JOIN user_roles ur
                    ON (r.id = ur.role_id AND ur.user_id = ".$user_id.")";
        $GLOBALS["data"]->select($sql, $roles, "Role");
        return $roles;
    }
}
