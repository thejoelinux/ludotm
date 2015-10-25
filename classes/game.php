<?php

class Game {
	public $id_jeu;
	public $nom, $reference, $fabricant, $categorie, $categorie_esar_id;
	public $commentaire, $infos_fabricant, $inventaire, $date_achat, $prix;
	public $nombre_mini, $nombre_maxi, $age_mini, $age_maxi, $type;

	public function __construct($id = 0)
  	{
    	if (!$this->id_jeu) {
			$this->id_jeu = $id;
	    }
	}
}

?>
