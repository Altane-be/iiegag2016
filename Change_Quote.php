<?php session_start();

include("html_env.php");
include("DB_config.php");

html_header("Modification de la phrase personelle");
$DB = DB_connect();
$quote=pg_escape($DB,$_POST['quote_change_quote']);

if ($quote!=$_SESSION['quote'])
{
    
    $query = pg_prepare($DB, "update_quote_query","UPDATE \"user\" SET quote = $1 WHERE pseudo = $2");
    
    $pseudorecu = pg_escape($DB,['pseudo']);
    if($_POST['pseudo']){
        $query2 = pg_query($DB,"SELECT * FROM \"user\" WHERE pseudo LIKE '$pseudorecu';");
        if($query2) {
            $nbTuples = pg_num_rows($query2);
            if ($nbTuples != 0) {
                echo "<script> alert(\"Ce pseudo existe déjà..\")</script>";
                echo "<script>window.location.replace('../Inscription.php')</script>";
            } else {
                $pseudorecu = pg_escape_string($_POST['pseudo']);
                $result = pg_execute($DB, "update_quote_query", array($quote, $pseudorecu));
                if ($result) {
                    $_SESSION['quote'] = $quote;
                    echo "<script> alert(\"Votre phrase personnelle a bien été ré-initialisé\")</script>";
                    flush();
                    sleep(5);
                    echo "<script>window.location.replace('administration.php')</script>";
                } else {
                    echo "<script> alert(\"Une erreur est survenue, veuillez retenter ulterieurement\")</script>";
                    flush();
                    sleep(5);
                    echo "<script>window.location.replace('administration.php')</script>";
                }
            }
        }
        else {
            echo "<script> alert(\"Une erreur est survenue, veuillez retenter ulterieurement\")</script>";
            flush();
            sleep(5);
            echo "<script>window.location.replace('administration.php')</script>";
        }
    }
    else {
        $result = pg_execute($DB, "update_quote_query", array($quote, $_SESSION['pseudo']));

        if ($result) {
            $_SESSION['quote'] = $quote;
            echo "<script> alert(\"Votre phrase personnelle a bien été mise à jour !\")</script>";
            flush();
            sleep(5);
            echo "<script>window.location.replace('parametre.php')</script>";
        } else {
            echo "<script> alert(\"Une erreur est survenue, veuillez retenter ulterieurement\")</script>";
            flush();
            sleep(5);
            echo "<script>window.location.replace('parametre.php')</script>";
        }
    }
}
else
{
    echo "<script> alert(\"Vous n'avez pas modifié votre phrase personelle\")</script>";
    flush();
    sleep(5);
    echo "<script>window.location.replace('parametre.php')</script>";
}
pg_close($DB);
html_footer();
?>