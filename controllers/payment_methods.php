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
