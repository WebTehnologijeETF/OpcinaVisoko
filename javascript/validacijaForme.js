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