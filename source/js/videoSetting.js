function extractAudio(){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	video_url = document.getElementById('url').value;

	document.getElementById('model_heading').innerHTML = 'Generating Audio';
	document.getElementById('model_message').innerHTML = 'Process started.';
	document.getElementById('popUpButton').click();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.audio == 'extracted')
			{
				document.getElementById('model_heading').innerHTML = 'Generating Audio';
				document.getElementById('model_message').innerHTML = 'Process completed successfully.';
				document.getElementById('popUpButton').click();
			} else {
				document.getElementById('model_heading').innerHTML = 'Generating Audio';
				document.getElementById('model_message').innerHTML = 'Process failed.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('video', video_url);
		
	xmlhttp.open('POST', './extractAudio.inc.php', true);
	xmlhttp.send(formdata);
}

function extractThumbnail(){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	video_url = document.getElementById('url').value;

	document.getElementById('model_heading').innerHTML = 'Generating Thumbnail';
	document.getElementById('model_message').innerHTML = 'Process started.';
	document.getElementById('popUpButton').click();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.thumbnail == 'extracted')
			{
				document.getElementById('model_heading').innerHTML = 'Generating Thumbnail';
				document.getElementById('model_message').innerHTML = 'Process completed successfully.';
				document.getElementById('popUpButton').click();
			} else {
				document.getElementById('model_heading').innerHTML = 'Generating Thumbnail';
				document.getElementById('model_message').innerHTML = 'Process failed.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('video', video_url);
		
	xmlhttp.open('POST', './extractThumbnail.inc.php', true);
	xmlhttp.send(formdata);
}