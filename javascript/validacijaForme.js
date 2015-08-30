var OK = true;

function validacijaForme() {
	if (!provjeriImeIPrezime() || !provjeriEmail() || !crossValidirajEmail() || OK == false || !provjeriKomentar()) {
		alert('Uneseni podaci nisu validni!');
		return false;
	}
	else {
		return true;
	}
}

function provjeriImeIPrezime() {
	var imeiprezime = document.getElementById("imeiprezime").value;
	var greska1 = document.getElementById("greska1");
	if (imeiprezime.length < 5 || imeiprezime.length > 50) {
		greska1.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Ime i prezime nije validno!";
		return false;
	}
	greska1.innerHTML = "";
	return true;
}

function provjeriEmail() {
	var email = document.getElementById("email").value;
	var greska2 = document.getElementById("greska2");
	var emailRegEx = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if (!emailRegEx.test(email)) {
		greska2.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Email nije validan!";
		return false;
	}
	greska2.innerHTML = "";
	return true;
}

function crossValidirajEmail() {
	var email_potvrda = document.getElementById("email_potvrda").value;
	var email = document.getElementById("email").value;
	var greska4 = document.getElementById("greska4");
	if (email_potvrda != email) {
		greska4.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Email adrese se ne slažu!";
		return false;
	}
	greska4.innerHTML = "";
	return true;
}

function validacijaMjestoOpcina() {
	OK = true;
	var mjesto = document.getElementById("mjesto").value;
	var opcina = document.getElementById("opcina").value;
	var greska5 = document.getElementById("greska5");
	var greska6 = document.getElementById("greska6");
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			if (ajax.responseText.indexOf('{"ok":') != -1) {
				greska5.innerHTML = greska6.innerHTML = "";
				OK = true;
			}
			else if (ajax.responseText.indexOf(':"Nepostojeća općina"}') != -1) {
				greska6.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Nepostojeća općina!";
				OK = false;
			}
			else if (ajax.responseText.indexOf(':"Nepostojeće mjesto"}') != -1) {
				greska5.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Nepostojeće mjesto!";
				OK = false;
			}
			else if (ajax.responseText.indexOf(':"Mjesto nije iz date općine"}') != -1) {
				greska5.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Mjesto nije iz date općine!";
				OK = false;
			}
		}
	}
	ajax.open("GET", "http://zamger.etf.unsa.ba/wt/mjesto_opcina.php?opcina=" + opcina + "&mjesto=" + mjesto, true);
	ajax.send();
}

function provjeriKomentar() {
	var komentar = document.getElementById("komentar").value;
	var greska3 = document.getElementById("greska3");
	if (komentar.length == 0) {
		greska3.innerHTML = "<img src='slike/error-icon.png' alt='Upozorenje!'> Polje za komentar je prazno!";
		return false;
	}
	greska3.innerHTML = "";
	return true;
}

function provjeriKontaktFormu() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var greske = JSON.parse(ajax.responseText);
			var validnost = 1;
			if (greske["greska1"] == "1") {
				document.getElementById("greska1").innerHTML = "<img src='slike/error-icon.png' alt='Greška!'> Ime i prezime nije validno!";
				validnost = 0;
			}
			if (greske["greska2"] == "1") {
				document.getElementById("greska2").innerHTML = "<img src='slike/error-icon.png' alt='Greška!'> Email nije validan!";
				validnost = 0;
			}
			if (greske["greska3"] == "1") {
				document.getElementById("greska3").innerHTML = "<img src='slike/error-icon.png' alt='Greška!'> Email adrese se ne slažu!";
				validnost = 0;
			}
			if (greske["greska4"] == "1") {
				document.getElementById("greska4").innerHTML = "<img src='slike/error-icon.png' alt='Greška!'> Polje za komentar je prazno!";
				validnost = 0;
			}
			if (validnost == 1) {
				document.getElementById("provjera_forme").innerHTML = "<h3>Provjerite da li ste ispravno popunili kontakt formu:</h3><b>Ime i prezime:</b> " + ime + "<br><b>Email:</b> " + email + "<br><b>Telefon:</b> " + telefon + "<br><b>Komentar:</b><br><textarea readonly rows='10' cols='40'>" + komentar + "</textarea><br><br>Da li ste sigurni da želite poslati ove podatke?";
				document.getElementById("provjera_forme").innerHTML += "<form action='kontakt.php' method='post' onsubmit='posaljiMail(); return false;'><input type='hidden' id='message-hidden' name='message-hidden' value='IME I PREZIME: " + ime + "; EMAIL: " + email + "; TELEFON: " + telefon + "; KOMENTAR: " + komentar + "'><input type='hidden' id='reply-to' name='reply-to' value='" + email + "'><input type='submit' name='siguransam' value='Siguran sam'></form>";
			}
			document.getElementById("suplja").innerHTML = "<hr><h3>Ako ste pogrešno popunili formu, možete ispod prepraviti unesene podatke:</h3>";
		}
	}
	var ime = document.getElementById("imeiprezime").value;
	var email = document.getElementById("email").value;
	var emailp = document.getElementById("email_potvrda").value;
	var telefon = document.getElementById("telefon").value;
	var komentar = document.getElementById("komentar").value;
	ajax.open("POST", "php/validacija.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("ime=" + ime + "&email=" + email + "&emailp=" + emailp + "&komentar=" + komentar);
}

function posaljiMail() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("provjera_forme").innerHTML = "<div id='zahvala'><h2>Zahvaljujemo se što ste nas kontaktirali.</h2></div>";
		}
	}
	var message = document.getElementById("message-hidden").value;
	var replyto = document.getElementById("reply-to").value;
	ajax.open("POST", "php/posaljiMail.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("messagehidden=" + message + "&replyto=" + replyto);
}