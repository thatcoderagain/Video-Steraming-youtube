function likeDislike(button){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	like_button = document.getElementById('like_button');
	dislike_button = document.getElementById('dislike_button');	
	likes = document.getElementById('likes');
	dislikes = document.getElementById('dislikes');
	url = document.getElementById('url').value;

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.voted_as == 'like'){
				like_button.style.color = '#02baf2';
				dislike_button.style.color = '#93a4aa';
				likes.innerHTML = obj.likes;
				dislikes.innerHTML = obj.dislikes;
			} else if(obj.voted_as == 'dislike'){
				dislike_button.style.color = '#02baf2';
				like_button.style.color = '#93a4aa';
				likes.innerHTML = obj.likes;
				dislikes.innerHTML = obj.dislikes;
			} else if(obj.voted_as == 'none'){
				like_button.style.color = '#93a4aa';
				dislike_button.style.color = '#93a4aa';
				likes.innerHTML = obj.likes;
				dislikes.innerHTML = obj.dislikes;
			} else {
				console.log(xmlhttp.responseText);
			}
		}
	}

	formdata = new FormData();
	formdata.append('button', button);
	formdata.append('url', url);
		
	xmlhttp.open('POST', 'vote.inc.php', true);
	xmlhttp.send(formdata);
}