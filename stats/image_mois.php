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

require_once "../fonctions/artichow/LinePlot.class.php";
require_once "../fonctions/artichow/BarPlot.class.php";
require "../fonctions/sql.inc";
// Return a random color
function color($a = NULL) {
	return new Color(mt_rand(20, 180), mt_rand(20, 180), mt_rand(20, 180), $a);
}

function formatLabel($value) {
	return sprintf("%.2f", $value);
}

$graph = new Graph(550, 200);
// $graph->setAntiAliasing(TRUE);
$graph->title->set("Fréquentation Par Mois");

$group = new PlotGroup;
$group->setXAxisZero(FALSE);
$group->setBackgroundColor(new Color(197, 180, 210, 80));

$group->setPadding(40, 160, 40, NULL);
// $group->setSpace(5, 50, 5, 0);
$group->axis->left->title->set("Presents");
$group->axis->right->title->set("Jours");

global $server_link;
$sql="SELECT date AS intervale,
		SUM(enfant_m6 + enfant_p6) AS enfants,
		SUM(mere + pere + ass_mat + autre) AS adultes,
		COUNT(*) AS jours
	FROM stats_jour WHERE YEAR(date)='".mysql_real_escape_string($_GET['year'],$server_link)."' 
	GROUP BY MONTH(date)";
$requete=mysql_query($sql,$server_link);
$y1 = $y2 = $x= array();

//date_default_timezone_set("Europe/Paris");
while ($resultat = mysql_fetch_array($requete))
{
		$x[] = strftime("%B",strtotime($resultat['intervale']));
		$y1[] = $resultat['enfants'];
		$y2[] = $resultat['adultes'];
		$y3[] = $resultat['jours'];
}

function setYear($value) {
	global $x;
	return $x[$value];
}

$group->axis->bottom->label->setCallbackFunction('setYear');

//enfants
$plot1 = new BarPlot($y1);
$blue = new Color(150, 0, 250, 0);
$plot1->setBarColor($blue);
$plot1->setYAxis(Plot::LEFT);
$group->add($plot1);
$group->legend->add($plot1, "Enfants", Legend::BACKGROUND);

//adultes
$plot2 = new BarPlot($y2);
$noir = new Color(120, 120, 10, 0);
$plot2->setBarColor($noir);
$plot2->setYAxis(Plot::LEFT);
$group->add($plot2);
$group->legend->add($plot2, "Adultes", Legend::BACKGROUND);

//jours
$plot3 = new LinePlot($y3,LinePlot::MIDDLE);
$red = new Color(240, 50, 50, 25);
$blue = new Color(150, 50, 50, 250);
$group->axis->right->setColor($red);
$plot3->setColor($red);
$plot3->setFillColor($blue);
$plot3->setYAxis(Plot::RIGHT);
//$plot->legend->setPosition(0.4, 0.2);
//$plot->legend->setPadding(3, 3, 3, 3, 3);
$group->add($plot3);
$group->legend->add($plot3, "Jours ouverts", Legend::LINE);

//dessin
$group->legend->setPosition(0.99,0.3);
$graph->add($group);
$graph->draw();
?>
