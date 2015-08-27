function kreirajClanak() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajVijesti();
		}
	}
	var naslov = document.getElementById("naslovClanka").value;
	var autor = document.getElementById("autorClanka").value;
	var tekst = document.getElementById("tekstClanka").value;
	var detaljnije = document.getElementById("detaljnijeClanka").value;
	var slika = document.getElementById("slikaClanka").value;
	ajax.open("POST", "php/vijestiREST.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("naslov=" + naslov + "&autor=" + autor + "&tekst=" + tekst + "&detaljnije=" + detaljnije + "&slika=" + slika);
}

function azurirajClanak() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajVijesti();
		}
	}
	var id = document.getElementById("idClanka").value;
	var naslov = document.getElementById("naslovClanka").value;
	var autor = document.getElementById("autorClanka").value;
	var tekst = document.getElementById("tekstClanka").value;
	var detaljnije = document.getElementById("detaljnijeClanka").value;
	var slika = document.getElementById("slikaClanka").value
	ajax.open("PUT", "php/vijestiREST.php", true);
	ajax.send("id=" + id + "&naslov=" + naslov + "&autor=" + autor + "&tekst=" + tekst + "&detaljnije=" + detaljnije + "&slika=" + slika);
}

function izbrisiClanak() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajVijesti();
		}
	}
	var id = document.getElementById("idClanka").value;
	ajax.open("DELETE", "php/vijestiREST.php?id=" + id, true);
	ajax.send();
}

function izbrisiKomentar() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajKomentare();
		}
	}
	var id = document.getElementById("idKomentara").value;
	ajax.open("DELETE", "php/komentariREST.php?id=" + id, true);
	ajax.send();
}

function kreirajKorisnika() {
	var ajax = new XMLHttpRequest();
	var korisnik = document.getElementById("korisnickoImeKorisnika").value;
	var lozinka = document.getElementById("lozinkaKorisnika").value;
	var email = document.getElementById("emailKorisnika").value;
	var imeiprezime = document.getElementById("imePrezimeKorisnika").value;
	var admin = 0;
	if (document.getElementById("daLiJeAdmin").checked) {
		admin = 1;		
	}
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajKorisnike();
		}
	}
	ajax.open("POST", "php/korisniciREST.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("admin=" + admin + "&korisnik=" + korisnik + "&lozinka=" + lozinka + "&email=" + email + "&imeiprezime=" + imeiprezime);
}

function azurirajKorisnika() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajKorisnike();
		}
	}
	var id = document.getElementById("idKorisnika").value;
	var korisnik = document.getElementById("korisnickoImeKorisnika").value;
	var lozinka = document.getElementById("lozinkaKorisnika").value;
	var email = document.getElementById("emailKorisnika").value;
	var imeiprezime = document.getElementById("imePrezimeKorisnika").value;
	var admin = 0;
	if (document.getElementById("daLiJeAdmin").checked) {
		admin = 1;	
	}
	ajax.open("PUT", "php/korisniciREST.php", true);
	ajax.send("id=" + id + "&admin=" + admin + "&korisnik=" + korisnik + "&lozinka=" + lozinka + "&email=" + email + "&imeiprezime=" + imeiprezime);
}

function izbrisiKorisnika() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			izlistajKorisnike();
		}
	}
	var id = document.getElementById("idKorisnika").value;
	ajax.open("DELETE", "php/korisniciREST.php?id=" + id, true);
	ajax.send();
}