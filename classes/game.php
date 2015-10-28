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
            commentaire, infos_fabricant, inventaire, date_achat, prix, nombre_mini, nombre_maxi,
            age_mini, age_maxi, type, id_pret
            FROM jeu
                LEFT OUTER JOIN prets ON (jeu.id_jeu = prets.id_jeu AND prets.rendu = 0)
            WHERE jeu.id_jeu = ".$id;
        $GLOBALS["data"]->select($sql, $game, "Game");
        // foreach(get_object_vars($my) as $var => $value) $this->$var = $value;
        return $game;
    }

    public function render_json() {
        echo json_encode($this);
    }

    public function fetch_medias() {
        $this->medias = array();
        // SQL SELECT medias
        $sql = " SELECT id, description, media_type_id, file
            FROM medias
            WHERE id_jeu = ".$this->id_jeu;
        $GLOBALS["data"]->select($sql, $this->medias, "Media");
        return sizeof($this->medias);
    }

    public static function fetch_all(&$games) {
        $games = array();
        // SQL SELECT jeu categorie_esar prets
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
