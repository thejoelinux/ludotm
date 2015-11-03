<?php
/*
This file is part of phpLudoreve.

    phpLudoreve is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    phpLudoreve is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with phpLudoreve.  If not, see <http://www.gnu.org/licenses/>.
*/

// controller 
$render = "list";
switch($_REQUEST["a"]) {
	case "upload": // for API
		$media = new Media();
        try {
			$media->set_mime_type($_FILES["media"]["type"]);
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["media"]["name"]);
			$filetype = pathinfo($target_file,PATHINFO_EXTENSION);
			$media->description = pathinfo($target_file,PATHINFO_FILENAME);
			$filename = basename($_FILES["media"]["tmp_name"]);

			// DEBUG print_r($_FILES);

			// create and get back the id
			// the reason for this is that the file name, to be garanteed unique
			// will include the id from the DB
			$media->create();
			$media->update($filename, $filetype);	

			// then mv the file in uploads/ dir
			// DEBUG echo "move_uploaded_file(".$_FILES["media"]["tmp_name"].",".$target_dir.$filename.");";
			move_uploaded_file($_FILES["media"]["tmp_name"], $target_dir.$media->file);

			$render = "json/list";
		} catch(data_exception $e) {
			$render = "views/data_exception";
		}
    break;

	case "delete":
		if($_REQUEST["i"] = Media::delete($_REQUEST["i"])) {
			$render = "json/list";
		} else {
			$render = "views/data_exception";
		}
	break;		

	case "list": // for API
		$render = "json/list";
	break;
}

if($render == "json/list") {
	$medias = array();
	Media::fetch_all($medias, $_REQUEST["i"]);
	echo json_encode($medias);
	exit(); // no further rendering needed 
}
