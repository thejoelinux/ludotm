<?php

class Media {
	public $id, $description, $media_type_id, $file, $mime_type;

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}

	public static function fetch_all(&$medias, $game_id) {
        $medias = array();
		// SQL SELECT medias media_type
        $sql = " SELECT m.id, m.description, m.media_type_id, m.file, mt.mime_type
            FROM medias m
				LEFT OUTER JOIN media_types mt ON (m.media_type_id = mt.id)
            WHERE id_jeu = ".$game_id;
        $GLOBALS["data"]->select($sql, $medias, "Media", true);
        return sizeof($medias);
    }

	public static function delete($id) {
		// SQL SELECT media
		$sql = " SELECT file, id_jeu
			FROM medias
			WHERE id = $id ";
		$GLOBALS["data"]->select($sql, $rset);
		if($rset->numrows) {
			unlink("uploads/".$rset->value("file"));
			// SQL DELETE media
			$sql = " DELETE FROM medias
				WHERE id = $id ";
			$GLOBALS["data"]->delete($sql);
			return $rset->value("id_jeu");
		}
		return false;
	}

	public function create() {
		// SQL INSERT medias
		$sql = " INSERT INTO medias (description, id_jeu, media_type_id)
				VALUES ('".$this->description."', ".$_REQUEST["i"].", ".
				$this->media_type_id.")";
		return $this->id = $GLOBALS["data"]->insert($sql);
	}

	public function update($filename, $filetype) {
		$this->file = $filename."-".$this->id.".".$filetype;
		// SQL UPDATE medias
		$sql = " UPDATE medias 
			SET file = '".$this->file."'
			WHERE id = ".$this->id;
		return $GLOBALS["data"]->update($sql);
	}

	public function set_mime_type($type) {
		// SQL SELECT media_types
		$sql = " SELECT id 
			FROM media_types
			WHERE mime_type = '".$type."'";
		$GLOBALS["data"]->select($sql, $rset);
		$this->media_type_id = ($rset->numrows ? $rset->value("id") : 0);
		return true;
	}
}

?>
