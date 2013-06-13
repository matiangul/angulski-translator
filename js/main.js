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
  document.getElementById('language-dir').addEventListener("change", function() {alert("aa");}, false);
  document.getElementById("language-pl_de").addEventListener("click", changeActiveLanguage, false);
  document.getElementById("language-de_pl").addEventListener("click", changeActiveLanguage, false);
})
