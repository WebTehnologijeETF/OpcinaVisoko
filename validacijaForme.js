var forma = document.getElementById('forma');
var imeiprezime = document.getElementById('imeiprezime');
var email = document.getElementById('email');
var email_potvrda = document.getElementById('email_potvrda');
var komentar = document.getElementById('komentar');
var greska1 = document.getElementById('greska1');
var greska2 = document.getElementById('greska2');
var greska3 = document.getElementById('greska3');
var greska4 = document.getElementById('greska4');
forma.addEventListener("submit", validacijaForme, false);
imeiprezime.addEventListener("blur", provjeriImeIPrezime);
email.addEventListener("blur", provjeriEmail);
email_potvrda.addEventListener("blur", crossValidirajEmail);
komentar.addEventListener("blur", provjeriKomentar);

var emailRegEx = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;

function validacijaForme() {
	if (!provjeriImeIPrezime() || !provjeriEmail() || !provjeriKomentar() || !crossValidirajEmail()) {
		alert('Uneseni podaci nisu validni!');
		return false;
	}
	else {
		return true;
	}
}

function crossValidirajEmail() {
	if (email_potvrda.value != email.value) {
		greska4.innerHTML = "<img src='warning-icon.png' alt='Upozorenje!'> Email adrese se ne slažu!";
		return false;
	}
	greska4.innerHTML = "";
	return true;
}

function provjeriImeIPrezime() {
	if (imeiprezime.value.length < 5 || imeiprezime.value.length > 50) {
		greska1.innerHTML = "<img src='warning-icon.png' alt='Upozorenje!'> Ime i prezime nije validno!";
		return false;
	}
	greska1.innerHTML = "";
	return true;
}

function provjeriEmail() {
	if (!emailRegEx.test(email.value)) {
		greska2.innerHTML = "<img src='warning-icon.png' alt='Upozorenje!'> Email nije validan!";
		return false;
	}
	greska2.innerHTML = "";
	return true;
}

function provjeriKomentar() {
	if (komentar.value.length == 0) {
		greska3.innerHTML = "<img src='warning-icon.png' alt='Upozorenje!'> Polje za komentar je prazno!";
		return false;
	}
	greska3.innerHTML = "";
	return true;
}