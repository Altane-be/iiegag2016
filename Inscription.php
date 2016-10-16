<?php
session_start();
if(($_SESSION['pseudo']))
{
    header('Location:Accueil.php');
}

include("html_env.php");

html_header("Inscription - IIE-gag");
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="home.php">IIE Gag</a>
    </div>
  </div>
</nav>

<br/>
<br/><br/>
<br/>

<div class="col-sm-4"></div>
<div class="col-sm-4">
  <div class="form">
  		<center><h1>Inscription</h1>
  		<form action="Verifphp/Register.php" method="post" id="register-form">
      <div class="form-group">
  			<label for="register_mail">E-mail *:<br/></label>
  			<input class="form-control" type="email" size="50" onkeyup="champ_vide();" maxlength="255" name="register_mail" placeholder="E-mail" id="register_mail" autofocus/><br/><br/>
      </div>
      <div class="form-group">
  			<label for="register_pseudo">Pseudo *:<br/></label>
  			<input class="form-control" type="text" size="50" onkeyup="champ_vide();" maxlength="255" name="register_pseudo" placeholder="Pseudo" id="register_pseudo"/></br></br>
      </div>
      <div class="form-group">
  			<label for="register_password">Mot de passe *:</label></br>
  			<input class="form-control" type="password" size="50" onkeyup="champ_vide();" maxlength="255" name="register_password" placeholder="Mot de passe" id="register_password"/></br>
        </div>
      <div class="form-group">
  			<label for="confirm_password">Confirmation du mot de passe *:</label></br>
  			<input class="form-control" type="password" size="50" onkeyup="champ_vide();" maxlength="255" name="confirm_password" placeholder="Mot de passe" id="confirm_password" onblur="Verifmdp(this)"/></br></br>
      </div>
        <h2 id="donner_personnel">A propos de toi</h2>
        <br/>
        <div class="form-group">
        <label for="prenom_register">Prenom *:</label><br/>
        <input class="form-control"  type="text" size="50" onkeyup="champ_vide();" maxlength="30" name="prenom_register" placeholder="Prenom" id="prenom_register"/></br></br>
        </div>
        <div class="form-group">
        <label for="nom_register">Nom *:</label><br/>
        <input class="form-control" type="text" size="50" onkeyup="champ_vide();" maxlength="30" name="nom_register" placeholder="Nom" id="nom_register"/></br></br>
        </div>
        <div class="form-group">
        <label for="quote_register">Citation personnelle :</label><br/>
        <input class="form-control" type="text" size="50" maxlength="255" name="quote_register" value="Je suis une Tanche !" id="quote_register"/></br></br>
        </div>
  			<input class="btn btn-success" type="submit" value="Envoyer" id="bouton_valider" disabled="true"/>
        <input type="button" value="Retour" class="btn btn-primary" onclick="javascript:location.href='Accueil.php'"/>
  		</form>

      <p>* Mention obligatoire</p>
  	</div>
  </div>
  </center>
  </div>
  </div>
  <script>

function Verifmdp(champ)
{
   if(champ.value != document.getElementById('register_password').value)
   {
      champ.style.backgroundColor = "#FFD9CF";
      document.getElementById('bouton_valider').disabled = true;
   }
   else if(champ.value == document.getElementById('register_password').value)
   {
       champ.style.backgroundColor = "#76FE76";
   }
   else
   {  
      champ.style.backgroundColor = "";
   }
}

function champ_vide()
{
  var valeur1 = document.getElementById('register_mail').value;
  var valeur2 = document.getElementById('register_pseudo').value;
  var valeur3 = document.getElementById('register_password').value;
  var valeur4 = document.getElementById('confirm_password').value;
  var valeur5 = document.getElementById('prenom_register').value;
  var valeur6 = document.getElementById('nom_register').value;
  if( (valeur1 == "") || (valeur2 == "" ) || (valeur3 == "" ) || (valeur4 == "" )  || (valeur5 == "" ) || (valeur6 == "" )) {
    document.getElementById('bouton_valider').disabled = true;
  }
  else{
    document.getElementById('bouton_valider').disabled = false; 
  }
}

  </script>

<?php
html_footer();
?>