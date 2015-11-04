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

// on veut les jours d'ouverture, les enfants et les adultes
// par $intervale pour la $periode
function stats_presence($intervale,$periode,$intervale_fr)
{
    global $server_link;
    $sql="SELECT date AS intervale,
            SUM(enfant_m6 + enfant_p6) AS enfants,
            SUM(mere + pere + ass_mat + autre) AS adultes,
            COUNT(*) AS jours
        FROM stats_jour WHERE YEAR(date)=".mysql_real_escape_string($periode,$server_link)." 
        GROUP BY ".mysql_real_escape_string($intervale,$server_link)."(date)";
    $requete=mysql_query($sql,$server_link);
    echo "<table>";
    echo "<tr><th>$intervale_fr</th><th>Enfants</th>
        <th>Adultes</th><th>Nombre de jours d'ouverture</th></tr>";
    
    $ligne=FALSE; // pour alterner les lignes
    $total_enfants=$total_adultes=$total_jours=0;
    $trimestre=0;
    while ($resultat = mysql_fetch_array($requete))
    {
            $ligne=alterne_tr($ligne);
            echo "<td>";
            if(!strcmp($intervale,'MONTH'))
            echo strftime("%B",strtotime($resultat['intervale']));
            elseif(!strcmp($intervale,'YEAR'))
            echo strftime("%Y",strtotime($resultat['intervale']));
            else {$trimestre++;echo $trimestre;}
    
            echo "</td>
                <td>".$resultat['enfants']."</td>
                <td>".$resultat['adultes']."</td>
                <td>".$resultat['jours']."</td>
            </tr>";
            $total_enfants+=$resultat['enfants'];
            $total_adultes+=$resultat['adultes'];
            $total_jours+=$resultat['jours'];
    }
    echo "</table>";
    if ( !strcmp($intervale,'YEAR'))
    echo "<BR>Moyenne sur l'année : ".
        round($total_enfants/$total_jours)." enfants/jour et ".
        round($total_adultes/$total_jours)." adultes/jour.";
}

// on veut les jours d'ouverture, les enfants -6 et +6 et les adultes
// par $intervale pour la $periode
function stats_presence2($intervale,$periode,$intervale_fr)
{
    global $server_link;
    $sql="SELECT date AS intervale,
            SUM(enfant_m6) AS enfant_m6,
            SUM(enfant_p6) AS enfant_p6,
            SUM(mere + pere + ass_mat + autre) AS adultes,
            COUNT(*) AS jours
        FROM stats_jour WHERE YEAR(date)=".mysql_real_escape_string($periode ,$server_link)."
        GROUP BY ".mysql_real_escape_string($intervale,$server_link)."(date)";
    $requete=mysql_query($sql,$server_link);
    echo "<table>";
    echo "<tr><th>$intervale_fr</th><th>Enfants -6</th><th>Enfants +6</th>
        <th>Adultes</th><th>Nombre de jours d'ouverture</th></tr>";
    
    $ligne=FALSE; // pour alterner les lignes
    $total_enfants=$total_adultes=$total_jours=0;
    $trimestre=0;
    while ($resultat = mysql_fetch_array($requete))
    {
            $ligne=alterne_tr($ligne);
            echo "<td>";
            if(!strcmp($intervale,'MONTH'))
            echo strftime("%B",strtotime($resultat['intervale']));
            elseif(!strcmp($intervale,'YEAR'))
            echo strftime("%Y",strtotime($resultat['intervale']));
            else {$trimestre++;echo $trimestre;}
    
            echo "</td>
                <td>".$resultat['enfant_m6']."</td>
                <td>".$resultat['enfant_p6']."</td>
                <td>".$resultat['adultes']."</td>
                <td>".$resultat['jours']."</td>
            </tr>";
            $total_enfant_m6+=$resultat['enfant_m6'];
            $total_enfant_p6+=$resultat['enfant_p6'];
            $total_adultes+=$resultat['adultes'];
            $total_jours+=$resultat['jours'];
    }
    echo "</table>";
    if ( !strcmp($intervale,'YEAR'))
    echo "<BR>Moyenne sur l'année : ".
        round($total_enfant_m6/$total_jours)." enfants -6 ans/jour et ".
        round($total_enfant_p6/$total_jours)." enfants +6 ans/jour et ".
        round($total_adultes/$total_jours)." adultes/jour.";
}

// on veut les prêts
// par $intervale pour la $periode
function stats_prets($intervale,$periode,$intervale_fr)
{
    global $server_link;
    $sql="SELECT date_pret AS intervale,
            count(*) AS prets
        FROM prets WHERE YEAR(date_pret)=".mysql_real_escape_string($periode ,$server_link)." 
        GROUP BY ".mysql_real_escape_string($intervale,$server_link)."(date_pret)";
    $requete=mysql_query($sql,$server_link);
    echo "<table>";
    echo "<tr><th>$intervale_fr</th><th>Prêts</th></tr>";
    
    $ligne=FALSE; // pour alterner les lignes
    $trimestre=0;
    $total_prets=0;
    while ($resultat = mysql_fetch_array($requete))
    {
            $ligne=alterne_tr($ligne);
            echo "<td>";
            if(!strcmp($intervale,'MONTH'))
            echo strftime("%B",strtotime($resultat['intervale']));
            elseif(!strcmp($intervale,'YEAR'))
            echo strftime("%Y",strtotime($resultat['intervale']));
            else {$trimestre++;echo $trimestre;}
    
            echo "</td>
                <td>".$resultat['prets']."</td>
            </tr>";
            $total_prets+=$resultat['prets'];
    }
    echo "</table>";
}
