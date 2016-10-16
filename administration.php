
<?php session_start();

include("html_env.php");


if(!($_SESSION['pseudo']))
{
    header('Location:Accueil.php');
}
else {
    if (!($_SESSION['admin'])) {
        header('Location:home.php');
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Page d'administration - IIE Gag</title>
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
            <div class="post">
                <p>En tant qu'administrateur, tu obtiens plusieurs droits supplémantaires sur le site : </p>
                <br/>
                <br/>
                <br/>
                <form action="Delete_Post.php" name="formulaire1" method="post" id="form_delete_post" onsubmit="return ConfirmMessagepost();">
                    <label for="id_post">Supprimer un post. Renseigne l'id du Post :</label>
                    <br/><br/>
                    <input class="form-control" type="texte" name="id_post" id="id_post" onkeyup="champ_vide(document.getElementById('bouton_valider_delete_post'), document.getElementById('id_post').value);" />
                    <br/>
                    <input class="btn btn-info" type="submit" value="Supprimer ce post" id="bouton_valider_delete_post" disabled="true"/>
                    <br/><br/>
                    <script>function ConfirmMessagepost() {return confirm("Voulez-vous vraiment supprimer ce post ?");}</script>
                </form>
            </div>

            <div class="quote">
                <form action="Change_Quote.php" method="post" id="form_change_quote" onsubmit="return ConfirmMessagequote();">
                    <label for="quote_change_quote">Ré-initialisé la phrase phrases personnelle d'un utlisateur (par défaut : "Je suis une Tanche !")  Renseigne le pseudo de l'utilisateur  :</label>
                    <br/><br/>
                    <input class="form-control" type="texte" name="pseudo" id="pseudo" onkeyup="champ_vide(document.getElementById('bouton_valider_change_quote'), document.getElementById('pseudo').value);" />
                    <br/>
                    <input class="form-control" type="hidden" value="Je suis une Tanche !" name="quote_change_quote" id="quote_change_quote" onkeyup="champ_vide(document.getElementById('bouton_valider_change_quote'), document.getElementById('pseudo').value);" />
                    <br/>
                    <input class="btn btn-info" type="submit" value="Re-initialiser" id="bouton_valider_change_quote" disabled="true"/>
                    <br/><br/>
                    <script>function ConfirmMessagequote() {return confirm("Voulez-vous vraiment ré-initialisé sa phrase personnelle ?");}</script>
                </form>
            </div>
            <br/>
            <br/>
            <div class="admin">
                <form action="Verifphp/Upgrade_admin.php" name="formulaire3" method="post" id="form_delete_post" onsubmit="return ConfirmMessageadmin();">
                    <label for="pseudo_admin">Ajouter un administrateur. Renseigne son pseudo :</label>
                    <br/><br/>
                    <input class="form-control" type="texte" name="pseudo_admin" id="pseudo_admin" onkeyup="champ_vide(document.getElementById('bouton_valider_updgrade_admin'), document.getElementById('pseudo_admin').value);" />
                    <br/>
                    <?php
                    $id_admin = $_SESSION['id'];
                    print "<input type=\"hidden\" name=\"id_admin\" style=\"display: inline\" id=\"id_admin\" value=\"$id_admin\">"
                    ?>
                    
                    <input class="btn btn-info" type="submit" value="Ajouter cet administrateur" id="bouton_valider_updgrade_admin" disabled="true"/>
                    <br/><br/>
                    <script>function ConfirmMessageadmin() {return confirm("Voulez-vous l'ajouter en tant qu'administrateur ?");}</script>
                </form>
            </div>

        </section>
        <section id="delete">
            <br/><br/><br/><br/>
            <form action="Delete_User.php" method="post" id="form_delete_user">
                <label for="pseudo_del">Supprimer un compte, entrez le pseudo de l'utilisateur a supprimer : </label>
                <br/><br/>
                <input class="form-control" type="texte" name="pseudo_del" id="pseudo_del" onkeyup="champ_vide(document.getElementById('bouton_valider_delete_user'), document.getElementById('pseudo_del').value,document.getElementById('pass_delete_admin').value);" />
                <br/>
                <label for="pass_delete_admin">Entrez votre mot de passe : </label>
                <br/><br/>
                <input class="form-control" type="password" name="pass_delete_admin" id="pass_delete_admin" onkeyup="champ_vide(document.getElementById('bouton_valider_delete_admin'), document.getElementById('pseudo_del').value,document.getElementById('pass_delete_admin').value);" />
                <br/>
                <input class="btn btn-danger" type=button value="Supprimer ce compte" onClick="ConfirmMessage()" id="bouton_valider_delete_user" disabled="true"/>
            </form>
            <br/>
            <br/>
            <br/>
            <script>
                function ConfirmMessage() {
                    if(confirm("Voulez-vous vraiment supprimer ce compte ?")) {
                        document.getElementById('form_delete_admin').submit();
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
