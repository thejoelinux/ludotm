<div class="row">
    <div class="col-sm-4">
        <!-- right hand side of the screen, w/ loans status & new buttons -->
        <div class="thumbnail">
            <div class="caption" align="center">
                <h3>Prêts en cours</h3>
                <p>
                right hand side of the screen, w/ loans status & new buttons
                right hand side of the screen, w/ loans status & new buttons
                right hand side of the screen, w/ loans status & new buttons
                right hand side of the screen, w/ loans status & new buttons
                </p>
                <div id="search-members" >
                    <input class="typeahead" type="text" placeholder="Adherent...">
                </div>
                <p><a href="#" class="btn btn-primary" role="button">Emprunter</a>
                <a href="#" class="btn btn-default" role="button">Restituer</a></p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="thumbnail">
            <div class="caption" align="center">
                <h3>Prêts en cours</h3>
                <p>
                right hand side of the screen, w/ loans status & new buttons
                right hand side of the screen, w/ loans status & new buttons
                right hand side of the screen, w/ loans status & new buttons
                right hand side of the screen, w/ loans status & new buttons
                </p>
                <p><a href="#" class="btn btn-primary" role="button">Emprunter</a>
                <a href="#" class="btn btn-default" role="button">Restituer</a></p>
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
    });
});
</script>
