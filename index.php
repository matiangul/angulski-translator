<!DOCTYPE html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="css/normalize.min.css">
	<link rel="stylesheet" href="css/main.css">

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
	<![endif]-->
</head>
<body>
<?php
require 'cgi/FrenglyService.php';
require 'cgi/GoogleTranslateService.php';
//strings
$pl_de = 'Polski ~> Niemiecki';
$de_pl = 'Niemiecki ~> Polski';
$translate = 'Tłumacz';
$exception = 'Twój tłumacz nie ma teraz czasu';
//process request
$defaultLanguage = 'pl_de';
$defaultTranslation = '';
$defaultText = '';
$language = ( isset( $_POST['language-dir'] ) == true ) ? $_POST['language-dir'] : $defaultLanguage;
$text = ( isset( $_POST['text'] ) == true ) ? $_POST['text'] : $defaultText;
$translationFrengly = $defaultTranslation;
$translationGoogle = array();
$translationGoogle[0] = $defaultTranslation;
if ( isset( $_POST['language-dir'] ) && isset( $_POST['text'] ) ) {
	$languages = explode( '_', $language );
	$src       = $languages[0];
	$dest      = $languages[1];
	$done = 0;
	while ( $done < 3 ) {
		try {
			$translationGoogle = GoogleTranslateService::translate( $text, $src, $dest );
		} catch ( \Exception $e ) {
			$translationGoogle[0] = $exception;
			//try again after 3,5 sec
			usleep( 3005000 );
			$done ++;
			continue;
		}
		$done = 3;
	}
}
if ( $translationGoogle[0] === '' ) {
	$translationGoogle[0] = $defaultTranslation;
}
?>
<div id="container">
	<td><button id="language-pl_de" <?php echo $language === 'pl_de' ? '' : 'style="display:none;"' ?> value="pl_de"><?php echo $pl_de ?></button></td>
	<td><button id="language-de_pl" <?php echo $language === 'de_pl' ? '' : 'style="display:none;"' ?> value="de_pl"><?php echo $de_pl ?></button></td>
	<form method="post" action="http://<?php echo $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>">
		<input type="hidden" id="language-dir" name="language-dir" value="<?php echo $language ?>" />
		<p id="text" title="Tekst do tłumaczenia"><?php echo $text ?></p>
		<input type="hidden" id="textInput" name="text" value="" />
		<div id="keyboardPL" <?php echo $language === 'pl_de' ? '' : 'style="display:none;"' ?> >
			<span class="helper">PL: </span>
			<button value="ą">ą</button>
			<button value="ć">ć</button>
			<button value="ę">ę</button>
			<button value="ł">ł</button>
			<button value="ń">ń</button>
			<button value="ó">ó</button>
			<button value="ś">ś</button>
			<button value="ź">ź</button>
			<button value="ż">ż</button>
		</div>
		<div id="keyboardDE" <?php echo $language === 'de_pl' ? '' : 'style="display:none;"' ?>>
			<span class="helper">DE: </span>
			<button value="ä">ä</button>
			<button value="ö">ö</button>
			<button value="ß">ß</button>
			<button value="ü">ü</button>
		</div>
		<p id="translationGoogle">
			<?php echo $translationGoogle[0] ?>
			<?php echo isset( $translationGoogle[1] ) == true ? ' / ' . $translationGoogle[1] : '' ?>
		</p>
		<div class="clearfix"></div>
		<button name="translate" id="translate" value="translate"><?php echo $translate ?></button>
	</form>
</div>
<script src="js/vendor/ready.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
