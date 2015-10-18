<?php
header("Content-Type: application/json");
include "../fonctions/sql.inc";

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["media"]["name"]);
$uploadOk = 1;
$filetype = pathinfo($target_file,PATHINFO_EXTENSION);
$description = pathinfo($target_file,PATHINFO_FILENAME);
$filename = basename($_FILES["media"]["tmp_name"]);

// DEBUG print_r($_FILES);

// first insert and get back the id
// SQL INSERT medias
$sql = "INSERT INTO medias 
    (description, id_jeu)
    VALUES('$description', ".$_GET["id_jeu"].")";
    // DEBUG echo $sql;
sql_command($sql,$server_link);
$media_id = mysql_insert_id($server_link);
if($media_id > 0) {
    // SQL UPDATE medias
    $sql = "UPDATE medias SET file = CONCAT('$filename', '-', '".$media_id."', '.', '".$filetype."')
        WHERE id = $media_id";
    // DEBUG echo $sql;
    sql_command($sql, $server_link);
    $filename = $filename."-".$media_id.".".$filetype;
} else {
    // ??? FIXME
    exit();
}

// then mv the file in uploads/ dir
// DEBUG echo "move_uploaded_file(".$_FILES["media"]["tmp_name"].",".$target_dir.$filename.");";
move_uploaded_file($_FILES["media"]["tmp_name"], $target_dir.$filename);

// echo back the html to add to list
echo '{"media_id": "'.$media_id.'", "description": "'.$description.'"}';
?>
