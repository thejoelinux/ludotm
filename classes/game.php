<?php

class Game {
	public $id;
	public $name, $reference, $maker, $category, $esar_category_id;
	public $comments, $maker_info, $content_inventory, $aquisition_date, $price;
	public $players_min, $players_max, $age_min, $age_max, $game_type;

    // array containing the medias associated with the game
    public $medias;

	public function __construct($id = 0) {
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

    public static function fetch($id) {
        // SQL SELECT games prets
        $sql = "SELECT games.id, name, reference, maker, category, esar_category_id,
            comments, maker_info, content_inventory, DATE_FORMAT(aquisition_date, '%m/%d/%Y') as aquisition_date,
			price, players_min, players_max,
            age_min, age_max, game_type, loans.id as loan_id
            FROM games
                LEFT OUTER JOIN loans ON (games.id = loans.id AND loans.is_back = 0)
            WHERE games.id = ".$id;
        $GLOBALS["data"]->select($sql, $game, "Game");
        return $game;
    }

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			if(array_key_exists($var, $_REQUEST)) {
				if($var == "aquisition_date") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if($var == "aquisition_date") {
						$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE games
			$sql = " UPDATE games SET ".$update_sql." updated_at = now()
				WHERE id = ".$this->id;
        	return $GLOBALS["data"]->update($sql);
		}
	}

	public function create() {
		$fields_sql = $datas_sql = "";
		foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value is not empty
			if(array_key_exists($var, $_REQUEST) && $_REQUEST[$var] != "") {
				if($var == "aquisition_date") {
					$_REQUEST[$var] = date_format(date_create_from_format('d-m-Y', $_REQUEST[$var]),'m/d/Y');
				}
				$this->$var = $_REQUEST[$var];
				if($var == "aquisition_date") {
					$_REQUEST[$var] = date_format(date_create_from_format('m/d/Y', $_REQUEST[$var]),'Y-m-d');
				}
				$fields_sql .= " $var,";
				$datas_sql .= " '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
				// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
			}
		}
		// SQL INSERT games
		$sql = " INSERT INTO games (".$fields_sql.", created_at, updated_at)
			VALUES (".$datas_sql." now(), now())";
		return $this->id = $GLOBALS["data"]->insert($sql);	
	}

    public function render_json() {
        echo json_encode($this);
    }

	// probably not used - done in javascript on the edit view for the game
    public function fetch_medias() {
        $this->medias = array();
		Media::fetch_all($this->medias, $this->id);
        return sizeof($this->medias);
    }

    public static function fetch_all(&$games) {
        $games = array();
		$where_clause = "";
		if(array_key_exists("filter", $_REQUEST) && $_REQUEST["filter"] == "available") {
			$where_clause = "WHERE l.id IS NULL";
		}
        $sql = "SELECT g.id, g.name, 
            CONCAT (ec.label, ' - ', ec.name) AS label,
            l.id as loan_status
            FROM games g
                LEFT OUTER JOIN esar_categories ec ON g.esar_category_id = ec.id
                LEFT OUTER JOIN loans l ON (g.id = l.game_id AND l.is_back = 0)
			$where_clause	
            ORDER BY g.name"; 
        $GLOBALS["data"]->select($sql, $games, "Game");
        return sizeof($games);
    }
}

?>
