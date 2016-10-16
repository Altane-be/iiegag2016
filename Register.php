<?php
session_start();
$mail = ($_POST['register_mail']);
$pseudo = $_POST['register_pseudo'];
$mdp = $_POST['register_password'];
$conf_mdp = $_POST['confirm_password'];
$prenom = $_POST['prenom_register'];
$nom = $_POST['nom_register'];
$quote = pg_escape_string($_POST['quote_register']);
if( !(isset($quote)) || ($quote=="") ){
	$quote = "Je suis une Tanche !";
}

if( (isset($mail)) && ($mail!="")){
	if( (isset($pseudo)) &&($pseudo!="")){
		if( (isset($mdp)) &&($mdp!="")){
			if( $mdp == $conf_mdp){
				if( (isset($prenom)) &&($prenom!="")){
					if( (isset($nom)) &&($nom!="")){
						if($DB = pg_connect("host=127.0.0.1 user=IIE-gag dbname=IIE-gag-DB password=inovia2016")){
							$query2 = pg_query($DB,"SELECT * FROM \"user\" WHERE pseudo LIKE '$pseudo';");
							if($query2){
								$nbTuples = pg_num_rows($query2);
								if($nbTuples != 0){
									echo "<script> alert(\"Ce pseudo existe déjà..\")</script>";
									echo "<script>window.location.replace('../Inscription.php')</script>";
								}
								else{
									$query3 = pg_query($DB,"SELECT * FROM \"user\" WHERE mail LIKE '$mail';");
									if ($query3){
										$nbTuples2 = pg_num_rows($query3);
										if($nbTuples2 != 0){
											echo "<script> alert(\"Cet email existe déjà..\")</script>";
											echo "<script>window.location.replace('../Inscription.php')</script>";
										}
										else{
											$passhash = password_hash($mdp,PASSWORD_DEFAULT);
											$query = pg_query($DB,"INSERT INTO \"user\" (pseudo,password,mail,lname,fname,date,quote) VALUES ('$pseudo','$passhash','$mail','$nom','$prenom',now(),'$quote');");
											if($query){
												pg_close();
												echo "<script> alert(\"Inscription reussie ! Maintenant, connectez-vous !\")</script>";
											echo "<script>window.location.replace('../Accueil.php')</script>";
											}
											else{
												pg_close();
												echo "<script> alert(\"Inscription echouee\")</script>";
												echo "<script>window.location.replace('../Inscription.php')</script>";
											}
										}
									}
									else{
										pg_close($DB);
										echo "<script> alert(\"Erreur connexion base de données.. réessayez ultérieurement\")</script>";
										echo "<script>window.location.replace('../Inscription.php')</script>";
									}
								}
							}
							else{
								pg_close($DB);
								echo "<script> alert(\"Erreur connexion base de données.. réessayez ultérieurement\")</script>";
								echo "<script>window.location.replace('../Inscription.php')</script>";
							}
						}
						else{
							pg_close($DB);
							echo "<script> alert(\"Erreur connexion base de données.. réessayez ultérieurement\")</script>";
							echo "<script>window.location.replace('../Inscription.php')</script>";
						}
					}
					else{
						echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer un NOM..\")</script>";
						echo "<script>window.location.replace('../Inscription.php')</script>";
					}
				}
				else{
					echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer un PRENOM..\")</script>";
					echo "<script>window.location.replace('../Inscription.php')</script>";
				}
			}
			else{
				echo "<script> alert(\"Vous avez mal confirmé votre mot de passe..\")</script>";
				echo "<script>window.location.replace('../Inscription.php')</script>";
			}
		}
		else{
			echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer un NOM..\")</script>";
			echo "<script>window.location.replace('../Inscription.php')</script>";
		}
	}
	else{
		echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer un PSEUDO..\")</script>";
		echo "<script>window.location.replace('../Inscription.php')</script>";
	}
}
else{
	echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer une ADRESSE E-MAIL..\")</script>";
	echo "<script>window.location.replace('../Inscription.php')</script>";
}
?>
