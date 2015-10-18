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


function alterne_tr($ligne){
	echo "<tr";
	if (!$ligne) {$ligne=TRUE; echo " id=tr_alterne";} else $ligne=FALSE;
	echo ">";
	return $ligne;
}

function adhesion_a_jour($date_inscription){
  list($a,$m,$j)=explode('-',$date_inscription);
  if( (time()-mktime(0,0,0,$m,$j,$a)) > 3600*24*364 )
   return " ($date_inscription)";
  else
    return '';
}

?>
