<?php
session_start();
if(!($_SESSION['pseudo']))
{
    header('Location:Accueil.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>IIE Gag -Top 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top  nav-justified">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="home.php">IIE Gag</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="home.php">Hot</a></li>
            <li><a href="#">Trending</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            $pseudo=$_SESSION['pseudo'];
            $iduserconnec=$_SESSION['id'];
            print "<form style=\"display: inline\" action=\"profil.php\" method=\"get\">";
            print "<input style=\"display: inline\" type=\"hidden\" name=\"id_user\" value=\"$iduserconnec\">";
            print "</form>";
            print "<li><a href=\"profil.php?id_user=$iduserconnec\"><p>$pseudo</p></a></li>";
            ?>
            <li><button class="btn-sm btn-info navbar-btn" onclick="document.location.href='Upload.php';">Upload</button></li>
            <li><p>---</p></li>
            <li><button class="btn-sm btn-danger navbar-btn" onclick="document.location.href='Verifphp/logout.php';">Deconnexion</button></li>
            <li><p>---</p></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <div class="well">
                <h4><b>Liste des membres les plus actifs</b></h4>
                <?php
                include("DB_config.php");
                if ( $DB = DB_connect() )
                {
                    $requete="SELECT * FROM \"user\" ORDER BY score DESC LIMIT(5)";
                    $reponse=pg_query($DB,$requete);
                    $nbTuples=pg_num_rows($reponse);
                    if($reponse){
                        for($i=1;$i<=$nbTuples;$i++){
                            $tuplecourant=pg_fetch_assoc($reponse,$i-1);
                            $pseudo=$tuplecourant['pseudo'];
                            $score=$tuplecourant['score'];
                            $id = $tuplecourant['id'];
                            print "<p>$i . <a style=\"display: inline\" href=\"profil.php?id_user=$id\">$pseudo</a> : $score </p>";}
                        //print "<div style=\"display: inline\"><small>Fait par : <a style=\"display: inline\" href=\"profil.php?id_user=$auteur\">$auteurpseudo</a></small></div>";

                    }
                    else{
                        print "<h1>Erreur pg_query</h1>";
                    }
                    pg_close($DB);
                }
                else{
                    print "<h1>Erreur pg_connect</h1>";
                }
                ?>
            </div>
        </div>
        <div class="col-sm-6">

            <h3>Fixed Navbars</h3>
            <div class="well well-sm">
                <center><h1>Bienvenue sur IIE Gag !</h1>
                    <h2>Top 10 des posts les plus aimés !</h2></center>
            </div>

            <?php

            function affichage_post($id_post,$titre_post,$nb_like,$auteur){
                print "<a href=\"post.php?id_post=$id_post\"><h3 style=\"color:black\">$titre_post</h3></a>";
                if( $DB = DB_connect() ) {

                    $query2 = pg_query($DB, "SELECT isgif FROM post WHERE id='$id_post';");
                    if ($query2) {
                        $array2 = pg_fetch_assoc($query2);
                        if ($array2['isgif'] == 1) {
                            print "<a href=\"post.php?id_post=$id_post\"><img src=\"image/post/$id_post.gif\" alt=\"$id_post.gif\"></a>";
                        } else {
                            print "<a href=\"post.php?id_post=$id_post\"><img src=\"image/post/$id_post.jpg\" alt=\"$id_post.jpg\"></a>";
                        }
                    } else {
                        print "<h1>Erreur pg_query</h1>";
                    }
                }
                else{
                    print "<h1>Erreur pg_connect</h1>";
                }

                print "<form action=\"post.php\" method=\"get\">";
                print "<input type=\"hidden\" name=\"id_post\" value=\"$id_post\">";
                print "</form>";
                if ( $DB = DB_connect() )
                {
                    $requete="SELECT * FROM \"user\" WHERE id=$auteur";
                    $reponse=pg_query($DB,$requete);
                    if($reponse){
                        $tuplecourant=pg_fetch_assoc($reponse);
                        $auteurpseudo=$tuplecourant['pseudo'];
                        print "<div id=\"nblike-$id_post\" style=\"display: inline\"><small>Likes : $nb_like | | </small></div>";
                        print "<form style=\"display: inline\" action=\"profil.php\" method=\"get\">";
                        print "<input type=\"hidden\" name=\"id_user\" value=\"$auteur\">";
                        print "</form>";
                        print "<div style=\"display: inline\"><small>Fait par : <a style=\"display: inline\" href=\"profil.php?id_user=$auteur\">$auteurpseudo</a></small></div>";
                        print "<br/>";
                    }
                    else{
                        print "<h1>Erreur pg_query</h1>";
                    }
                    $iduserco=$_SESSION['id'];
                    $requete="SELECT * FROM action WHERE uid=$iduserco AND pid=$id_post";
                    $reponse=pg_query($DB,$requete);
                    if($reponse){
                        $tuplecourant=pg_fetch_assoc($reponse);
                        $nb_tuple = pg_num_rows($reponse);
                        if($nb_tuple==0){
                            print "<div style=\"display:inline\" id=\"like-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2($iduserco,$id_post,0,$nb_like)\"><h5><b>Like</h5></b></button></div>";
                            print "    ";
                            print "<div style=\"display:inline\" id=\"dislike-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2($iduserco,$id_post,1,$nb_like)\"><h5><b>Dislike</b></h5></button></div>";
                        }
                        else{
                            $action_user=$tuplecourant['action'];
                            if($action_user==0){
                                print "<div style=\"display:inline\" id=\"like-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2($iduserco,$id_post,0,$nb_like)\"><h5><b>Like</h5></b></button></div>";
                                print "    ";
                                print "<div style=\"display:inline\" id=\"dislike-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2($iduserco,$id_post,1,$nb_like)\"><h5><b>Dislike</b></h5></button></div>";
                            }
                            elseif ($action_user==1){
                                print "<div style=\"display:inline\" id=\"like-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2($iduserco,$id_post,0,$nb_like)\"><h5 style=\"color:#6475FF\"><b>Like</h5></b></button></div>";
                                print "    ";
                                print "<div style=\"display:inline\" id=\"dislike-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm disabled\"><h5><b>Dislike</b></h5></button></div>";
                            }
                            else{
                                print "<div style=\"display:inline\" id=\"like-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm disabled\" ><h5><b>Like</h5></b></button></div>";
                                print "    ";
                                print "<div style=\"display:inline\" id=\"dislike-$id_post\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2($iduserco,$id_post,1,$nb_like)\"><h5 style=\"color:#6475FF\"><b>Dislike</b></h5></button></div>";
                            }}}
                    else{
                        print"erreur query";
                    }}
                print "<br/>";
                print "<hr/>";
            }

            if ( $DB = DB_connect() )
            {
                $requete="SELECT * FROM post ORDER BY \"like\" DESC LIMIT 10";
                $reponse=pg_query($DB,$requete);
                if($reponse){
                    $nbTuples=pg_num_rows($reponse);
                    for ($i = 0; $i < $nbTuples ; $i++){
                        $tuplecourant=pg_fetch_assoc($reponse,$i);
                        affichage_post($tuplecourant['id'],$tuplecourant['title'],$tuplecourant['like'],$tuplecourant['author']);}
                }
                else{
                    print "<h1>Erreur 2 pg_query</h1>";
                }
            }
            else{
                print "<h1>Erreur pg_connect</h1>";
            }

            ?>
        </div>
        <div class="col-sm-3">
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <div class="well">
                <center><h4><b>Post au hasard</b></h4></center>
            </div>
            <br/>
            <?php
            function affichage_side_post($id_post,$titre_post){
                print "<a href=\"post.php?id_post=$id_post\"><h5 style=\"color:black\"><b>$titre_post</b></h5></a>";
                print "<a href=\"post.php?id_post=$id_post\"><img src=\"image/side/side_$id_post.jpg\" alt=\"$id_post.jpg\"></a>";
                print "<br/>";
                print "<hr/>";
            }


            if ( $DB = DB_connect())
            {
                $requete="SELECT * FROM post WHERE isgif=0 ORDER BY RANDOM() LIMIT 6";
                $reponse=pg_query($DB,$requete);
                if($reponse){
                    $nbTuples=pg_num_rows($reponse);
                    for ($i = 0; $i < $nbTuples ; $i++) {
                        $tuplecourant = pg_fetch_assoc($reponse, $i);
                        affichage_side_post($tuplecourant['id'], $tuplecourant['title']);
                    }
                }
                else{
                    print "<h1>Erreur 2 pg_query</h1>";
                }
            }
            else{
                print "<h1>Erreur pg_connect</h1>";
            }

            ?>

        </div>
    </div>
</div>

<script src='jquery.js'></script>
<script src='like.js'></script>


</body>
</html>