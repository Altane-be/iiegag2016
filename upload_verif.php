<?php
session_start();

define('MAX_SIZE', 2097152);    // Taille max en octets du fichier

// Tableaux de donnees
$tabExt = array('jpg', 'jpeg', 'png', 'gif', 'bmp');    // Extensions autorisees
$infosImg = array();

// Variables
$titre = htmlspecialchars(pg_escape_string($_POST['titre_image']));
$description = htmlspecialchars(pg_escape_string($_POST['description_image']));
$id_author = $_SESSION['id'];

$extension = '';
$message = '';


if(!empty($_POST))
{
    if( (isset($titre)) && ($titre!="") )
    {
        if(strlen($titre) <= 50) {
            if ((isset($description)) && ($description != "")) {
                if (!empty($_FILES['image']['name'])) {
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    if (in_array(strtolower($extension), $tabExt)) {
                        $infosImg = getimagesize($_FILES['image']['tmp_name']);
                        if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {
                            if ((filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE)) {
                                if (isset($_FILES['image']['error']) && UPLOAD_ERR_OK === $_FILES['image']['error']) {
                                    if ($DB = pg_connect("host=127.0.0.1 user=IIE-gag dbname=IIE-gag-DB password=inovia2016")) {
                                        $query = pg_query($DB, "INSERT INTO post (author,title,description,date,isgif) VALUES ('$id_author','$titre','$description',now(),0);");
                                        if ($query) {
                                            $query1 = pg_query($DB, "SELECT author,id FROM post WHERE id=(SELECT max(id) FROM post);");
                                            if ($query1) {
                                                $array = pg_fetch_assoc($query1);
                                                if ($id_author == $array['author']) {
                                                    $id_post = $array['id'];
                                                    $query2 = pg_query($DB, "UPDATE \"user\" SET cpost=cpost+1 WHERE id='$id_author';");
                                                    if ($query2) {
                                                        $NouvelleLargeur = 460;
                                                        $NouvelleHauteur = ((($NouvelleLargeur) / ($infosImg[0])) * $infosImg[1]);

                                                        $type = mime_content_type($_FILES['image']['tmp_name']);
                                                        if ((substr($type, 6)) == 'gif') {
                                                            $file_src = $_FILES['image']['tmp_name'];

                                                            system("convert $file_src -resize 460x$NouvelleHauteur ../image/post/$id_post.gif");

                                                            $_SESSION['cpost'] = $_SESSION['cpost'] + 1;
                                                            pg_query($DB, "UPDATE post SET isgif=1 WHERE id='$id_post';");
                                                            echo "<script> alert(\"Upload gif a ete réalisé avec succès !!\")</script>";
                                                            echo "<script>window.location.replace('../home.php')</script>";
                                                            exit;
                                                        } else {
                                                            $file_src = $_FILES['image']['tmp_name'];

                                                            system("convert $file_src -resize 460x$NouvelleHauteur ../image/post/$id_post.jpg");
                                                            system("convert ../image/post/$id_post.jpg -resize 300x ../image/side/side_$id_post.jpg");
                                                            $infosImgtmp = getimagesize("../image/side/side_$id_post.jpg");
                                                            $hauteur_tmp = $infosImgtmp[1];
                                                            $milieu_hauteur_tmp = (int)$hauteur_tmp / 2;
                                                            $debut_hauteur_miniature = $milieu_hauteur_tmp - 79;
                                                            system("convert ../image/side/side_$id_post.jpg -crop 300x158+0+$debut_hauteur_miniature ../image/side/side_$id_post.jpg");

                                                            $_SESSION['cpost'] = $_SESSION['cpost'] + 1;
                                                            pg_query($DB, "UPDATE post SET isgif=0 WHERE id='$id_post';");
                                                            echo "<script> alert(\"Upload a ete réalisé avec succès !!\")</script>";
                                                            echo "<script>window.location.replace('../home.php')</script>";
                                                        }
                                                    }
                                                } else {
                                                    pg_query($DB, "DELETE FROM post WHERE id='$id_post';");
                                                    $message = 'Erreur 1 de connexion base de donées.. réessayez ultérieurement';
                                                }
                                            } else {
                                                pg_query($DB, "DELETE FROM post WHERE id='$id_post';");
                                                $message = 'L\'upload 3 a échouée.. réessayez ultérieurement';
                                            }
                                        } else {
                                            $message = 'Erreur d\'inscription à la base de données.. réessayez ultérieurement';
                                        }
                                    } else {
                                        $message = 'Erreur 2 de connexion à la base de données.. réessayez ultérieurement';
                                    }
                                } else {
                                    $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                                }
                            } else {
                                $message = 'La taille de l\'image est trop élevée !';
                            }
                        } else {
                            $message = 'Le fichier à uploader n\'est pas une image !';
                        }
                    } else {
                        $message = 'L\'extension du fichier est incorrecte !';
                    }
                } else {
                    $message = 'Veuillez remplir le formulaire svp !';
                }
            } else {
                $message = 'Vous devez rentrer une description de l\'image.. ';
            }
        }
        else{
            $message = 'Le titre ne doit pas dépasser 50 caractère.. ';
        }
    }
    else
    {
        $message = 'Vous devez rentrer un titre d\'image.. ';
    }
}
else
{
    $message = ' Veuillez bien remplir le formulaire svp !';   
}

echo "<script> alert(\"$message\")</script>";
echo "<script>window.location.replace('../Upload.php')</script>";

?>
