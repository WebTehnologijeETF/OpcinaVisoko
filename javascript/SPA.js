function replaceContent() {
	var ajax = new XMLHttpRequest();
	var url = "";
	var id = 0;
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			if (url == "vijesti.php") {
				ucitajVijesti();
				ucitajBrojeveKomentara();
			}
			else if (url == "html/gradovi-pobratimi.html") {
				ucitajGradove();
			}
			document.getElementById("sadrzaj").innerHTML = ajax.responseText;
		}
	}
	
	if (window.location.hash == "#vijesti" || window.location.hash == "") {
		url = "vijesti.php";
	}
	else if (window.location.hash == "#vijesti-txt") {
		url = "vijesti-txt.php";
	}
	else if (window.location.hash == "#gradovi-pobratimi") {
		url = "html/gradovi-pobratimi.html";
	} 
	else if (window.location.hash == "#telefonski-brojevi") {
		url = "html/tel-brojevi.html";
	} 
	else if (window.location.hash == "#vlada-federacije-bih") {
		url = "html/vlada-federacije-bih.html";
	} 
	else if (window.location.hash == "#predsjednistvo-bih") {
		url = "html/predsjednistvo-bih.html";
	} 
	else if (window.location.hash == "#visoko-co-ba") {
		url = "html/visoko-co-ba.html";
	} 
	else if (window.location.hash == "#kontakt") {
		url = "html/kontakt.html";
	}
	/*else if (window.location.hash != "#panel") {
		url = "html/clanakKomentari.html";
		id = parseInt(window.location.hash.charAt(7));
	}*/
	ajax.open("GET", url, true);
	ajax.send();
}

function changeHash(hash) {
	window.location.hash = hash;
}

function showLoginForm() {
	if (document.getElementById("prijavaforma").style.display == "none") {
		hideRegisterForm();
		document.getElementById("dugmeRegistracija").value = "REGISTRACIJA";
		document.getElementById("prijavaforma").style.display = "block";
		document.getElementById("dugmePrijava").value = "SAKRIJ";
	}
	else {
		document.getElementById("prijavaforma").style.display = "none";
		document.getElementById("dugmePrijava").value = "PRIJAVA";
	}
}

function showRegisterForm() {
	if (document.getElementById("regforma").style.display == "none") {
		hideLoginForm();
		document.getElementById("dugmePrijava").value = "PRIJAVA";
		document.getElementById("regforma").style.display = "block";
		document.getElementById("dugmeRegistracija").value = "SAKRIJ";
	}
	else {
		document.getElementById("regforma").style.display = "none";
		document.getElementById("dugmeRegistracija").value = "REGISTRACIJA";
	}
}

function hideLoginForm() {
	document.getElementById("prijavaforma").style.display = "none";
}

function hideRegisterForm() {
	document.getElementById("regforma").style.display = "none";
}

function showPanel() {
	if (document.getElementById("panel-link").innerHTML == '<a href="#panel" onclick="showPanel()">Prikaži administratorski panel</a>') {
		document.getElementById("panel-link").innerHTML = '<a href="#panel" onclick="showPanel()">Sakrij administratorski panel</a>';
		document.getElementById("panel").style.display = "block";
	}
	else {
		document.getElementById("panel-link").innerHTML = '<a href="#panel" onclick="showPanel()">Prikaži administratorski panel</a>';
		document.getElementById("panel").style.display = "none";
	}
}

function ucitajVijesti() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var vijesti = JSON.parse(ajax.responseText);
			var sadrzaj = document.getElementById("sadrzaj");
			for (var i = (vijesti.length - 1); i >= 0; i--) {
				if (vijesti[i]['slika'] != "") {
					sadrzaj.innerHTML += "<div id='novost-" + vijesti[i]['id'] + 
					"' class='novost'><div class='news-text'><small class='datum-i-vrijeme-novosti'>" + vijesti[i]['datum'] + 
					" / Autor: "+ vijesti[i]['autor'] + " / " + "<b>Komentari (<a href='blank' onclick='ucitajKomentare(" + 
					vijesti[i]['id'] + "); return false;' id='broj-komentara-" + vijesti[i]['id'] + "' class='link-na-komentare'>" + ucitajBrojKomentara(vijesti[i]['id']) + 
					"</a>)</b></small><h2 class='naslov-novosti'>" + vijesti[i]['naslov'] + "</h2><img src='" + vijesti[i]['slika'] + 
					"' class='news-image'><p id='tekst-novosti-" + vijesti[i]['id'] + "' class='tekst-novosti'>" + vijesti[i]['tekst'] + 
					"<p id='detaljnije-" + vijesti[i]['id'] + "'></p> <a href='blank' onclick='ucitajDetaljnije(" + 
					vijesti[i]['id'] + "); return false;' id='link-detaljnije-" + vijesti[i]['id'] + "'>Detaljnije...</a></p></div></div>";
				}
				else {
					sadrzaj.innerHTML += "<div id='novost-" + vijesti[i]['id'] + 
					"' class='novost'><div class='news-text'><small class='datum-i-vrijeme-novosti'>" + vijesti[i]['datum'] + 
					" / Autor: "+ vijesti[i]['autor'] + " / " + "<b>Komentari (<a href='blank' onclick='ucitajKomentare(" + 
					vijesti[i]['id'] + "); return false;' id='broj-komentara-" + vijesti[i]['id'] + "' class='link-na-komentare'>" + ucitajBrojKomentara(vijesti[i]['id']) + 
					"</a>)</b></small><h2 class='naslov-novosti'>" + vijesti[i]['naslov'] + "</h2><p id='tekst-novosti-" + 
					vijesti[i]['id'] + "' class='tekst-novosti'>" + vijesti[i]['tekst'] + 
					"<p id='detaljnije-" + vijesti[i]['id'] + "'></p> <a href='blank' onclick='ucitajDetaljnije(" + 
					vijesti[i]['id'] + "); return false;' id='link-detaljnije-" + vijesti[i]['id'] + "'>Detaljnije...</a></p></div></div>";
				}
				sadrzaj.innerHTML += "<div id='komentari-na-novost-" + vijesti[i]['id'] + "' class='komentari-na-novost' style='display: none'><div id='komentari-" + vijesti[i]['id'] + "'></div><div id='komentari-forma-" + vijesti[i]['id'] + "'></div></div>";
			}
		}
	}
	ajax.open("GET", "php/vijestiREST.php", true);
	ajax.send();
}
// <input type='hidden' name='id-vijesti' value='" + id + "'>
function ucitajKomentare(id) {
	if (document.getElementById("komentari-na-novost-" + id).style.display == "none") {
		pribaviKomentare(id);
		document.getElementById("komentari-forma-" + id).innerHTML = "<h4>Pošalji komentar:</h4><form method='POST' id='forma-slanje-komentara' onsubmit='return false'><label for='komentar-komentatora'>Komentar:</label><br><textarea name='komentar-komentatora' class='komentar-komentatora' cols='40' rows='10'></textarea><br><input type='submit' value='Pošalji' onclick='posaljiKomentar(" + id + ");'></form>";
		document.getElementById("komentari-na-novost-" + id).style.display = "block";
	}
	else {
		document.getElementById("komentari-na-novost-" + id).style.display = "none";
	}
}

function pribaviKomentare(id) {
   var f = function() { 
     var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				var komentari = JSON.parse(ajax.responseText);
				var kom = document.getElementById("komentari-" + id);
				kom.innerHTML = "";
				kom.innerHTML = "<h4 class='broj-komentara-nula'></h4><b><h4 class='broj-komentara-x'></h4></b>"
				if (komentari.length > 0) {
					document.getElementById('komentari-na-novost-' + id).getElementsByClassName('broj-komentara-nula')[0].innerHTML = "";
					document.getElementById('komentari-na-novost-' + id).getElementsByClassName('broj-komentara-x')[0].innerHTML = "Komentari (" + komentari.length + ")<br>";
					for (var i = 0; i < komentari.length; i++) {
						if (komentari[i]['email'] != null) {
							kom.innerHTML += "<div class='datum-i-vrijeme-novosti'>(<a href='mailto:" + komentari[i]['email'] + "?Subject=Email%20komentatoru'>" + komentari[i]['ime'] + "</a> / " + komentari[i]['email'] + " / " + komentari[i]['vrijeme'] + ")</div>";
						}
						else {
							kom.innerHTML += "<div class='datum-i-vrijeme-novosti'>(Anonimno)</div>";
						}
						kom.innerHTML += "<p class='tekst-novosti'>" + komentari[i]['komentar'] + "</p><hr/>";
					}
				}
				else {
					document.getElementById('komentari-na-novost-' + id).getElementsByClassName('broj-komentara-nula')[0].innerHTML = "Nema komentara.<br>";
					document.getElementById('komentari-na-novost-' + id).getElementsByClassName('broj-komentara-x')[0].innerHTML = "";
				}
			}
		}
		ajax.open("GET", "php/komentariREST.php?id=" + id, true);
		ajax.send();
   };
   window.setInterval(f, 5000);
   f();
}

function posaljiKomentar(id) { 
	var komentar = document.getElementById("komentari-forma-" + id).getElementsByClassName("komentar-komentatora")[0];
	if (komentar.value == "") {
		window.alert("Polje za komentar prazno!");
	}
	else {
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				komentar.value = "";
				document.getElementById("komentari-na-novost-" + id).style.display = "block";
				pribaviKomentare(id);
			}
		}
		ajax.open("POST", "php/komentariREST.php", true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send("komentar=" + komentar.value + "&vijest=" + id);
	}
}

function ucitajBrojeveKomentara() {
	setInterval(function() {
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				var vijesti = JSON.parse(ajax.responseText);
				for (var i = 0; i < vijesti.length; i++) {
					ucitajBrojKomentara(vijesti[i]['id']);
				}
			}
		}
		ajax.open("GET", "php/vijestiREST.php", true);
		ajax.send();
	}, 5000);
}

function ucitajBrojKomentara(id) {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var komentari = JSON.parse(ajax.responseText);
			document.getElementById("broj-komentara-" + id).innerHTML = komentari.length;
		}
	}
	ajax.open("GET", "php/komentariREST.php?id=" + id, true);
	ajax.send();
}

function ucitajDetaljnije(id) {
	if (document.getElementById("link-detaljnije-" + id).innerHTML == "Detaljnije...") {
		var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				var vijest = JSON.parse(ajax.responseText);
				document.getElementById("detaljnije-" + id).innerHTML = vijest['detaljnije'];
				document.getElementById("link-detaljnije-" + id).innerHTML = "Sakrij detaljnije";
			}
		}
		ajax.open("GET", "php/vijestiREST.php?id=" + id, true);
		ajax.send();
	}
	else {
		document.getElementById("detaljnije-" + id).innerHTML = "";
		document.getElementById("link-detaljnije-" + id).innerHTML = "Detaljnije...";
	}
}


// ADMIN PANEL

function izlistajVijesti() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var vijesti = JSON.parse(ajax.responseText);
			document.getElementById("panel-lista").innerHTML = "";
			for (var i = 0; i < vijesti.length; i++) {
				document.getElementById("panel-lista").innerHTML += '<span class="panel-stavka">ID: (' + vijesti[i]['id'] + ') <span class="panel-stavka-vrijeme">' + vijesti[i]['datum'] + '</span> <span class="panel-stavka-vrijednost">' + vijesti[i]['naslov'] + '</span></span><br>';
			}
			document.getElementById("panel-forma").innerHTML = "<hr><i>(Unesite ID članka koji želite izbrisati; za dodavanje/ažuriranje unosite ostala polja!)</i>";
			document.getElementById("panel-forma").innerHTML += '<form>ID: <input type="text" id="idClanka"><br>Naslov: <input type="text" id="naslovClanka"><br>Autor: <input type="text" id="autorClanka"><br>Tekst: <input type="text" id="tekstClanka"><br>Detaljnije: <input type="text" id="detaljnijeClanka"><br>Slika: <input type="text" id="slikaClanka"><br><input type="button" onclick="kreirajClanak()" value="Dodaj"><input type="button" onclick="azurirajClanak()" value="Ažuriraj"><input type="button" onclick="izbrisiClanak()" value="Izbriši"></form>';
		}
	}
	ajax.open("GET", "php/vijestiREST.php", true);
	ajax.send();
}

function izlistajKomentare() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var komentari = JSON.parse(ajax.responseText);
			document.getElementById("panel-lista").innerHTML = "";
			for (var i = 0; i < komentari.length; i++) {
				document.getElementById("panel-lista").innerHTML += '<span class="panel-stavka">ID: (' + komentari[i]['id'] + ') <span class="panel-stavka-vrijeme">' + komentari[i]['vrijeme'] + '</span> <span class="panel-stavka-vrijednost">' + komentari[i]['komentar'] + '</span></span><br>';
			}
			document.getElementById("panel-forma").innerHTML = "<hr><i>(Unesite ID komentara koji želite izbrisati!)</i>";
			document.getElementById("panel-forma").innerHTML += '<form>ID: <input type="text" id="idKomentara"><input type="button" onclick="izbrisiKomentar()" value="Izbriši"></form>';
		}
	}
	ajax.open("GET", "php/komentariREST.php", true);
	ajax.send();
}

function izlistajKorisnike() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var korisnici = JSON.parse(ajax.responseText);
			document.getElementById("panel-lista").innerHTML = "";
			for (var i = 0; i < korisnici.length; i++) {
				document.getElementById("panel-lista").innerHTML += '<span class="panel-stavka">ID: (' + korisnici[i]['id'] + ') <span class="panel-stavka-vrijeme">' + korisnici[i]['korisnik'] + '</span> <span class="panel-stavka-vrijednost">' + korisnici[i]['imeprezime'] + '</span></span><br>';
			}
			document.getElementById("panel-forma").innerHTML = "<hr><i>(Unesite ID korisnika koji želite izbrisati; za dodavanje/ažuriranje unosite ostala polja!)</i>";
			document.getElementById("panel-forma").innerHTML += '<form>ID: <input type="text" id="idKorisnika"><br>Korisničko ime: <input type="text" id="korisnickoImeKorisnika"><br>Lozinka: <input type="password" id="lozinkaKorisnika"><br>Email: <input type="text" id="emailKorisnika"><br>Ime i prezime: <input type="text" id="imePrezimeKorisnika"><br>Administrator? <input type="checkbox" id="daLiJeAdmin"><br><input type="button" onclick="kreirajKorisnika()" value="Dodaj"><input type="button" onclick="azurirajKorisnika()" value="Ažuriraj"><input type="button" onclick="izbrisiKorisnika()" value="Izbriši"></form>';
		}
	}
	ajax.open("GET", "php/korisniciREST.php", true);
	ajax.send();
}

function posaljiLink() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			alert("Poruka sa linkom potvrde je poslana na vašu email adresu.");
		}
	}
	var korisnik = document.getElementById("korisnickoime").value;
	ajax.open("POST", "php/posaljiLink.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("korisnik=" + korisnik);
}

function resetujLozinku() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			alert("Lozinka resetovana.");
		}
	}
	var password = document.getElementById("passwordproposal").value;
	var encrypt = document.getElementById("encrypt").value;
	ajax.open("POST", "php/resetujLozinku.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("encrypt=" + encrypt + "&password=" + password);
}