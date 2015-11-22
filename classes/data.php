<?php
//include("classes/data_exception.php");
//include("classes/rset.php");

class data {

	public $db_name;
    public $db_handle; ///< Resource id of the connexion

    public $sql_error = false;
    public $sql_error_code;
    public $sql_error_message;

    /** Constructor of the data class
     * Make a new data object. Connect only if there's no active connexion
    */
    public function data($db_handle = NULL) {
        if ($db_handle) {
            $this->db_handle = $db_handle;
        } else {
            $this->connect();
        }
    }

    /**
     * Make connection to the database
     * You shouldn't use it alone.
     * @see data
     */
    public function connect () {
        $this->db_handle = mysqli_connect($GLOBALS["db_host"], $GLOBALS["db_user"],
            $GLOBALS["db_passwd"], $GLOBALS["db_name"]);

        if (mysqli_connect_error()) {
            throw new data_exception(
                    mysqli_connect_errno(),
                    mysqli_connect_error(),
                    "Connection");
        }
        $this->db_handle->set_charset("utf8");

        return true;
    }

    public function db_escape_string($string) {
        return mysqli_real_escape_string($this->db_handle, $string);
    }

    /*
     *  Execute a select query
    * @param $query the select sql statement to execute
    * @param $rset
    */
    public function select ($query, &$rset, $object = false, $force_array = false) {

        $conn = "db_handle";
        if (! ($this->db_handle && ($result = $this->$conn->query($query)))) {
            error_log($query);
            throw new data_exception(
                    mysqli_errno($this->$conn),
                    mysqli_error($this->$conn),
                    $query);
        }
		if($object) {
			if(!class_exists($object)) {
				throw new data_exception(
					0,
					"Calling select to object w/ a class <b>$object</b> that doesn't even exists",
					"select (\$query, &\$rset, $object)");
			}
			if($result->num_rows <= 1 && !$force_array) {
				$rset = $result->fetch_object($object);
			} else {
			    $rset = array();
				while ($obj = $result->fetch_object($object)) {
					$rset[] = $obj;
			    }
			}
		} else {
			$rset = new rset(
					mysqli_field_count($this->$conn),
					$result->num_rows
			);
			$rset->raw_content = $result;
			$rset->content[0]  = mysqli_fetch_array($rset->raw_content, MYSQLI_ASSOC);
			$finfo             = $result->fetch_fields();
			foreach ($finfo as $val) {
				$rset->table[] = $val->name;
			}
		}
        return true;
    }

    /*
     * Execute an insert query
     * @param $query the insert sql statement to execute
     * @returns how many rows were affected
     */
    public function insert ($query) {

        if (!$this->db_handle->query($query)) {
            throw new data_exception(
                    mysqli_errno($this->db_handle),
                    mysqli_error($this->db_handle),
                    $query);
        }

        if (!mysqli_affected_rows($this->db_handle)) {
            return false;
        } else {
            return mysqli_insert_id($this->db_handle);
        }
    }

    /**
     * Execute an update query
     * @param $query the update sql statement to execute
     * @returns how many rows were affected
     */
    public function update ($query) {
        if (!$this->db_handle->query($query)) {
            throw new data_exception(
                    mysqli_errno($this->db_handle),
                    mysqli_error($this->db_handle),
                    $query);
        }
        return  mysqli_affected_rows($this->db_handle);
    }

    /**
     * Execute a delete query
     * @param $query the delete sql statement to execute
     * @returns how many rows were deleted
     */
    public function delete ($query) {

        if (!$this->db_handle->query($query)) {
            throw new data_exception(
                    mysqli_errno($this->db_handle),
                    mysqli_error($this->db_handle),
                    $query);
        }

        return mysqli_affected_rows($this->db_handle);
    }

    /**
     * Return the public function now() for the database
     */
    public function get_sysdate_function() {
        return " now() ";
    }
}
