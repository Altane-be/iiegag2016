<?php session_start();

if(($_SESSION['pseudo']))
{
    header('Location:home.php');
}


include("html_env.php");

html_header("Login - IIE-gag");
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
<br/><br/>
<br/><br/>
<br/><br/>
<br/>
	<div class="form-group">
  <div class="col-sm-5"></div>
  <div class="col-sm-2">
      <div class="well">
  <center>
  	  <h1>Login</h1>
  		<form action="Verifphp/Verif.php" method="post" id="login-form">
  			
  			<p><input class="form-control" type="text" size="50" maxlength="255" name="user_pseudo" placeholder="Pseudo" onkeyup="champ_vide();" id="username" autofocus />
        </p>
 	 		<input class="form-control" type="password" size="50" maxlength="255" name="user_password" placeholder="Password" id="connexion_user_password" onkeyup="champ_vide();"/>
	  		<button class="btn btn-info" style="float: right" type="button" onmousedown="Show_mdp();" onmouseup="Show_mdp();" id="bouton_show">Show</button>
  			<br/>
        <br/>
  			<input class="btn btn-success" type="submit" value="Valider" id="bouton_valider" disabled="true"/>
  			<br/>
  		</form>
  	
      <p>
        Tu n'es pas encore inscrit ?
      </p>
      <input type="button" value="Inscription" class="btn btn-primary" onclick="javascript:location.href='Inscription.php'"/>
    </center>
          </div>
    </div>
    </div id="register">
  <script>

  				
  				function Show_mdp(){
  					var mdp = document.getElementById('connexion_user_password');
  				var type = mdp.getAttribute('type');

  				if(type == "text"){
  					mdp.setAttribute('type', 'password');
  				}
  				else{
  					mdp.setAttribute('type', 'text');
  				}
  			}

        function champ_vide(){
          var valeur1 = document.getElementById('username').value;
          var valeur2 = document.getElementById('connexion_user_password').value;
          if( (valeur1 == "") || (valeur2 == "")){
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
