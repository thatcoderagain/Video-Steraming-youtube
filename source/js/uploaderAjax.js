function uploadvideo(){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	file = document.getElementById('videofile').files[0];
	fileNAME = file.name;
	videoEXTENSION = fileNAME.substr(fileNAME.lastIndexOf('.') + 1);
	videoEXTENSION = videoEXTENSION.toLowerCase();

	if(videoEXTENSION == 'mp4'){
		if(file.type == 'video/mp4'){

			formdata = new FormData();
			formdata.append('videofile',file);

			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

					data = xmlhttp.responseText;
					obj = JSON.parse(data);

					if(obj.filename != 'UPLOADING ERROR'){
						document.getElementById('video_filename').value = obj.filename;
					} else {
						document.getElementById('alert').innerHTML = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> file uploading failed.</div>';
					}
				}
			}
			
			xmlhttp.upload.addEventListener("progress", processprogress);
			xmlhttp.addEventListener("load", processComplete);
			
			xmlhttp.open('POST', 'uploader.inc.php', true);
			xmlhttp.send(formdata);

			document.getElementById('alert').classList.add('hidden');
			document.getElementById('uploader').classList.add('hidden');
			document.getElementById('form').classList.remove('hidden');
			
		} else {
			document.getElementById('alert').innerHTML = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> file format is not mp4</div>';
		}
	} else {
		document.getElementById('alert').innerHTML = '<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> file format is not mp4</div>';		
	}

}

function processprogress(event){
	percent = Math.round((event.loaded / event.total) * 100);
	document.getElementById('percentage').innerHTML = percent + '%';
	document.getElementById('progressbar').style.width = percent + '%';
}

function processComplete(event){
	document.getElementById('percentage').innerHTML = '100%';
	document.getElementById('progressbar').style.width = percent + '%';
	document.getElementById('upload_button').classList.remove('disabled');
	document.getElementById('upload_button').disabled = false;
	document.getElementById('uploading').classList.add('hidden');
	document.getElementById('uploadcomplete').classList.remove('hidden');

	document.getElementById('progressbar').classList.add('progress-bar-success');
	document.getElementById('progressbar').classList.remove('active');
}