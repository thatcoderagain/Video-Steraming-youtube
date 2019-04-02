function playlist(button){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	url = document.getElementById('url').value;
	playlistButton = document.getElementById(button);

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.playlist == 'added'){
				playlistButton.classList.toggle('btn-primary');
				playlistButton.classList.toggle('btn-default');
			} else if(obj.playlist == 'removed'){
				playlistButton.classList.toggle('btn-primary');
				playlistButton.classList.toggle('btn-default');
			}
		}
	}

	formdata = new FormData();
	formdata.append('button', button); // IMPORTANT
	formdata.append('url', url);
		
	xmlhttp.open('POST', 'playlist.inc.php', true);
	xmlhttp.send(formdata);
}