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
// since we are in the edit form, we have an existing $game from the controller
?>
<center>
<h3>JEU n°<?=$game->id_jeu?>
	<?php if($game->id_pret) { ?>
	(INDISPONIBLE) FIXME : lien vers pret en cours
	<?php } else { ?>
	(DISPONIBLE)
	<?php } ?>
	</h3>

<a href="index.php?o=prets&id_jeu=<?=$game->id_pret?>">Historique des prêts</a>

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
    <div class="form-group">
        <label class="control-label col-sm-2" for="fabricant">Fabricant</label>
        <div class="col-sm-2">
            <input type="text" id="fabricant" class="form-control" value="<?=$game->fabricant?>"/>
        </div>
        <label class="control-label col-sm-2" for="infos_fabricant">Infos fabricant</label>
        <div class="col-sm-2">
            <input type="text" id="infos_fabricant" class="form-control" value="<?=$game->infos_fabricant?>"/>
        </div>
        <label class="control-label col-sm-2" for="prix">Prix</label>
        <div class="col-sm-2">
            <input type="text" id="prix" class="form-control" value="<?=$game->prix?>"/>
        </div>
    </div>
     <div class="form-group">
        <label class="control-label col-sm-2" for="categorie">Catégorie (ex sy as rè)</label>
        <div class="col-sm-4">
            <input type="text" id="categorie" class="form-control" value="<?=$game->categorie?>"/>
        </div>
        <label class="control-label col-sm-2" for="categorie_esar_id">Catégorie ESAR</label>
        <div class="col-sm-4">
            <input type="text" id="categorie_esar_id" class="form-control" value="<?=$game->categorie_esar_id?>"/>
        </div>
    </div>
     <div class="form-group">
        <label class="control-label col-sm-2" for="medias">Médias</label>
        <div class="col-sm-8">
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
            <div class="input-group">
                <input type="file" name="media" class="form-control"/>
                <input type="button" value="Ajouter" id="add_media" class="input-group-addon" />
                <!-- 
                javascript for these controls is at the end of the page 
                -->
            </div>


        </div>
    </div>
    <!-- 
    <table>
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
-->
</form>
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
</table>
