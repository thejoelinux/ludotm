<?php

class Media {
	public $id, $description, $media_type_id, $file;

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$medias, $game_id) {
        $medias = array();
		// SQL SELECT medias
        $sql = " SELECT id, description, media_type_id, file
            FROM medias
            WHERE id_jeu = ".$game_id;
        $GLOBALS["data"]->select($sql, $medias, "Media");
        return sizeof($medias);
    }
}

?>
