function search(){

	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}

	search_input = document.getElementById('search_input').value;
	suggestion_box = document.getElementById('suggestion_box');
	console.log(search_input);

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			
			console.log(data = xmlhttp.responseText);
			data = xmlhttp.responseText;
			obj = JSON.parse(data);

			if(obj.results == 'null_result')
			{
				suggestion_box.classList.add('hidden');
			} else {				
				if(obj.title1){
					title1 = obj.title1;
					url1 = obj.url1;
					suggestion_box.classList.remove('hidden');
					suggestion_box.innerHTML = '<p class="col-md-12"><a href="./watch.php?video=' + url1 + '">' + title1 +'</a><p>';
					if(obj.title2){
						title2 = obj.title2;
						url2 = obj.url2;
						suggestion_box.innerHTML += '<p class="col-md-12"><a href="./watch.php?video=' + url2 + '">' + title2 +'</a><p>';
						if(obj.title3){
							title3 = obj.title3;
							url3 = obj.url3;
							suggestion_box.innerHTML += '<p class="col-md-12"><a href="./watch.php?video=' + url3 + '">' + title3 +'</a><p>';
							if(obj.title4){
								title4 = obj.title4;
								url4 = obj.url4;
								suggestion_box.innerHTML += '<p class="col-md-12"><a href="./watch.php?video=' + url4 + '">' + title4 +'</a><p>';
								if(obj.title5){
									title5 = obj.title5;
									url5 = obj.url5;
									suggestion_box.innerHTML += '<p class="col-md-12"><a href="./watch.php?video=' + url5 + '">' + title5 +'</a><p>';
								}
							}
						}
					}
				}
			}



		}
	}
		
	xmlhttp.open('GET', './searchProcess.inc.php?search='+search_input, true);
	xmlhttp.send(null);
}