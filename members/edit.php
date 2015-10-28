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
*/
</script>
<?php
// since we are in the edit form, we have an existing $game from the controller
?>
<div class="col-sm-12" style="background-color: #DDDDDD">
    <h3>JEU n°<?=$game->id_jeu?>
	<?php if($game->id_pret) { ?>
	(INDISPONIBLE) FIXME : lien vers pret en cours
	<?php } else { ?>
	(DISPONIBLE)
	<?php } ?>
    </h3>
    <!-- FIXME : put this in a side bar helper <
    a href="index.php?o=prets&id_jeu=<?=$game->id_pret?>">Historique des prêts</a>
    -->
</div>

<div class="form-group">
    <label class="control-label col-sm-3" for="nom">Nom</label>
    <div class="col-sm-9">
        <input type="text" id="nom" class="form-control" value="<?=$game->nom?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="reference">Référence</label>
    <div class="col-sm-9">
        <input type="text" id="reference" class="form-control" value="<?=$game->reference?>"/>
    </div>	
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="fabricant">Fabricant</label>
    <div class="col-sm-9">
        <input type="text" id="fabricant" class="form-control" value="<?=$game->fabricant?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="infos_fabricant">Infos fabricant</label>
    <div class="col-sm-9">
        <input type="text" id="infos_fabricant" class="form-control" value="<?=$game->infos_fabricant?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="prix">Prix</label>
    <div class="col-sm-9">
        <input type="text" id="prix" class="form-control" value="<?=$game->prix?>"/>
    </div>
</div>
 <div class="form-group">
    <label class="control-label col-sm-3" for="categorie">Catégorie (ex sy as rè)</label>
    <div class="col-sm-9">
        <input type="text" id="categorie" class="form-control" value="<?=$game->categorie?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="categorie_esar_id">Catégorie ESAR</label>
    <div class="col-sm-9">
        <input type="text" id="categorie_esar_id" class="form-control" value="<?=$game->categorie_esar_id?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="nombre_mini">Nombre de joueurs de </label>
    <div class="col-sm-3">
        <input type="text" id="nombre_mini" class="form-control" value="<?=$game->nombre_mini?>"/>
    </div>
    <label class="control-label col-sm-3" for="nombre_maxi">à</label>
    <div class="col-sm-3">
        <input type="text" id="nombre_maxi" class="form-control" value="<?=$game->nombre_maxi?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="age_mini">Age des joueurs de </label>
    <div class="col-sm-3">
        <input type="text" id="age_mini" class="form-control" value="<?=$game->age_mini?>"/>
    </div>
    <label class="control-label col-sm-3" for="age_maxi">à</label>
    <div class="col-sm-3">
        <input type="text" id="age_maxi" class="form-control" value="<?=$game->age_maxi?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="type">Type de jeu</label>
    <div class="col-sm-9">
        <input type="text" id="type" class="form-control" value="<?=$game->type?>"/>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="date_achat">Date d'achat</label>
    <div class="col-sm-9">
        <input type="text" id="date_achat" class="form-control" value="<?=$game->date_achat?>"/>
        <!-- FIXME : put a datepicker here -->
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="inventaire">Inventaire</label>
    <div class="col-sm-9">
        <textarea id="inventaire" class="form-control"><?=$game->inventaire?></textarea>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3" for="commentaire">Commentaire</label>
    <div class="col-sm-9">
        <textarea id="commentaire" class="form-control"><?=$game->commentaire?></textarea>
    </div>
</div>

<div class="form-group" class="col-sm-12">
    <input type="button" class="btn btn-primary" value="Valider">
<?php if ($game->id_jeu != 0) { ?>
    <input type="button" class="btn btn-danger" value="Supprimer">
<?php } ?>
</div>
