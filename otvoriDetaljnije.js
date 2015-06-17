function otvoriDetaljnije(id) {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById('sadrzaj').innerHTML = ajax.responseText;
			document.getElementsByName('id-vijesti')[0].value = id;
			pribaviVijest(id);
			pribaviKomentare(id);
			prikaziKomentare();
		}
	};
	ajax.open("GET", "clanakDetaljnije.html", true);
	ajax.send();
}

function pribaviVijest(id) {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var vijest = JSON.parse(ajax.responseText);
			document.getElementsByClassName("datum_vrijeme_novosti")[0].innerHTML = vijest['datum'] + ", Autor: " + vijest['autor'];
			document.getElementsByClassName("naslov_novosti")[0].innerHTML = vijest['naslov'];
			document.getElementsByClassName("tekst-novosti")[0].innerHTML = vijest['tekst'];
			document.getElementsByClassName("detaljnije")[0].innerHTML = vijest['detaljnije'];
			document.getElementsByClassName("news-image")[0].src = vijest['slika'];
		}
	};
	ajax.open("GET", "php/pribaviVijest.php?id=" + id, true);
	ajax.send();
}

function pribaviKomentare(id) {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var komentari = JSON.parse(ajax.responseText);
			var kom = document.getElementsByClassName('komentari')[0];
			kom.innerHTML = "";
			if (komentari.length > 0) {
				var x = document.getElementsByClassName('broj-komentara-x')[0];
				x.innerHTML = "Komentari (" + komentari.length + ")<br><hr/>";
				for (var i = 0; i < komentari.length; i++) {
					kom.innerHTML += "<div class='datum_vrijeme_novosti'>(" + komentari[i]['ime'] + " / " + 
					komentari[i]['email'] + " / " + komentari[i]['vrijeme'] + ")</div>";
					kom.innerHTML += "<p class='tekst-novosti'>" + komentari[i]['komentar'] + "</p><hr/>";
				}
			}
			else if (komentari.length == 0) {
				var nula = document.getElementsByClassName('broj-komentara-nula')[0];
				nula.innerHTML = "Nema komentara.<br><hr>";
			}
		}
	};
	ajax.open("GET", "php/pribaviKomentare.php?id=" + id, true);
	ajax.send();
}

function prikaziKomentare() {
	var komentari = document.getElementsByClassName('komentari')[0];
	if (komentari.style.display == "none") {
		komentari.style.display = "block";
	}
	else {
		komentari.style.display = "none";
	}
}

function posaljiKomentar() {
	var ajax = new XMLHttpRequest();
	var ime = document.getElementsByName('ime-komentatora')[0].value;
	var email = document.getElementsByName('email-komentatora')[0].value;
	var komentar = document.getElementsByName('komentar-komentatora')[0].value;
	var vijest = document.getElementsByName('id-vijesti')[0].value;
	ajax.onreadystatechange = function() {
		if (ime != "" && komentar != "" && ajax.readyState == 4 && ajax.status == 200) {
			alert("Komentar uspješno poslan!");
		}
		else {
			alert("Polja za ime ili komentar je ostalo prazno!");
		}
	};
	ajax.open("POST", "php/posaljiKomentar.php", true);
	ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.send("ime=" + ime + "&email=" + email + "&komentar=" + komentar + "&vijest=" + vijest);
	document.getElementsByName("ime-komentatora")[0].value = "";
	document.getElementsByName("email-komentatora")[0].value = "";
	document.getElementsByName("komentar-komentatora")[0].value = "";
}