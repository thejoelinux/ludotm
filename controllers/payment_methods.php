<?php
// controller 
$render = "list";
// format
$format = (preg_match("/api.php/", $_SERVER["REQUEST_URI"])) ? "json" : "html";

switch($_REQUEST["a"]) {
	case "list": // for API or HTML
		try {
			Payment_Method::fetch_all($payment_methods);
			if($format == "json") {
				echo json_encode($payment_methods);
				exit(); // no further rendering needed 
			} else {
				$render = "payment_methods/list";
			}
		} catch(data_exception $e) {
			header($_SERVER['SERVER_PROTOCOL'] . ' Internal Server Error', true, 500);
			exit(); // no further rendering needed 
		}
    break;

	case "create":
		try {
			$payment_method = new Payment_Method(0);
			$payment_method->create();
	
			Payment_Method::fetch_all($payment_methods);
			$render = "payment_methods/list";
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "new":
		$payment_method = new Payment_Method(0);
		$_REQUEST["i"] = 0;
		$render = "payment_methods/edit";
	break;

	case "delete":
		try {
			if($_REQUEST["i"] = Payment_Method::delete($_REQUEST["i"])) {
				Payment_Method::fetch_all($payment_methods);
				$render = "payment_methods/list";
			} else {
				$render = "unprocessable";
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "update":
		try {
            $payment_method = Payment_Method::fetch($data->db_escape_string($_REQUEST["i"]));
			if($payment_method->id != 0) {
				$payment_method->update();
				Payment_Method::fetch_all($payment_methods);
				$render = "payment_methods/list";
			} else {
				$render = "payment_methods/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;

	case "edit":
		try {
            $payment_method = Payment_Method::fetch($data->db_escape_string($_REQUEST["i"]));
			if($payment_method->id != 0) {
				$render = "payment_methods/edit";
			} else {
				$render = "payment_methods/not_found"; // TODO
			}
		} catch(data_exception $e) {
			$render = "data_exception";
		}
	break;
}
// view part
include("views/".$render.".php");
?>
