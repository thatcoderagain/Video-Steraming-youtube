function postComment(){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	
	url = document.getElementById('url').value;
	message = document.getElementById('newComment').value;	
	reset_button = document.getElementById('reset_button');
	reset_button.click();

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.comment == 'posted')
			{
				document.getElementById('model_heading').innerHTML = 'Posting comment';
				document.getElementById('model_message').innerHTML = 'Comment posted successfully.';
				document.getElementById('popUpButton').click();
			} else {
				document.getElementById('model_heading').innerHTML = 'Posting comment';
				document.getElementById('model_message').innerHTML = 'Comment posting successfully.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('message', message);
	formdata.append('url', url);
		
	xmlhttp.open('POST', 'postComment.inc.php', true);
	xmlhttp.send(formdata);
}