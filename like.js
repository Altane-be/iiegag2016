function mylikefunction2(iduser,idpost,idlikedislike,nblike){
	/*var button_like_id="boutton-like-"+id_post;
	 var button_dislike_id="boutton-dislike-"+id_post;
	 document.getElementById(button_like_id).innerHTML = "<button type=\"button\" id=\"button_like_id\" class=\"btn btn-default disabled\" onclick=\"mylikefunction2($id_user,$id_post,0)\"><h5><b>Like</h5></b></button>";
	 document.getElementById(button_dislike_id).innerHTML = "<button type=\"button\" id=\"button_dislike_id\" class=\"btn btn-default disabled\" onclick=\"mylikefunction2($id_user, $id_post,1)\"><h5><b>Dislike</b></h5></button>";
	 */
	$.post("like.php",
		{
			id_post: idpost ,
			id_user: iduser ,
			id_likedislike: idlikedislike
		},
		function(data){
			//alert(data);
			change_like_style(idpost,data,nblike,iduser);
		});}

function change_like_style(id_post,data,nblike,iduserco){
	switch(data){
		case "-3":
			//rediriger vers une page avec message d'erreur
			alert("error : more than one action tuple");
			break;
		case "-2":
			//rediriger vers une page avec message d'erreur
			alert("error : response from database");
			break;
		case "-1":
			//rediriger vers une page avec message d'erreur
			alert("error : connection to database");

			break;
		case "1":
			to_like_style(id_post,nblike,iduserco);
			break;
		case "2":
			to_dislike_style(id_post,nblike,iduserco);
			break;
		case "0":
			to_nothing_style(id_post,nblike,iduserco);
			break;
		default:
			alert(" Y A UN PROBLEME");
			to_nothing_style(id_post,nblike,iduserco);
			break;
	}

}

function to_like_style(id_post,nb_like,iduserco)
{
	 var like_id="like-"+id_post;
	var dislike_id="dislike-"+id_post;

	// on bleute le btn like
	document.getElementById(like_id).innerHTML = "<div style=\"display:inline\" id=\"like_id\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2("+iduserco+","+id_post+",0,"+nb_like+")\"><h5 style=\"color:#6475FF\"><b>Like</h5></b></button></div>";
//on debleute le btn dislike

	document.getElementById(dislike_id).innerHTML = "<div style=\"display:inline\" id=\"dislike_id\"><button type=\"button\" class=\"btn btn-default btn-sm disabled\"><h5><b>Dislike</b></h5></button></div>";
	nb_like=nb_like+1;
	var nblike_id="nblike-"+id_post;
	document.getElementById(nblike_id).innerHTML = "<div id=\"nblike_id\" style=\"display: inline\"><small>Likes : " + nb_like+ " | </small></div>";

}

function to_dislike_style(id_post,nb_like,iduserco)
{

	 var like_id="like-"+id_post;
	var dislike_id="dislike-"+id_post;

	//on debleute le btn like
	document.getElementById(like_id).innerHTML = "<div style=\"display:inline\" id=\"like_id\"><button type=\"button\" class=\"btn btn-default btn-sm disabled\"><h5><b>Like</h5></b></button></div>";

	// on bleute le btn dislike
	document.getElementById(dislike_id).innerHTML = "<div style=\"display:inline\" id=\"dislike_id\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2("+iduserco+","+id_post+",1,"+nb_like+")\"><h5 style=\"color:#6475FF\"><b>Dislike</b></h5></button></div>";
	nb_like=nb_like-1;
	var nblike_id="nblike-"+id_post;
	document.getElementById(nblike_id).innerHTML = "<div id=\"nblike_id\" style=\"display: inline\"><small>Likes : " + nb_like+ " | </small></div>";
}

function to_nothing_style(id_post,nb_like,iduserco)
{
	var like_id="like-"+id_post;
	var dislike_id="dislike-"+id_post;

	//on debleute le btn like
	document.getElementById(like_id).innerHTML = "<div style=\"display:inline\" id=\"like_id\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2("+iduserco+","+id_post+",0,"+nb_like+")\"><h5><b>Like</h5></b></button></div>";

	//on debleute le btn dislike
	document.getElementById(dislike_id).innerHTML = "<div style=\"display:inline\" id=\"dislike_id\"><button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"mylikefunction2("+iduserco+","+id_post+",1,"+nb_like+")\"><h5><b>Dislike</b></h5></button></div>";
	
	var nblike_id="nblike-"+id_post;
		
	document.getElementById(nblike_id).innerHTML = "<div id=\"nblike_id\" style=\"display: inline\"><small>Likes : " + nb_like+ " | </small></div>";
}