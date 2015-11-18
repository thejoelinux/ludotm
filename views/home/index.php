<div class="row">

    <div class="col-sm-4">
        <!-- right hand side of the screen, w/ loans status & new buttons -->
        <div class="thumbnail">
            <div class="caption" align="center">
                <h3>Prêts en cours</h3>
                <p>
				<?php if(sizeof($loans)) { while(list($key, $val) = each($loans)) { ?>
				<a href="index.php?o=loans&a=edit&i=<?=$val->id?>"><?=$val->game_name?></a>,
					retour le <?=$val->end_date?><br>
				<?php } } else { ?>
					Aucun emprunt en cours.
				<?php } ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="thumbnail">
            <div class="caption" align="center">
                <h3>Derniers adhérents</h3>
                <p>
				<?php if(sizeof($members)) { while(list($key, $val) = each($members)) { ?>
				<a href="index.php?o=members&a=edit&i=<?=$val->id?>"><?=$val->full_name?></a>,
					à <?=$val->po_town?><br>
				<?php } } else { ?>
					Pas encore d'adhérents.
				<?php } ?>
                </p>
            </div>
        </div>
    </div>
	<div class="col-sm-4">
        <!-- calendar -->
        <div id="main-calendar"></div>
    </div>
</div>    
<script>
$(document).ready(function () {
    $("#main-calendar").zabuto_calendar({
        language: "fr",
        today: true,
		ajax : {
			url : 'api.php?o=members&a=birthdays',
			modal : true
		}
    });
});
</script>
