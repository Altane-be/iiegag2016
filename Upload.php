<?php
session_start();
if(!($_SESSION['pseudo']))
{
    header('Location:Accueil.php');
}
include("html_env.php");
html_header("Ulpoad du Post - IIE-gag");
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>IIE Gag</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap.min.css">
    </head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top nav-justified">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="home.php">IIE Gag</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="hot.php">Hot</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php
            $pseudo=$_SESSION['pseudo'];
            $iduserconnec=$_SESSION['id'];
            print "<form style=\"display: inline\" action=\"profil.php\" method=\"get\">";
            print "<input type=\"hidden\" name=\"id_user\" value=\"$iduserconnec\">";
            print "</form>";
            print "<li style=\"display:inline\"><a href=\"profil.php?id_user=$iduserconnec\"><p>$pseudo</p></a></li>";
            ?>
            <li><button class="btn-sm btn-info navbar-btn" onclick="document.location.href='Upload.php';">Upload</button></li>
            <li><p>---</p></li>
            <li><button class="btn-sm btn-danger navbar-btn" onclick="document.location.href='Verifphp/logout.php';">Deconnexion</button></li>
            <li><p>---</p></li>
        </ul>
    </div>
</nav>
<br/><br/><br/><br/>
            <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <br/><br/><br/><br/><br/><br/><br/>
                    <center>
            <div class="well">
<h1>Upload ton Post</h1></br></br>
<form method="POST" action="Verifphp/upload_verif.php" enctype="multipart/form-data">
    <label for="titre_image">Titre de l'image :</label></br>
    <input type="text" size="50" maxlenght="50" onkeyup="maxlength(this, 50);" name="titre_image" placeholder="Titre" id="titre_image" autofocus /></br></br>
    <label for="description_image">Description de l'image :</label></br>
    <textarea name="description_image" size="50" id="description_image" placeholder="Je décris mon post.."></textarea></br></br>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
    <label for="image">Image (.jpeg .jpg .gif ou .png) : </label><input type="file" class="btn btn-info" name="image" id="image" onmouseleave="champ_vide();"/></br></br>
    <input type="submit" class="btn btn-success" name="bouton_envoyer" id="bouton_envoyer" value="Envoyer l'image" disabled="true" />
</form>
                </div>
            </center>
            </div>
<div class="col-sm-4"></div>



<script>
    function champ_vide(){
        var valeur1 = document.getElementById('image').value;
        var valeur2 = document.getElementById('titre_image').value;
        var valeur3 = document.getElementById('description_image').value;
        if( (valeur1 == "") || (valeur2 == "") || (valeur3 == "") ){
            document.getElementById('bouton_envoyer').disabled = true;
        }
        else{
            document.getElementById('bouton_envoyer').disabled = false;
        }
    }
    
    function maxlength(element, max) {
        value = element.value;
        max = parseInt(max);
        if(value.length >= max){
            element.value = value.substr(0, max);
        }
    }
</script>
<?php
html_footer();
?>