domready(function () {
  //change language direction
  var changeActiveLanguage = function(event) {
    event.target.style['display'] = 'none';
    switch(event.target.id) {
        case "language-pl_de":
            document.getElementById("language-de_pl").style['display'] = 'block';
            document.getElementById('language-dir').value = document.getElementById("language-de_pl").value;
            break;
        case "language-de_pl":
            document.getElementById("language-pl_de").style['display'] = 'block';
            document.getElementById('language-dir').value = document.getElementById("language-pl_de").value;
            break;
    }
  };
  document.getElementById("language-pl_de").addEventListener("click", changeActiveLanguage, false);
  document.getElementById("language-de_pl").addEventListener("click", changeActiveLanguage, false);
  //keyboard
  var insertDiacritic = function(event) {
    event.preventDefault();
    var letter = event.target.value;
    document.getElementById("text").focus();
    document.getElementById("text").value += letter;
  };
  var PLkeys = document.querySelectorAll("#keyboardPL > button");
  for(var i = 0; i < PLkeys.length; i++) {
		PLkeys[i].addEventListener("click", insertDiacritic, false);
  }
	var DEkeys = document.querySelectorAll("#keyboardDE > button");
  for(var i = 0; i < DEkeys.length; i++) {
		DEkeys[i].addEventListener("click", insertDiacritic, false);
  }
});
