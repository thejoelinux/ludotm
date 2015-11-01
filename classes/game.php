<?php

class Game {
	public $id_jeu;
	public $nom, $reference, $fabricant, $categorie, $categorie_esar_id;
	public $commentaire, $infos_fabricant, $inventaire, $date_achat, $prix;
	public $nombre_mini, $nombre_maxi, $age_mini, $age_maxi, $type;

    // array containing the medias associated with the game
    public $medias;

	public function __construct($id = 0) {
    	if (!$this->id_jeu) {
			$this->id_jeu = $id;
	    }
	}

    public static function fetch($id) {
        // SQL SELECT jeu prets
        $sql = "SELECT jeu.id_jeu, nom, reference, fabricant, categorie, categorie_esar_id,
            commentaire, infos_fabricant, inventaire, DATE_FORMAT(date_achat, '%m/%d/%Y') as date_achat,
			prix, nombre_mini, nombre_maxi,
            age_mini, age_maxi, type, id_pret
            FROM jeu
                LEFT OUTER JOIN prets ON (jeu.id_jeu = prets.id_jeu AND prets.rendu = 0)
            WHERE jeu.id_jeu = ".$id;
        $GLOBALS["data"]->select($sql, $game, "Game");
        return $game;
    }

	public function update() {
		$update_sql = "";
        foreach(get_object_vars($this) as $var => $value) {
			// check if there is a corresponding value in _REQUEST
			// and the value has really changed
			//echo "check for $var... ";
			if(array_key_exists($var, $_REQUEST)) {
				if($var == "date_achat") {
					$_REQUEST["date_achat"] = date_format(date_create_from_format('d-m-Y', $_REQUEST["date_achat"]),'m/d/Y');
				}
				if($_REQUEST[$var] != $value) {
					$this->$var = $_REQUEST[$var];
					if($var == "date_achat") {
						$_REQUEST["date_achat"] = date_format(date_create_from_format('m/d/Y', $_REQUEST["date_achat"]),'Y-m-d');
					}
					$update_sql .= " $var = '".$GLOBALS["data"]->db_escape_string($_REQUEST[$var])."',";
					// DEBUG echo "REQ : ".$_REQUEST[$var]." != OBJ : ".$value."<br>";
				}
			}
		}
		if($update_sql != "") {
			// SQL UPDATE jeu
			$sql = " UPDATE jeu SET ".substr($update_sql, 0, -1)."
				WHERE id_jeu = ".$this->id_jeu;
        	return $GLOBALS["data"]->update($sql);
		}
	}

    public function render_json() {
        echo json_encode($this);
    }

    public function fetch_medias() {
        $this->medias = array();
		Media::fetch_all($this->medias, $this->id_jeu);
        return sizeof($this->medias);
    }

    public static function fetch_all(&$games) {
        $games = array();
        $sql = "SELECT jeu.id_jeu, nom, 
            CONCAT (categorie_esar.label, ' - ', categorie_esar.name) AS label,
            id_pret as etat_pret

            FROM jeu
                LEFT OUTER JOIN categorie_esar ON jeu.categorie_esar_id = categorie_esar.id
                LEFT OUTER JOIN prets ON (jeu.id_jeu = prets.id_jeu AND date_retour > curdate())
            ORDER BY nom"; 
        $GLOBALS["data"]->select($sql, $games, "Game");
        return sizeof($games);
    }
}

?>
