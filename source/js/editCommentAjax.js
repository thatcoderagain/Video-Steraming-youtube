function setCommentEditId(id, type) {
	if(type == 'c')
	{
		document.getElementById('comment_id').value = id;
		document.getElementById('reply_id').value = '';
	} else if(type == 'r')
	{
		document.getElementById('comment_id').value = '';
		document.getElementById('reply_id').value = id;
	}

	document.getElementById('popUpEditButton').style.display = 'inline-block';
	document.getElementById('popUpReplyButton').style.display = 'none';
	document.getElementById('popUpButton2').click();
	
}

function editComment(comment_id, reply_id, message){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	if(message == '')
	{
		return;
	}

	document.getElementById('popUpCloseButton2').click();

	if(comment_id == '')
	{
		unique_id = reply_id;
		type = 'reply';
	}
	else if(reply_id == '')
	{
		unique_id = comment_id;
		type = 'comment'
	}

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.comment == 'edited')
			{
				document.getElementById('model_heading').innerHTML = 'Editing comment';
				document.getElementById('model_message').innerHTML = 'Comment Edited successfully.';
				document.getElementById('popUpButton').click();
			} else {
				document.getElementById('model_heading').innerHTML = 'Editing comment';
				document.getElementById('model_message').innerHTML = 'Comment Editing failed.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('unique_id', unique_id);
	formdata.append('type', type);
	formdata.append('message', message);
		
	xmlhttp.open('POST', './editComment.inc.php', true);
	xmlhttp.send(formdata);
}