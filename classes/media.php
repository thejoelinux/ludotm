<?php

class Media {
	public $id, $description, $media_type_id, $file;

	public function __construct($id = 0)
  	{
    	if (!$this->id) {
			$this->id = $id;
	    }
	}
}

?>
