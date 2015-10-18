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
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
Paramètres de la BDD
*/
$db_database = "__database_name__";
$db_host = "__database_host__";
$db_user = "__database_user__";
$db_user_password = "__database_passwd__";

// Langue de l'application pour les jours de semaine
setlocale(LC_TIME, "fr_FR");

//Il faut définir la zone à partir de PHP 5.1.0
if (version_compare("5.1.0", PHP_VERSION))
	date_default_timezone_set("Europe/Paris");
?>
