<?php

function delete_user($id_user)
{
    $userID=intval($id_user);
    $DB = DB_connect();

    $delete_user_query = pg_prepare($DB, "delete_user_entry","DELETE FROM \"user\" WHERE id = $1");

    $delete_admin_query = pg_prepare($DB, "delete_post_entry", "DELETE FROM \"admin\" WHERE admin = $1");

    $delete_action_query = pg_prepare($DB, "delete_action_entry","DELETE FROM \"action\" WHERE uid = $1 AND pid = $2");
    $select_action_query = pg_prepare($DB, "select_action_entry", "SELECT pid FROM \"action\" WHERE uid = $1");
    $update_like_query = pg_prepare($DB, "update_like_entry", "UPDATE \"post\" SET \"like\" = \"like\"-1 WHERE id = $1");

    $select_author_query = pg_prepare($DB, "select_author_entry", "SELECT author FROM \"post\" WHERE id = $1");
    $update_score_query = pg_prepare($DB, "update_score_entry", "UPDATE \"user\" SET score = score-1 WHERE id = $1");

    $select_post_query =  pg_prepare($DB, "select_post_entry", "SELECT id FROM \"post\" WHERE author = $1");


    $select_action_result = pg_execute($DB,"select_action_entry",array($userID));
    $select_action_array = pg_fetch_assoc($select_action_result);

    if($select_action_array)
    {
        while($select_action_array)
        {
            echo "found";
            $postID = $select_action_array['pid'];

            $select_author_result = pg_execute($DB,"select_author_entry",array($postID));
            $select_author_array = pg_fetch_assoc($select_author_result);

            if($select_author_array)
            {
                $author=$select_author_array['author'];
                $update_score_result = pg_execute($DB,"update_score_entry",array($author));
            }
            $update_like_result = pg_execute($DB,"update_like_entry",array($postID));

            $delete_action_result = pg_execute($DB,"delete_action_entry",array($userID,$postID));
            echo "supprimé";
            $select_action_array=pg_fetch_assoc($select_action_result);
        }
    }

    $select_post_result = pg_execute($DB,"select_post_entry",array($userID));
    $select_post_array = pg_fetch_assoc($select_post_result);

    if($select_post_array)
    {
        while($select_post_array)
        {
            $postID = $select_post_array['id'];
            delete_post($userID,$postID,$DB);
            $select_post_array = pg_fetch_assoc($select_post_result);
        }
    }

    $delete_user_result = pg_execute($DB,"delete_user_entry",array($userID));
    $delete_admin_result = pg_execute($DB,"delete_admin_query",array($userID));
    echo "Utilisateur supprimé !";

    pg_close($DB);
}





function delete_post($id_user,$id_post,$DB)
{
    $userID=intval($id_user);
    $postID=intval($id_post);

    //echo $postID;
    $delete_action_query = pg_prepare($DB, "delete_action_entry", "DELETE FROM \"action\" WHERE pid = $1");
    $delete_post_query = pg_prepare($DB, "delete_post_entry", "DELETE FROM \"post\" WHERE id = $1");
    
    $update_count_query = pg_prepare($DB, "update_count_entry", "UPDATE \"user\" SET cpost = cpost-1 WHERE id = $1");
    $update_score_query = pg_prepare($DB, "update_score_entry", "UPDATE \"user\" SET score = score-$1 WHERE id = $2");

    $delete_action_result = pg_execute($DB, "delete_action_entry", array($postID));
    $num_action_deleted = pg_affected_rows($delete_action_result);
    //echo $num_action_deleted;

    $update_user_result = pg_execute($DB, "update_count_entry", array($userID));
    $update_user_result = pg_execute($DB, "update_score_entry", array($num_action_deleted,$userID));

    $delete_post_result = pg_execute($DB, "delete_post_entry", array($postID));
    if( $DB ) {
        $query2 = pg_query($DB, "SELECT isgif FROM post WHERE id=$postID;");
        if ($query2) {
            $array2 = pg_fetch_assoc($query2);
            if ($array2['isgif'] == 1) {
                unlink('image/post/'.$postID.'.gif');
            } else {
                unlink('image/post/'.$postID.'.jpg');
                unlink('../image/side/side_'.$postID.'.jpg');
            }
        } else {
            print "<h1>Erreur pg_query</h1>";
        }
    }
    else{
        print "<h1>Erreur pg_connect</h1>";
    }
    return true;
}
?>