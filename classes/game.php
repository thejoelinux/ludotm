<?php

class Game extends Record {
	public $id;
	public $name, $reference, $maker, $category, $esar_category_id;
	public $comments, $maker_info, $content_inventory, $aquisition_date, $price;
	public $players_min, $players_max, $age_min, $age_max, $game_type;

    // array containing the medias associated with the game
    public $medias;

	public $table = "games";

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
            age_min, age_max, game_type, loans.id as loan_id, DATE_FORMAT(loans.end_date, '%d/%m/%Y')  AS loan_end_date
            FROM games
                LEFT OUTER JOIN loans ON (games.id = loans.game_id AND loans.is_back = 0)
            WHERE games.id = ".$id;
        $GLOBALS["data"]->select($sql, $game, "Game");
        return $game;
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
