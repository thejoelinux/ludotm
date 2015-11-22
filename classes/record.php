<?php

class Record {

	public function create() {
		$fields_sql = $datas_sql = "";
		foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value is not empty AND is not an array
			if(array_key_exists($var, $_REQUEST) && $_REQUEST[$var] != "" && !is_array($_REQUEST[$var])) {
				if(strlen($var) > 5 && strrpos($var, "_date", -5)) { // search if the var is suffixed by date
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				$this->$var = $_REQUEST[$var];
				if(strlen($var) > 5 && strrpos($var, "_date", -5)) {
					$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
				}
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
			}
		}
		// SQL INSERT record.table 
		$sql = " INSERT INTO ".$this->table." (".$fields_sql." created_at, updated_at)
			VALUES (".$datas_sql." now(), now())";
		return $this->id = $GLOBALS["data"]->insert($sql);
	}

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(!is_array($this->$var) && array_key_exists($var, $_REQUEST)) {
				if(strlen($var) > 5 && strrpos($var, "_date", -5)) { // search if the var is suffixed by date
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if(strlen($var) > 5 && strrpos($var, "_date", -5)) {
						$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE record.table
			$sql = " UPDATE ".$this->table." SET ".$update_sql." updated_at = now()
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
	}

}
