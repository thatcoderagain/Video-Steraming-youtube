function setCommentReplyId(id) {
	document.getElementById('comment_id').value = id;
	document.getElementById('reply_id').value = '';
	document.getElementById('popUpEditButton').style.display = 'none';
	document.getElementById('popUpReplyButton').style.display = 'inline-block';
	document.getElementById('popUpButton2').click();
}

function replyComment(comment_id, message){

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

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.comment == 'posted')
			{
				document.getElementById('model_heading').innerHTML = 'Posting reply';
				document.getElementById('model_message').innerHTML = 'Reply posted successfully.';
				document.getElementById('popUpButton').click();
			} else {
				document.getElementById('model_heading').innerHTML = 'Posting reply';
				document.getElementById('model_message').innerHTML = 'Reply posting failed.';
				document.getElementById('popUpButton').click();
			}
		}
	}

	formdata = new FormData();
	formdata.append('comment_id', comment_id);
	formdata.append('message', message);
		
	xmlhttp.open('POST', './replyComment.inc.php', true);
	xmlhttp.send(formdata);
}