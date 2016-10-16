<?php session_start();

include("html_env.php");
include("DB_config.php");
include("Delete.php");

html_header("Suppression de Post");

$postID=intval($_POST['id_post']);

$DB = DB_connect();

$verify_owner_query = pg_prepare($DB, "select_author_entry", "SELECT author FROM \"post\" WHERE id = $1");
$verify_owner_result = pg_execute($DB, "select_author_entry", array($postID));
$verify_owner_array = pg_fetch_assoc($verify_owner_result);
$author = $verify_owner_array['author'];

$userID = $_SESSION['id'];
$pseudo = $_SESSION['pseudo'];

if ($userID == $author || $_SESSION['admin'] == 1) {
    delete_post($author, $postID, $DB);
    echo "<script> alert(\"Votre post a bien été supprimé\")</script>";
    echo "<script>window.location.replace('profil.php?id_user=$userID');</script>";
} else {
    echo "Erreur, la suppression a échouée.";
}


?>
