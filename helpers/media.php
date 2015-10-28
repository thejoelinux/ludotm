 <!-- div class="form-group">
    <label class="control-label col-sm-3" for="medias">Médias</label>

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
            <input type="file" name="media" class="col-sm-6" />
            <input type="button" value="Ajouter" id="add_media" class="col-sm-3"/>
    </div>
</div -->

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
