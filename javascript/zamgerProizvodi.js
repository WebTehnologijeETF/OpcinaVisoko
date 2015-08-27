function unesiRed(id, naziv, drzava, slika) {
	return "<tr id='" + id + "' class='gradovi-red' onclick='ispuniFormu(this)'><td>" + naziv + "</td><td>" + drzava + "</td><td><img src='" + slika + "' style='height:50px; width:auto;'></td></tr>";
}

function ispuniFormu(red) {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var gradovi = JSON.parse(ajax.responseText);
			var grad = gradovi[parseInt(red.id) - 1];
			opcijeMijenjanja(parseInt(red.id));
			document.getElementById("idGrada").value = grad.id;
			document.getElementById("nazivGrada").value = grad.naziv;
			document.getElementById("drzavaGrada").value = grad.opis;
			document.getElementById("grbGrada").value = grad.slika;
		}
	}
	ajax.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15704", true);
	ajax.send();
}

function ucitajGradove() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var gradovi = JSON.parse(ajax.responseText);
			document.getElementById("gradovi").innerHTML = "<tr><th>Grad</th><th>Država</th><th>Grb</th></tr>";
			for (var i = 0; i < gradovi.length; i++) {
				document.getElementById("gradovi").innerHTML += unesiRed(i + 1, gradovi[i].naziv, gradovi[i].opis, gradovi[i].slika);
			}
		}
	}
	ajax.open("GET", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15704", true);
	ajax.send();
}

function izbrisiGrad(id, naziv, drzava, slika) {
	var grad = {id:id,naziv:naziv,opis:drzava,slika:slika};
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			ucitajGradove();
		}
	}
	ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15704", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("akcija=brisanje&brindexa=15704&proizvod=" + JSON.stringify(grad));
}

function azurirajGrad(id, naziv, drzava, slika) {	
	var grad = {id:id,naziv:naziv,opis:drzava,slika:slika};
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			ucitajGradove();
		}
	}
	ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15704", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("akcija=promjena&brindexa=15704&proizvod=" + JSON.stringify(grad));
}

function dodajGrad(naziv, drzava, slika) {
	var grad = {naziv:naziv,opis:drzava,slika:slika};
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("nazivGrada").value = document.getElementById("drzavaGrada").value = document.getElementById("grbGrada").value = "";
			ucitajGradove();
		}
	}
	ajax.open("POST", "http://zamger.etf.unsa.ba/wt/proizvodi.php?brindexa=15704", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("akcija=dodavanje&brindexa=15704&proizvod=" + JSON.stringify(grad));
}

function dodavanjeGrada() {
	var naziv = document.getElementById("nazivGrada").value;
	var drzava = document.getElementById("drzavaGrada").value;
	var slika = document.getElementById("grbGrada").value;
	if (naziv.length > 0 && drzava.length > 0 && slika.length > 0) {
		dodajGrad(naziv, drzava, slika);
	}
	else {
		alert("Nevalidan unos!");
	}
}

function azuriranjeGrada() {
	var naziv = document.getElementById("nazivGrada").value;
	var drzava = document.getElementById("drzavaGrada").value;
	var slika = document.getElementById("grbGrada").value;
	if (naziv.length > 0 && drzava.length > 0 && slika.length > 0) {
		var id = document.getElementById("idGrada").value;
		azurirajGrad(id, naziv, drzava, slika);
	}
	else {
		alert("Nevalidan unos!");
	}
}

function brisanjeGrada() {
	var naziv = document.getElementById("nazivGrada").value;
	var drzava = document.getElementById("drzavaGrada").value;
	var slika = document.getElementById("grbGrada").value;
	if (naziv.length > 0 && drzava.length > 0 && slika.length > 0) {
		var id = document.getElementById("idGrada").value;
		izbrisiGrad(id, naziv, drzava, slika);
	}
	else {
		alert("Nevalidan unos!");
	}
}

function sakrijOpcije() {
	document.getElementById("dugmeDodajGrad").value = "Dodaj grad";
	document.getElementById("opcije").innerHTML = "<div id='opcijeUnos'></div>";
	document.getElementById("opcijeUnos").innerHTML = "";
	document.getElementById("opcije").style.display = "none";
}

function opcijeDodavanja() {
	if (document.getElementById("dugmeDodajGrad").value == "Dodaj grad") {
		document.getElementById("dugmeDodajGrad").value = "Sakrij opcije";
		document.getElementById("opcije").innerHTML = "<i>(Klik na red će učitati vrijednosti u formu)</i>";
		document.getElementById("opcije").innerHTML += "<div id='opcijeUnos'></div>";
		document.getElementById("opcijeUnos").innerHTML = "Naziv: <input id='nazivGrada' type='text'><br>Država: <input id='drzavaGrada' type='text'><br>Slika: <input id='grbGrada' type='text'>";
		document.getElementById("opcije").innerHTML += "<input type='button' onclick='dodavanjeGrada()' value='Dodaj'>";
		document.getElementById("opcije").style.display = "block";
	}
	else {
		sakrijOpcije();
	}
}

function opcijeMijenjanja(row) {
	document.getElementById("dugmeDodajGrad").value = "Sakrij opcije";
	document.getElementById("opcije").innerHTML = "<i>(Klik na red će učitati vrijednosti u formu)</i>";
	document.getElementById("opcije").innerHTML += "<div id='opcijeUnos'></div><input type='button' onclick='dodavanjeGrada()' value='Dodaj'>";
	document.getElementById("opcijeUnos").innerHTML += "ID: <input id='idGrada' type='text' disabled><br>Naziv: <input id='nazivGrada' type='text'><br>Država: <input id='drzavaGrada' type='text'><br>Slika: <input id='grbGrada' type='text'>";
	document.getElementById("opcije").innerHTML += "<input type='button' onclick='azuriranjeGrada()' value='Ažuriraj'>";
	document.getElementById("opcije").innerHTML += "<input type='button' onclick='brisanjeGrada()' value='Izbriši'>";
	document.getElementById("opcije").style.display = "block";
}