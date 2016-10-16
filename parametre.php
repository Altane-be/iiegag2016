<?php session_start();
if(!($_SESSION['pseudo']))
{
    header('Location:Accueil.php');
}
include("html_env.php");
html_header("Paramètres de votre compte");
?>
<!DOCTYPE html>
<html>
<head>
    <title>IIE Gag - Paramètres</title>
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
            print "<li style=\"display:inline\"><a href=\"profil.php?id_user=$iduserconnec\"><p>$pseudo</p></a></li>";
            ?>
            <li><button class="btn-sm btn-info navbar-btn" onclick="document.location.href='Upload.php';">Upload</button></li>
            <li><p>---</p></li>
            <li><button class="btn-sm btn-danger navbar-btn" onclick="document.location.href='Verifphp/logout.php';">Deconnexion</button></li>
            <li><p>---</p></li>
        </ul>
    </div>
</nav>
<br/>
<br/>
<br/>
<br/>
<br/>
<div class="col-sm-4"></div>
<div class="col-sm-4">
    <center>
<section id="change">
    <div class="mail">
        
        <form action="Change_Mail.php" method="post" id="form_change_mail">
            <label for="email_change_email">Vous avez changez d'adresse mail ? Renseignez nous la nouvelle :</label>
            <br/><br/>
                <input class="form-control" type="email" name="email_change_email" id="email_change_email" onkeyup="champ_vide(document.getElementById('bouton_valider_change_mail'), document.getElementById('email_change_email').value);" value="<?=$_SESSION['mail']?>"/>
                <br/>
                <input class="btn btn-info" type="submit" value="Enregistrer" id="bouton_valider_change_mail"/>
            <br/><br/>
        </form>
    </div>
        <p>Si vous le souhaitez vous pouvez modifier votre mot de passe. Pour ce faire, remplissez les 3 champs ci dessous :</p>
    <br/>
        <form action="Change_Pass.php" method="post" id="form_change_pass">
            <label for="old_pass_change_pass">Entrez votre mot de passe actuel : </label>
            <br/><br/>
            <input class="form-control" type="password" name="old_pass_change_pass" id="old_pass_change_pass" size="15" onkeyup="champ_vide();"/> <br/>
            <label for="new_pass_change_pass">Entrez votre nouveau mot de passe : </label>
            <br/><br/>
            <input class="form-control" type="password" name="new_pass_change_pass" id="new_pass_change_pass" size="15" onkeyup="champ_vide();"/><br/>
            <label for="confirm_pass_change_pass">Ressaisissez votre nouveau mot de passe : </label>
            <br/><br/>
            <input class="form-control" type="password" name="confirm_pass_change_pass" id="confirm_pass_change_pass" size="15" onkeyup="champ_vide(document.getElementById('bouton_valider_change_pass'),document.getElementById('old_pass_change_pass').value , document.getElementById('new_pass_change_pass').value , document.getElementById('confirm_pass_change_pass').value);"/><br/>
            <input class="btn btn-success" type="submit" value="Valider" id="bouton_valider_change_pass" disabled="true"/>
            <br/><br/>
        </form>
    <div class="quote">
        <form action="Change_Quote.php" method="post" id="form_change_quote">
            <label for="quote_change_quote">Ecrivez ci dessous votre phrases personnel, celle qui caractérise le plus votre état d'esprit actuel :</label>
            <br/><br/>
            <textarea rows="5" cols="60" class="center" name="quote_change_quote" id="quote_change_quote" onkeyup="champ_vide(document.getElementById('bouton_valider_change_quote'),document.getElementById('quote_change_quote').value);"><?php echo $_SESSION['quote']; ?></textarea><br/>
            <br/>
            <input class="btn btn-info" type="submit" value="Enregistrer" id="bouton_valider_change_quote" disabled="true"/>
            <br/><br/>
        </form>
    </div>
</section>
<section id="delete">
    <form action="Delete_User.php" method="post" id="form_delete_user">
        <label for="pass_delete_user">Si vous souhaitez supprimer votre compte, entrez votre mot de passe et validez : </label>
        <br/><br/>
        <input class="form-control" type="password" name="pass_delete_user" id="pass_delete_user" onkeyup="champ_vide(document.getElementById('bouton_valider_delete_user'),document.getElementById('pass_delete_user').value);" />
        <br/>
        <input class="btn btn-danger" type=button value="Supprimer mon compte" onClick="ConfirmMessage()" id="bouton_valider_delete_user" disabled="true"/>
    </form>
    <br/>
    <br/>
    <br/>
    <script>
        function ConfirmMessage() {
            if(confirm("Voulez-vous vraiment supprimer votre compte ?")) {
                document.getElementById('form_delete_user').submit();
            }
        }
        
        function champ_vide(arg1, arg2, arg3, arg4) {
            if(typeof arg4 === 'undefined') {
                if (typeof arg3 === 'undefined') {
                    if (arg2 == "") {
                        arg1.disabled = true;
                    }
                    else {
                        arg1.disabled = false;
                    }
                }
                else {
                    if ((arg2 == "") || (arg3 == "")) {
                        arg1.disabled = true;
                    }
                    else {
                        arg1.disabled = false;
                    }
                }
            }
            else{
                if ((arg2 == "") || (arg3 == "") || (arg4 == "")) {
                    arg1.disabled = true;
                }
                else {
                    arg1.disabled = false;
                }
            }
        }
    </script>
</section>
        </center>
    </div>


</body>
</html>
<?php
html_footer();
?>
