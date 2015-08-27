function hideDropDownMenu() {
	document.getElementById('podmeni').style.display = 'none';
}

function toggleDropDownMenu() {
	if (document.getElementById('podmeni').style.display == 'none') {
		document.getElementById('podmeni').style.display = 'block';
	}
	else {
		document.getElementById('podmeni').style.display = 'none';
	}
	return false;
}