function set_value(myField, myValue) {
    document.getElementById(myField).value = myValue;
}

function apply_value(myField, myValue) {
    set_value(myField, myValue);
    document.defaultform.submit();
}


var xhr = null;
function getXhr() {
	if (window.XMLHttpRequest) // Firefox et autres
		xhr = new XMLHttpRequest();
	else if (window.ActiveXObject){ // Internet Explorer
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	else { // XMLHttpRequest non support� par le navigateur
		alert("XMLHTTPRequest objects not supported.");
	}
	return xhr;
}

function modif_date(currentDate, myDiv, myField){
        getXhr();
        xhr.onreadystatechange = function(){
                if(xhr.readyState == 4 && xhr.status == 200){
                        contenu = xhr.responseText;
                        document.getElementById(myDiv).innerHTML = contenu;
                }
        }

        xhr.open("POST","async/date_async.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send("date="+currentDate+"&field="+myField+"&div="+myDiv);
}
