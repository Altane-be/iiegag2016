<?php session_start();

include("html_env.php");
include("DB_config.php");

html_header("Modification de l'adresse email");

$DB = DB_connect();
$email=pg_escape_string($DB,$_POST['email_change_email']);

if ($email!=$_SESSION['mail'])
{
    $query = pg_prepare($DB, "update_email_query","UPDATE \"user\" SET mail = $1 WHERE pseudo = $2");

    $result=pg_execute($DB,"update_email_query",array($email, $_SESSION['pseudo']));

    if ($result!=false)
    {
        $_SESSION['mail']=$email;
        echo "Votre adresse email a bien été mise à jour, vous allez etre redirigé !";
        echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 3000); </SCRIPT>";
    }
    else
    {
        echo "Une erreur est survenue, veuillez retenter ulterieurement";
        echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 3000); </SCRIPT>";
    }
}
else
{
    echo "Vous n'avez pas modifié votre email";
    echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 3000); </SCRIPT>";
}

pg_close($DB);

html_footer();
?>
