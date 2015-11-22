<?php
// controller 
$render = "list";
// format
$format = (preg_match("/api.php/", $_SERVER["REQUEST_URI"])) ? "json" : "html";

switch($_REQUEST["a"]) {

    case "create":
		try {
			$esar_category = new Esar_Category(0);
			$esar_category->create();
	
			Esar_Category::fetch_all($esar_categories);
			$render = "esar_categories/list";
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "new":
		$esar_category = new Esar_Category(0);
		$_REQUEST["i"] = 0;
		$render = "esar_categories/edit";
	break;

	case "delete":
		try {
			if($_REQUEST["i"] = Esar_Category::delete($_REQUEST["i"])) {
				Esar_Category::fetch_all($esar_categories);
				$render = "esar_categories/list";
			} else {
				$render = "unprocessable";
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "update":
		try {
            $esar_category = Esar_Category::fetch($data->db_escape_string($_REQUEST["i"]));
			if($esar_category->id != 0) {
				$esar_category->update();
				Esar_Category::fetch_all($esar_categories);
				$render = "esar_categories/list";
			} else {
				$render = "esar_categories/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "edit":
		try {
            $esar_category = Esar_Category::fetch($data->db_escape_string($_REQUEST["i"]));
			if($esar_category->id != 0) {
				$render = "esar_categories/edit";
			} else {
				$render = "esar_categories/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "list": // for API
        try {
            Esar_Category::fetch_all($esar_categories);
            if($format == "json") {
                echo json_encode($esar_categories);
                exit(); // no further rendering needed 
            } else {
                    $render = "esar_categories/list";
            }
		} catch(data_exception $e) {
			$render = "views/data_exception";
		}
    break;
}

include("views/".$render.".php");
