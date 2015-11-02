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

	public function create() {
		// SQL INSERT medias
		$sql = "INSERT INTO medias (description, id_jeu)
				VALUES ('$description', ".$_REQUEST["game_id"].")";
		return $this->id = $GLOBALS["data"]->insert($sql);
	}

	public function update($filename, $filetype) {
		$this->file = $filename."-".$this->id.".".$filetype;
		// SQL UPDATE medias
		$sql = "UPDATE medias 
			SET file = '".$this->file."'
			WHERE id = ".$this->id;
		return $GLOBALS["data"]->update($sql);
	}
}

?>
