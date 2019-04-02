function showNotification(x) {
	document.getElementById(x).click();
}

function createPlaylist(button){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	playlistNameField = document.getElementById('playlist_name');
	playlistName = document.getElementById('playlist_name').value;
	createbutton = document.getElementById(button).name;
	new_created_playlist = document.getElementById('new_created_playlist');

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.playlist == 'created') {
				new_created_playlist.innerHTML += '<button type="button" class="btn btn-default" onclick="playlist(this.id)" id="'+playlistName+'">'+playlistName+'</button>';				
				
				document.getElementById('model_heading').innerHTML = 'Creating new playlist';
				document.getElementById('model_message').innerHTML = 'Playlist has been created successfully.';
				document.getElementById('popUpButton').click();
			} else if(obj.playlist == 'existed') {
				playlistNameField.value = '';
				playlistNameField.placeholder = 'Already Exist.';

				document.getElementById('model_heading').innerHTML = 'Creating new playlist';
				document.getElementById('model_message').innerHTML = 'Playlist `' + playlistName + '` is already exist.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('playlist_Name', playlistName);
	formdata.append('create_button', createbutton);
		
	xmlhttp.open('POST', 'createPlaylist.inc.php', true);
	xmlhttp.send(formdata);
}