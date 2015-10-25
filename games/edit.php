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
?>
<script>
/* FIXME view form validation later
function validate_and_submit ()
{
    if(document.forms["saisie"].nom.value == 0)
    {
        alert ("Vous n'avez pas saisi le nom!");
        return false;
    }
    document.forms["saisie"].submit();
    return true;
}
</script>
<?php
// since we are in the edit form, we have an existing $game
?>
<center>
<h3>JEU n°<?=$game->id_jeu?>
	<?php if($game->id_pret) { ?>
	(INDISPONIBLE) FIXME : lien vers pret en cours
	<?php } else { ?>
	(DISPONIBLE)
	<?php } ?>
	</h3>

<a href="index.php?o=prets&id_jeu=<?$game->id_pret?>">Historique des prêts</a>

	<div class="form-group">
		<label class="control-label col-sm-2" for="nom">Nom</label>
		<div class="col-sm-4">
			<input type="text" id="nom" class="form-control" value="<?=$game->nom?>"/>
		</div>
		<label class="control-label col-sm-2" for="reference">Référence</label>
		<div class="col-sm-4">
			<input type="text" id="reference" class="form-control" value="<?=$game->reference?>"/>
		</div>	
	</div>

<table>
    <tr>
        <td align=right>Fabricant</td>
        <td align=left><input type=text name=fabricant SIZE=20 MAXLENGTH=20 
            value="<?=$game->fabricant?>"></td>
    </tr>   
    <tr>
        <td align=right>Informations du Fabricant</td>
        <td align=left><input type=text name=infos_fabricant SIZE=60 MAXLENGTH=60 
            value="<?=$game->infos_fabricant?>"></td>
    </tr>   
    <tr>
        <td align=right>Catégorie</td>
        <td align=left><input type=text name=categorie SIZE=40 MAXLENGTH=40 
            value="<?=$game->categorie?>">
        (ex sy as rè)
        </td>
    </tr>   
    <tr>
        <td align=right>Catégorie ESAR</td>
        <td align="left">FIXME - wait a minute
            <?php //select_categorie_esar($game->categorie_esar_id);?>   
        </td>
    </tr>
    <tr>
        <td align=right>Prix</td>
        <td align=left><input type=text name=prix SIZE=3 MAXLENGTH=3 
            value="<?=$game->prix?>">
        </td>
    </tr>   
    <tr>
        <td align="right">Medias</td>
        <td style="background-color: white">
        <?php
            if(is_array($jeu['medias'])) {
                ?><div id="media_list"><?php
                // DEBUG echo "<pre>"; print_r($jeu["medias"]); echo "</pre>";
                while(list($key, $val) = each($jeu['medias'])) {
                    ?><div id="media_<?=$val["id"]?>"><?php
                    echo $val["description"]."\n";
                    ?>
                    <a href="javascript:delete_file(<?=$val["id"]?>)">Effacer</a>
                    </div>
                    <?php
                    if(preg_match("/.jpg$/", $val["file"])) {
                        ?>
                        <img width="100" height="80" src="uploads/<?=$val["file"]?>">
                        <?php
                    }
                }
                ?></div><?php
            } else {
            ?>
                Pas de medias associé
            <?php
            }
            ?>
            <input type="file" name="media"/>
            <input type="button" value="Ajouter" id="add_media" />
<script>
function delete_file(id) {
    alert("Pas encore fonctionnel...");
}
$('#add_media').click(function(){
    var formData = new FormData($('form')[0]);
    $.ajax({
        url: 'upload.php?id_jeu=<?=$jeu["id_jeu"]?>',  //Server script to process data
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        //Ajax events
        //beforeSend: beforeSendHandler,
        // FIXME 
        success: completeHandler,
        // FIXME error: errorHandler,
        // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
});
function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
}
function completeHandler (response) {
    $('#media_list').html(
        $('#media_list').html() + "<div id='media_" +
            response.media_id + "'>" + response.description + "</div>" + 
            "<a href=\"javascript:delete_file(" + response.media_id + ")\">Effacer</a>"
            );
    alert(response);    
}

</script>

        </td>
    </tr>
    <tr>
        <td align=right>Nombre de joueurs</td>
        <td align=left>Mini -><input type=text name=nombre_mini SIZE=3 MAXLENGTH=3 
            value="<?php echo $jeu['nombre_mini'];?>">
            Maxi -><input type=text name=nombre_maxi SIZE=3 MAXLENGTH=3 
            value="<?php echo $jeu['nombre_maxi'];?>">
        </td>
    </tr>   
    <tr>
        <td align=right>Age des joueurs</td>
        <td align=left>Mini -><input type=text name=age_mini SIZE=3 MAXLENGTH=3 
            value="<?php echo $jeu['age_mini'];?>">
            Maxi -><input type=text name=age_maxi SIZE=3 MAXLENGTH=3 
            value="<?php echo $jeu['age_maxi'];?>">
        </td>
    </tr>   
    <tr>
        <td align=right>Type de jeu</td>
        <td align=left><input type=text name=type SIZE=40 MAXLENGTH=40 
            value="<?php echo $jeu['type'];?>">
        </td>
    </tr>   
    <tr>
        <td align=right>Date d'acquisition</td>
        <td align=left><input type=text name=date_achat SIZE=10 MAXLENGTH=10 
            value="<?php echo $jeu['date_achat'];?>">
            <font size=-1> (AAAA-MM-JJ) Année-Mois-Jour</font></td>
    </tr>   
    <tr>
        <td align=right>Inventaire</td>
        <td align=left><textarea name=inventaire cols=60 rows=7><?php echo $jeu['inventaire'];?></textarea></td>
    </tr>
    <tr>
        <td align=right>Commentaire</td>
        <td align=left><textarea name=commentaire cols=60 rows=5><?php echo $jeu['commentaire'];?></textarea>
<?php if (isset($jeu['id_jeu'])) { ?>
    <tr>
                <input type="hidden" name="id_jeu" value="<?=$jeu['id_jeu']?>">
        <td colspan="2"><a href="del.php?id_jeu=<?=$jeu['id_jeu']?>">SUPPRIMER</a></td>
    </tr>
<?php } ?>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="VALIDER" onClick="validate_and_submit()">
        </td>
    </tr>   

</form>
</table>
<?php 
include "../fonctions/finpage.php";
?>
