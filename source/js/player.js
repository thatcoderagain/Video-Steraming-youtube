window.addEventListener('load',
	function() {
		video = document.getElementById('video');    
		playPauseButton = document.getElementById('play_pause_button');
		timeField = document.getElementById('time_field');
		soundControlButton = document.getElementById('sound_control_button');
		volumeSliderContainer = document.getElementById('volume_slider_container');
		volumeSlider = document.getElementById('volume_slider');
		volumeValue = document.getElementById('volume');
		buttonContainer = document.getElementById('button_container');
		progressbarContainer = document.getElementById('progressbar_container');
		progressbar = document.getElementById('progressbar');
		bufferedbar = document.getElementById('bufferedbar');
		subtitleButton = document.getElementById('subtitle_button');
		layerContainer = document.getElementById('layer_container');
		screenToggleButton = document.getElementById('screen_toggle_button');

		video.load();
		video.addEventListener('canplay',
			function () {
				video.addEventListener('click', playOrPause);
				playPauseButton.addEventListener('click', playOrPause);
				soundControlButton.addEventListener('click', muteOrUnmute);
				volumeSliderContainer.addEventListener('click', changeVol);
				soundControlButton.addEventListener('mouseover', showVol);
				buttonContainer.addEventListener('mouseleave', hideVol);
				progressbarContainer.addEventListener('click', seek);
				subtitleButton.addEventListener('click', subtitle);
				layerContainer.addEventListener('click', playOrPause);
				screenToggleButton.addEventListener('click', resizeWindow);
				document.addEventListener('keyup', key);

				video.addEventListener('waiting', buffering);
				video.addEventListener('seeking', buffering);
				video.addEventListener('seeked', bufferingDone);

				updatePlayer();
				subtitle();
			}
		);
	}
);


// function definations

function playOrPause() {
	if(video.paused) {
		video.play();
		playPauseButton.innerHTML = '<span class="fa fa-pause" aria-hidden="true"></span>';
		update = setInterval(updatePlayer, 50);
		layerContainer.style.display = 'none';
	} 
	else {
		video.pause();
		playPauseButton.innerHTML = '<span class="fa fa-play" aria-hidden="true"></span>';
		layerContainer.innerHTML = '<span class="fa fa-pause" aria-hidden="true"></span>';
		layerContainer.style.display = 'block';
	}
}

watched = 0;

function updatePlayer() {
	played = (video.currentTime/video.duration) * 100;
	progressbar.style.width = played+'%';

	bufferedpercentage = (video.buffered.end(0)/video.duration) * 100;
	bufferedbar.style.width = bufferedpercentage+'%';

	timeField.innerHTML = getFormattedTime();

	if(video.ended) {
		window.clearInterval(update);
		playPauseButton.innerHTML = '<span class="fa fa-repeat" aria-hidden="true"></span>';
		layerContainer.innerHTML = '<span class="fa fa-repeat" aria-hidden="true"></span>';
		layerContainer.style.display = 'block';
		watched = 0;
	}

	if(!video.paused) {
		watched += 0.05;
		if( (watched/video.duration) > 0.1 && watched < 100) {

			watched = 1000;
			// Increment video views
			if(window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
			}
			
			url = document.getElementById('url').value;    

			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

					data = xmlhttp.responseText;
					obj = JSON.parse(data);

					if(obj.viewed == 'true'){
						return ;
					}
				}
			}

			formdata = new FormData();
			formdata.append('view_trigger', '');
			formdata.append('url', url);
				
			xmlhttp.open('POST', 'view.inc.php', true);
			xmlhttp.send(formdata);

		}
	}
}

function getFormattedTime() {
	seconds = Math.round(video.currentTime);
	minutes = Math.floor(seconds/60);
	if(minutes > 0)
		seconds -= minutes * 60;
	if(seconds.toString().length === 1)
		seconds = '0' + seconds;

	totalseconds = Math.round(video.duration);
	totalminutes = Math.floor(totalseconds/60);
	if(totalminutes > 0)
		totalseconds -= totalminutes * 60;
	if(totalseconds.toString().length === 1)
		totalseconds = '0' + totalseconds;

	return minutes + ':' + seconds + ' / ' + totalminutes + ':' + totalseconds;
}

function muteOrUnmute() {
	if(!video.muted) {
		video.muted = true;
		soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
		soundControlButton.style.color = '#ff0000';
		volumeSlider.style.display = 'none';
		volumeValue.style.display = 'none';
	} 
	else {
		video.muted = false;		
		vol = video.volume * 100;
		soundControlButton.style.color = '#ffffff';
		volumeSlider.style.display = 'block';
		volumeValue.style.display = 'block';

		if(vol >= 60){
			soundControlButton.innerHTML = '<span class="fa fa-volume-up" aria-hidden="true"></span>';
		} 
		else if(vol >= 10){
			soundControlButton.innerHTML = '<span class="fa fa-volume-down" aria-hidden="true"></span>';
		} 
		else if(vol > 1){
			soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
		} 
		else if(vol == 0){
			soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
			soundControlButton.style.color = '#ff0000';
			volumeSlider.style.display = 'none';
		}
	}
}

var vol = 100;

function changeVol(event) {
	mouseX = event.pageX - volumeSliderContainer.offsetLeft;    
	width = window.getComputedStyle(volumeSliderContainer).getPropertyValue('width');
	width = parseFloat(width.substr(0, width.length - 2));
	vol = (mouseX / width) * 100;
	video.volume = vol / 100;
	volumeSlider.style.width = vol + '%';

	video.muted = false;
	vol = video.volume * 100;

	soundControlButton.style.color = '#ffffff';
	volumeSlider.style.display = 'block';
	volumeValue.style.display = 'block';
	volumeValue.innerHTML = parseInt(vol);

	if(vol >= 60){
		soundControlButton.innerHTML = '<span class="fa fa-volume-up" aria-hidden="true"></span>';
	} 
	else if(vol >= 10){
		soundControlButton.innerHTML = '<span class="fa fa-volume-down" aria-hidden="true"></span>';
	} 
	else if(vol > 1){
		soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
	} 
	else if(vol == 0){
		soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
		soundControlButton.style.color = '#ff0000';
		volumeSlider.style.display = 'none';
		volumeValue.style.display = 'none';
	}
	
}

function varyVolume(x) {
	
	if(vol >= 90 && x > 0)
	{
		vol = 100;
	} 
	else if(vol <= 10 && x < 0) {
		vol = 0;
	} 
	else {
		vol = x + vol;
	}

	video.volume = vol / 100;
	volumeSlider.style.width = vol + '%';
	vol = video.volume * 100;

	soundControlButton.style.color = '#ffffff';
	volumeSlider.style.display = 'block';
	volumeValue.style.display = 'block';
	volumeValue.innerHTML = parseInt(vol);

	if(vol >= 60){
		soundControlButton.innerHTML = '<span class="fa fa-volume-up" aria-hidden="true"></span>';
	} 
	else if(vol >= 10){
		soundControlButton.innerHTML = '<span class="fa fa-volume-down" aria-hidden="true"></span>';
	} 
	else if(vol > 1){
		soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
	} 
	else if(vol == 0){
		soundControlButton.innerHTML = '<span class="fa fa-volume-off" aria-hidden="true"></span>';
		soundControlButton.style.color = '#ff0000';
		volumeSlider.style.display = 'none';
		volumeValue.style.display = 'none';
	}
}

function showVol() {
	volumeSliderContainer.style.display = 'inline-block';
}

function hideVol() {
	volumeSliderContainer.style.display = 'none';
}

function changeSpeed(x) {
	video.playbackRate = x;
}

function seek(event) {
	mouseX = event.pageX - progressbarContainer.offsetLeft;
	width = window.getComputedStyle(progressbarContainer).getPropertyValue('width');
	width = parseFloat(width.substr(0, width.length - 2));

	video.currentTime = (mouseX/width)*video.duration;
	updatePlayer();
	subtitle();
}

function buffering() {
	window.clearInterval(update);
	layerContainer.innerHTML = '<span class="fa fa-spinner" aria-hidden="true"></span>'
	layerContainer.style.display = 'inline-block';
}

function bufferingDone() {    
	update = setInterval(updatePlayer, 50);        
	layerContainer.style.display = 'none';
}

function subtitle() {
	if(video.textTracks.length == 0){
		subtitleButton.style.color = '#990000';
	} 
	else if(video.textTracks[0].mode == 'hidden') {
		video.textTracks[0].mode = 'showing';
		subtitleButton.style.color = '#02baf2';
		subtitleButton.style.display = 'inline-block';
	} 
	else if(video.textTracks[0].mode == 'showing') {
		video.textTracks[0].mode = 'hidden';
		subtitleButton.style.color = '#ffffff';
		subtitleButton.style.display = 'inline-block';
	}
}

var isFullscreen = false;

function resizeWindow(event) {
	if(isFullscreen == false){
		if (video.webkitRequestFullscreen) {
			video.webkitRequestFullscreen();
		} 
		else if (video.mozRequestFullScreen) {
			video.mozRequestFullScreen();
		} 
		else if (video.msRequestFullscreen) {
			video.msRequestFullscreen();
		} 
		else if(video.requestFullscreen){
			video.requestFullscreen();
		}
		isFullscreen = true;
		screenToggleButton.innerHTML = '<i class="fa fa-compress" aria-hidden="true">';
		isDisplayingFullscreen = setInterval(displayingFullscreen,50);
	}
	else if (isFullscreen == true) {
		if(video.webkitExitFullscreen) {
			video.webkitExitFullscreen();
		} 
		else if(video.mozCancelFullScreen) {
			video.mozCancelFullScreen();
		} 
		else if(video.msExitFullscreen) {
			video.msExitFullscreen();
		} 
		else if(video.exitFullscreen) {
			video.exitFullscreen();
		} 
		else if(video.cancelFullScreen) {
			video.cancelFullScreen();
		}
		isFullscreen = false;
		screenToggleButton.innerHTML = '<i class="fa fa-expand" aria-hidden="true">';
	}
}

function key(event) {
	event.preventDefault();
	if(event.keyCode == 32){
		playOrPause();
	}
	else if(event.keyCode == 27 && isFullscreen == true){
		resizeWindow();
	}
	else if(event.keyCode == 37){
		video.currentTime -= 10;
		subtitle();
	}
	else if(event.keyCode == 39){
		video.currentTime += 10;
		subtitle();
	}
	else if(event.keyCode == 38){
		varyVolume(10);
	}
	else if(event.keyCode == 40){
		varyVolume(-10);
	}
	else if(event.keyCode == 77){
		muteOrUnmute();
	}
	//else alert(event.keyCode);
}