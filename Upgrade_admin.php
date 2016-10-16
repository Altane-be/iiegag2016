

<?php
session_start();

$pseudo = $_POST['pseudo_admin'];
$id_admin = $_POST['id_admin'];

if( (isset($pseudo)) && ($pseudo!="")) {
    if ((isset($id_admin)) && ($id_admin != "")) {
        if($DB = pg_connect("host=127.0.0.1 user=IIE-gag dbname=IIE-gag-DB password=inovia2016")){
            $query = pg_query($DB,"SELECT * FROM \"user\" WHERE pseudo LIKE '$pseudo';");
            if($query) {
                $array = pg_fetch_assoc($query);
                $nbTuples = pg_num_rows($query);
                if ($nbTuples == 0) {
                    echo "<script> alert(\"Ce pseudo n'existe pas..\")</script>";
                    echo "<script>window.location.replace('../administration.php')</script>";
                }
                else{
                    $id_new_admin = $array['id'];
                    $query2 = pg_query($DB, "SELECT * FROM admin WHERE admin='$id_new_admin'");
                    if($query2){
                        $nbTuples = pg_num_rows($query2);
                        if ($nbTuples != 0) {
                            echo "<script> alert(\"Cet utilisateur est déjà administrateur..\")</script>";
                            echo "<script>window.location.replace('../administration.php')</script>";
                        }
                        else{
                            $query3 = pg_query($DB,"INSERT INTO admin (admin,root,date) VALUES ('$id_new_admin','$id_admin',now());");
                            if($query3){
                                pg_close();
                                echo "<script> alert(\"Ajout d'administrateur effectué avec succès\")</script>";
                                echo "<script>window.location.replace('../administration.php')</script>";
                            }
                            else {
                                echo "<script> alert(\"Ajout échoué.. réessayez ultérieurement\")</script>";
                                echo "<script>window.location.replace('../administration.php')</script>";
                            }
                        }
                    }
                    else {
                        echo "<script> alert(\"Erreur connexion base de données.. réessayez ultérieurement\")</script>";
                        echo "<script>window.location.replace('../administration.php')</script>";
                    }
                }
            }
            else {
                echo "<script> alert(\"Erreur lecture base de données.. réessayez ultérieurement\")</script>";
                echo "<script>window.location.replace('../administration.php')</script>";
            }
        }
        else {
            echo "<script> alert(\"Erreur connexion base de données.. réessayez ultérieurement\")</script>";
            echo "<script>window.location.replace('../administration.php')</script>";
        }
    }
    else {
        echo "<script> alert(\"Vous n'avez pas les droits.. \")</script>";
        echo "<script>window.location.replace('../administration.php')</script>";
    }
}
else {
    echo "<script> alert(\"Vous devez remplir le champs vide..\")</script>";
    echo "<script>window.location.replace('../administration.php')</script>";
}


?>


