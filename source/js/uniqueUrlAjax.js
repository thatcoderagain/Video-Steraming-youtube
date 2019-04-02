function slugAvailability(){

    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }

    update_button = document.getElementById('update_button');
    slug = document.getElementById('slug').value;

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

            data = xmlhttp.responseText;
            obj = JSON.parse(data);

            if(obj.url == 'unique'){
                document.getElementById('slugIcon').innerHTML = '<span class="glyphicon glyphicon-ok">';
                document.getElementById('slugInput').classList.add('has-success');
                update_button.disabled = false;
            } else if(slug == '') {
                document.getElementById('slugIcon').innerHTML = '&nbsp;&nbsp;&nbsp;';
                document.getElementById('slugInput').classList.remove('has-success');
                update_button.disabled = false;
            } else {
                document.getElementById('slugIcon').innerHTML = '<span class="glyphicon glyphicon-remove">';
                document.getElementById('slugInput').classList.remove('has-success');
                update_button.disabled = true;
            }
        }
    }

    formdata = new FormData();
    formdata.append('slug', slug);
        
    xmlhttp.open('POST', 'uniqueURLChecker.inc.php', true);
    xmlhttp.send(formdata);
}