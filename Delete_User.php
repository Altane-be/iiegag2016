<?php session_start();

include("html_env.php");
include("DB_config.php");
include("Delete.php");

html_header("Suppression de compte !");

$DB = DB_connect();
$pass_delete_user=pg_escape_string($DB,$_POST['pass_delete_user']);
$pass_delete_admin=pg_escape_string($DB,$_POST['pass_delete_admin']);


if (password_verify($pass_delete_user,$_SESSION['password']) || password_verify($pass_delete_admin,$_SESSION['password']))
{
    if($pass_delete_admin) {
        $pseudo = pg_escape_string($DB,$_POST['pseudo_del']);
        $query2 = pg_query($DB, "SELECT * FROM \"user\" WHERE pseudo LIKE '$pseudo';");
        if ($query2) {
            $nbTuples = pg_num_rows($query2);
            if ($nbTuples == 0) {
                echo "<script> alert(\"Ce pseudo n'existe pas..\")</script>";
                echo "<script>window.location.replace('administration.php')</script>";
            } else {
                $query3 = pg_query($DB,"SELECT us.id, us.pseudo, ad.admin FROM \"user\" us LEFT OUTER JOIN admin ad ON (us.id = ad.admin) WHERE us.pseudo='$pseudo';");
                if($query3)
                {
                    $array = pg_fetch_assoc($query3);
                    if($array['admin'] != NULL)
                    {
                        echo "<script> alert(\"Vous ne pouvez pas supprimer un administrateur..\")</script>";
                        echo "<script>window.location.replace('administration.php')</script>";
                    }
                    else
                    {
                        $userID = $array['id'];

                        delete_user($userID);
                        echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"administration.php\";}, 2000); </SCRIPT>";

                    }
                }
                else {
                    echo "<script> alert(\"Une erreur est survenue, veuillez retenter ulterieurement\")</script>";
                    echo "<script>window.location.replace('administration.php')</script>";
                }
            }
        }
        else {
            echo "<script> alert(\"Une erreur est survenue, veuillez retenter ulterieurement\")</script>";
            echo "<script>window.location.replace('administration.php')</script>";
        }
    }
    else {
        $userID = $_SESSION['id'];

        delete_user($userID);
        echo "<script> alert(\"Votre compte et tout ce qui vous concernait a été supprimé ... Good By My Friend !\")</script>";
        echo "<SCRIPT LANGUAGE=\"JavaScript\"> window.setTimeout(function(){window.location.href = \"Verifphp/logout.php\";}, 2000); </SCRIPT>";

    }
}
else
{
    echo "<script> alert(\"Vous n'êtes pas autorisé à faire cette action (mot de passe éronné)\")</script>";
    echo "<script>window.location.replace('home.php')</script>";
}
pg_close($DB);
html_footer();
?>

