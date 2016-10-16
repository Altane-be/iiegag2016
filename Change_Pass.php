<?php session_start();

include("html_env.php");
include("DB_config.php");

html_header("Modification du mot de passe");
$DB = DB_connect();
$old_pass=pg_escape_string($DB,$_POST['old_pass_change_pass']);
$new_pass=pg_escape_string($DB,$_POST['new_pass_change_pass']);
$confirm_pass=pg_escape_string($DB,$_POST['confirm_pass_change_pass']);

if (password_verify($old_pass,$_SESSION['password']))
{
    if ($old_pass==$confirm_pass)
    {
        

        $query = pg_prepare($DB, "update_pass_query","UPDATE \"user\" SET password = $1 WHERE pseudo = $2");

        $hash_pass=password_hash($new_pass,PASSWORD_DEFAULT);

        $result=pg_execute($DB,"update_pass_query",array($hash_pass, $_SESSION['pseudo']));

        if ($result!=false)
        {
            $_SESSION['password']=$hash_pass;
            echo "Votre mot de passe a bien été modifié, vous allez etre redirigé !";
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 5000); </SCRIPT>";
        }
        else
        {
            echo "Une erreur est survenue, veuillez retenter ulterieurement";
            echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 5000); </SCRIPT>";
        }
    }
    else
    {
        echo "Les deux mot de passe ne correspondent pas, veuillez réessayer !";
        echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 5000); </SCRIPT>";
    }
}
else
{
    echo "Vous n'êtes pas autorisé à faire cette action (mot de passe éronné)";
    echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"parametre.php\";}, 5000); </SCRIPT>";
}
pg_close($DB);
html_footer();
?>