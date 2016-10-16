<?php
session_start();
$user = $_POST['user_pseudo'];
$mdp = $_POST['user_password']; 
if( (isset($user)) && ($user!="")){/*dans le cas où l'user n'est pas rentré*/
	if( (isset($mdp)) &&($mdp!="")){
		if($DB = pg_connect("host=127.0.0.1 user=IIE-gag dbname=IIE-gag-DB password=inovia2016"))
		{
			$query = pg_query($DB,"SELECT * FROM \"user\";");
			if($query)
			{
				while ($array = pg_fetch_assoc($query))
				{	
					$name = $array['pseudo'];
					if($name == $user)
					{
						$pwd = $array['password'];
						if(password_verify($mdp,$pwd))
						{
							$_SESSION['pseudo'] = $user;
							$_SESSION['password'] = password_hash($mdp,PASSWORD_DEFAULT);
							$_SESSION['mail'] = $array['mail'];
							$_SESSION['id'] = $array['id'];
							$_SESSION['lname'] = $array['lname'];
							$_SESSION['fname'] = $array['fname'];
							$_SESSION['quote'] = $array['quote'];
							$_SESSION['score'] = $array['score'];
							$_SESSION['cpost'] = $array['cpost'];

							$query2 = pg_query($DB,"SELECT us.pseudo, ad.admin FROM \"user\" us LEFT OUTER JOIN admin ad ON (us.id = ad.admin) WHERE us.pseudo='$user';");
							if($query2)
							{
								$array = pg_fetch_assoc($query2);
								if($array['admin'] != NULL)
								{
									$_SESSION['admin'] = 1;
								}
								else
								{
									$_SESSION['admin'] = 0;
								}
							}
							pg_close();
							echo "<script>window.location.replace('../home.php')</script>";
						}
						
						else
						{	
							pg_close();
							echo "<script> alert('Mot de passe incorrect')</script>";
							echo "<script>window.location.replace('../Accueil.php')</script>";
							
						}
					}
				}
				pg_close();
				echo "<script> alert(\"Pseudo inconnu..\")</script>";
				echo "<script>window.location.replace('../Accueil.php')</script>";
			}
			else{
				echo "<script> alert(\"Erreur execution requete.. réessayez ultérieurement\")</script>";
				echo "<script>window.location.replace('../Accueil.php')</script>";
			}
		}
		else{
			echo "<script> alert(\"Erreur connexion base de données.. réessayez ultérieurement\")</script>";
			echo "<script>window.location.replace('../Accueil.php')</script>";
		}
		pg_close($DB);
	}
	else{
		echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer un MOT DE PASSE..\")</script>";
		echo "<script>window.location.replace('../Accueil.php')</script>";
	}
}
else{
	echo "<script> alert(\"Vous devez OBLIGATOIREMENT rentrer nom d'utilisateur..\")</script>";
	echo "<script>window.location.replace('../Accueil.php')</script>";
}

?>
