function deleteComment(comment, COR){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	if(COR == 'r')
		type = 'reply';
	else if(COR == 'c')
		type = 'comment'

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.comment == 'deleted')
			{
				document.getElementById('model_heading').innerHTML = 'Deleting comment';
				document.getElementById('model_message').innerHTML = 'Comment deleted successfully.';
				document.getElementById('popUpButton').click();
			} else {
				document.getElementById('model_heading').innerHTML = 'Deleting comment';
				document.getElementById('model_message').innerHTML = 'Comment deleting failed.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('unique_id', comment);
	formdata.append('type', type);
		
	xmlhttp.open('POST', './deleteComment.inc.php', true);
	xmlhttp.send(formdata);
}