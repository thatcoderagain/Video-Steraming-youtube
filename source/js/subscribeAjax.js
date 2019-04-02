function subscribeUnsubscribe(){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	subscribe_button = document.getElementById('subscribe_button');
	subscriber_number = document.getElementById('subscriber_number');
	channel_id = document.getElementById('channel_id').value;    

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.subscribe == 'true'){
				subscribe_button.classList.toggle('btn-default');
				subscribe_button.classList.toggle('btn-primary');
				subscribe_button.innerHTML = '<i class="fa fa-video-camera" aria-hidden="true"></i>&nbsp;&nbsp;Unsubscribe';
				subscriber_number.value = obj.subscribers;
			} else {
				subscribe_button.classList.toggle('btn-default');
				subscribe_button.classList.toggle('btn-primary');
				subscribe_button.innerHTML = '<i class="fa fa-video-camera" aria-hidden="true"></i>&nbsp;&nbsp;Subscribe';
				subscriber_number.value = obj.subscribers;
			}
		}
	}

	formdata = new FormData();
	formdata.append('channel_id', channel_id);
		
	xmlhttp.open('POST', 'subscribe.inc.php', true);
	xmlhttp.send(formdata);
}