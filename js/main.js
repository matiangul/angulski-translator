if(!String.prototype.trim) {
	String.prototype.trim = function () {
		return this.replace(/^\s+|\s+$/g,'');
	};
}
domready(function () {
	if (document.getElementById("text").innerText.trim() === '') {
		document.getElementById("text").innerHTML = '<span class="placeholder">' + document.getElementById("text").title + '</span>';
	}
	var changeActiveLanguage = function (event) {
		switch (event.target.id) {
			case "language-pl_de":
				document.getElementById("language-de_pl").style['display'] = 'block';
				document.getElementById("keyboardPL").style['display'] = 'none';
				document.getElementById("keyboardDE").style['display'] = 'block';
				document.getElementById('language-dir').value = document.getElementById("language-de_pl").value;
				break;
			case "language-de_pl":
				document.getElementById("language-pl_de").style['display'] = 'block';
				document.getElementById("keyboardPL").style['display'] = 'block';
				document.getElementById("keyboardDE").style['display'] = 'none';
				document.getElementById('language-dir').value = document.getElementById("language-pl_de").value;
				break;
		}
		event.target.style['display'] = 'none';
	};
	document.getElementById("language-pl_de").addEventListener("click", changeActiveLanguage, false);
	document.getElementById("language-de_pl").addEventListener("click", changeActiveLanguage, false);
	var insertDiacritic = function (event) {
		event.preventDefault();
		var letter = event.target.value;
		insertLetter(letter);
	};
	var deleteLastLetter = function () {
		var now = document.getElementById("text").innerHTML;
		document.getElementById("text").innerHTML = now.substring(0, now.length-1);
		if (document.getElementById("text").innerHTML.trim() === '') {
			document.getElementById("text").innerHTML = '<span class="placeholder">' + document.getElementById("text").title + '</span>';
		}
	};
	var insertLetter = function (letter) {
		if (document.querySelector("#text>.placeholder") != null) {
			document.getElementById("text").innerHTML = '';
		}
		document.getElementById("text").innerHTML += letter;
	};
	var submitForm = function (event) {
		if (document.querySelector("#text>.placeholder") != null) {
			document.getElementById("text").innerHTML = '';
		}
		document.getElementById('textInput').value = document.getElementById('text').innerText;
		document.getElementsByTagName("form")[0].submit();
	};
	addEventListener("keydown", function (event) {
		var pressedKey = parseInt(event.keyCode, 10),
				pressedKeyCode = pressedKey;
		if (pressedKey === 8) {
			event.preventDefault();
			pressedKey = 'backspace';
			onKeyboardKeyPress(pressedKey, pressedKeyCode);
		}
	});
	addEventListener("keypress", function (event) {
		event.preventDefault();
		var pressedKey = parseInt(event.which, 10),
				pressedKeyCode = pressedKey;
		pressedKey = String.fromCharCode(pressedKey);
		onKeyboardKeyPress(pressedKey, pressedKeyCode);
	});
	var onKeyboardKeyPress = function (key, code) {
		if (key === "backspace") {
			deleteLastLetter();
		} else if ( key.length === 1
								&& ( (code >= 63 && code <= 90) || (code >= 97 && code <= 122) || (code >= 48 && code <= 59)
											|| (code >= 44 && code <= 59) || code === 33 || code === 32 )
							) {
			insertLetter(key);
		}
	};
	var keys = document.querySelectorAll("#keyboardPL > button, #keyboardDE > button");
	for (var i = 0; i < keys.length; i++) {
		keys[i].addEventListener("click", insertDiacritic, false);
	}
	document.getElementById('translate').addEventListener('click', submitForm, false);
});
