<?php
include("DB_config.php");
// On récupère les data avec la méthode post
$id_user = $_POST["id_user"];
$id_post = $_POST["id_post"];
$id_likedislike=$_POST["id_likedislike"];
// ici sera stockée la valeur de l'action finale qui sera renvoyée au fichier javascript pour mettre à jour l'affichage

if($db = DB_connect()){
  // connexion à la db ...*

  // Préparation de la requête de recherche en BDD
  $req = "SELECT * FROM post WHERE id=$id_post";
  $req=pg_query($db,$req);
  $tuple=pg_fetch_assoc($req);
  $id_auteur=$tuple['author'];
  $req="SELECT * FROM action WHERE UID = $id_user AND PID = $id_post ";

  if($rep = pg_query($db,$req)){

    $nb_tuple = pg_num_rows($rep); //nbre de tuple reponse (normalement 0 ou 1)

    if($nb_tuple == 0){ // si pas encore d'entrée de type action
      create_like_action($id_user, $id_post,$id_likedislike,$id_auteur);

    }

    elseif($nb_tuple == 1){ //si on a 1 tuple : il existe deja une entrée like/dislike/nothing
      $tuple= pg_fetch_assoc($rep);
      $action=$tuple['action'];
      switch($action)
      {
        case 0:  // aucune action n'a été effectuée par l'user pour ce post
          if($id_likedislike){
            to_dislike($id_user, $id_post,$id_auteur);}
          else{
            to_like($id_user, $id_post,$id_auteur);
          }
          break;
        case 1: // l'user a deja like le post
          if($id_likedislike){
            to_dislike($id_user, $id_post,$id_auteur);
          }
          else {
            to_nothing($id_user, $id_post,$id_likedislike,$id_auteur);
          }
          break;
        case 2: // l'user a deja dislike le post
          if($id_likedislike){
            to_nothing($id_user, $id_post,$id_likedislike,$id_auteur);
          }
          else {
            to_like($id_user, $id_post,$id_auteur);
          }
        default:
          // dans le doute : on le rétablie a neutre
          break;
      }
    }
    // else nb tuple != 1 error
    //print("error : more than one action tuple");
    else{

      print("-3");}
  }
  else{
    //pb de reponse
    print("-2");

  }
  pg_close();
}
else{
  // pb de connection
  print("-1");
}

function to_dislike($id_user,$id_post,$id_auteur)
{
  if($db = DB_connect()){
    // connexion à la db ...

    // Préparation de la requête de recherche BDD
    $req = "UPDATE action SET action=2 WHERE UID=$id_user AND PID=$id_post";

    if($rep = pg_query($db,$req))
    {
      // on a modifié la valeur finale de l'action
      $req="UPDATE post SET \"like\"=\"like\"-1 WHERE id=$id_post";
      if(pg_query($db,$req)){
        $req="UPDATE \"user\" SET score=score-1 WHERE id=$id_auteur";
        if(pg_query($db,$req)){
          print("2");}
        else{
          print("-2");
        }
      }
      else{
        print("-2");
      }
    }
    else{
      //pb de reponse
      //print("error : response from database");
      print("-2");
    }
  }
  else{
    // pb de connection
    //print("error : connection to database");
    print("-1");
  }
}

function to_like($id_user,$id_post,$id_auteur)
{
  if($db = DB_connect()){
    // connexion à la db ...*

    // Préparation de la requête de recherche BDD
    $req = "UPDATE action SET action = 1 WHERE UID = $id_user AND PID = $id_post ";

    if($rep = pg_query($db,$req))
    {
      // on a modifié la valeur finale de l'action
      $req="UPDATE post SET \"like\"=\"like\"+1 WHERE id=$id_post";
      if(pg_query($db,$req)){
        $req="UPDATE \"user\" SET score=score+1 WHERE id=$id_auteur";
        if(pg_query($db,$req)){
          print("1");}
        else{
          print("-2");
        }}
      else{
        print("-2");
      }

    }
    else{
      //pb de reponse
      print("-2");
    }

  }
  else{
    //print("error : connection to database");
    alert_error_connect();
    print("-1");
  }
}

function to_nothing($id_user,$id_post,$likedislike,$id_auteur)
{
  if($db = DB_connect()){
    // connexion à la db ...*

    // Préparation de la requête de recherche BDD
    $req = "UPDATE action SET action = 0 WHERE UID = $id_user AND PID = $id_post ";

    if($rep = pg_query($db,$req))
    {
      // on a modifié la valeur finale de l'action

      if($likedislike){
        $req="UPDATE post SET \"like\"=\"like\"+1 WHERE id=$id_post";
        if(pg_query($db,$req)){
          $req="UPDATE \"user\" SET score=score+1 WHERE id=$id_auteur";
          if(pg_query($db,$req)){
            print("0");}
          else{
            print("-2");
          }
        }
        else{
          print("-2");
        }
      }
      else{
        $req="UPDATE post SET \"like\"=\"like\"-1 WHERE id=$id_post";
        if(pg_query($db,$req)){
          $req="UPDATE \"user\" SET score=score-1 WHERE id=$id_auteur";
          if(pg_query($db,$req)){
            print("0");}
          else{
            print("-2");
          }
        }
        else{
          print("-2");
        }
      }

    }
    else{
      //pb de reponse
      //print("error : response from database");
      print("-2");
    }
  }
  else{
    // pb de connection
    print("-1");
  }
}

function create_like_action($id_user, $id_post,$id_likedislike,$id_auteur)
{
  if($db = DB_connect()){
    // connexion à la db ...*

    // Préparation de la requête de recherche BDD
    if($id_likedislike){
      $req = "INSERT INTO action VALUES ($id_user,$id_post,clock_timestamp(),2)";
    }
    else{
      $req = "INSERT INTO action VALUES ($id_user,$id_post,clock_timestamp(),1)";
    }

    if($rep = pg_query($db,$req))
    {
      if($id_likedislike) {
        // on a modifié la valeur finale de l'action
        $req="UPDATE post SET \"like\"=\"like\"-1 WHERE id=$id_post";
        if(pg_query($db,$req)){
          $req="UPDATE \"user\" SET score=score-1 WHERE id=$id_auteur";
          if(pg_query($db,$req)){
            print("2");}
          else{
            print("-2");
          }
        }
        else{
          print("-2");
        }
      }
      else{
        $req="UPDATE post SET \"like\"=\"like\"+1 WHERE id=$id_post";
        if(pg_query($db,$req)){
          $req="UPDATE \"user\" SET score=score+1 WHERE id=$id_auteur";
          if(pg_query($db,$req)){
            print("1");}
          else{
            print("-2");
          }
        }
        else{
          print("-2");
        }
      }
    }
    else{
      //pb de reponse
      //print("error : response from database");
      print("-2");
    }
  }
  else{
    // pb de connection
    //print("error : connection to database");
    print("-3");
  }
}

?>