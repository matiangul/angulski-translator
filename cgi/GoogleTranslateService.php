<?php
class GoogleTranslateService {
	private static $lastRequestTime = null;
	private static $langs = array(
		"de", "it", "fi", "pl", "pt", "fr", "en", "ar", "hi", "es", "ja", "nl",
		"bg", "ar", "bg", "zh-CN", "zh-TW", "hr", "cs", "da", "nl", "en", "tl",
		"fi", "fr", "de", "el", "iw", "hi", "hu", "id", "ga", "it", "ja", "ko",
		"la", "no", "fa", "pl", "pt", "ro", "ru", "sr", "sk", "es", "sv", "th",
		"tr", "vi"
	);

	private static function curl( $url, $params = array(), $is_coockie_set = false ) {
		if ( ! $is_coockie_set ) {
			/* STEP 1. let’s create a cookie file */
			$ckfile = tempnam( "/tmp", "CURLCOOKIE" );
			/* STEP 2. visit the homepage to set the cookie properly */
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_COOKIEJAR, $ckfile );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_exec( $ch );
		}
		$str     = '';
		$str_arr = array();
		foreach ( $params as $key => $value ) {
			$str_arr[] = urlencode( $key ) . "=" . urlencode( $value );
		}
		if ( ! empty( $str_arr ) )
			$str = '?' . implode( '&', $str_arr );
		/* STEP 3. visit cookiepage.php */
		$Url = $url . $str;

		$ch = curl_init( $Url );
		curl_setopt( $ch, CURLOPT_COOKIEFILE, $ckfile );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$output = curl_exec( $ch );
		return $output;
	}

	/**
	 * Translate string from language $from to language $to
	 *
	 * @param string $what string to translate
	 * @param string $from language of what string
	 * @param string $to   language desired
	 *
	 * @return string translation in $to language
	 */
	public static function translate( $what, $from, $to ) {
		if (self::$lastRequestTime!==null && self::$lastRequestTime->diff(new \DateTime())->s < 3) {
			throw new \RuntimeException('The minimum time between API call is 3 seconds');
		}
		if ( ! is_string( $what ) || ! is_string( $from ) || ! is_string( $to ) ) {
			throw new \InvalidArgumentException( "Invalid argument type passed" );
		}
		elseif ( $from === '' || $to === '' || ! in_array( $to, self::$langs ) || ! in_array( $from, self::$langs ) ) {
			throw new \InvalidArgumentException( "Not supported language passed" );
		}
		elseif ( $what === '' ) {
			return array('');
		}
		$what = urlencode( $what );
		$url  = "http://translate.google.com/translate_a/t?client=t&text=$what&hl=" . $to . "&sl=" . $from . "&tl=" . $to . "&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";
		self::$lastRequestTime = new \DateTime();
		$translated = self::curl( $url );
		$translated = explode( '"', $translated );

		return array($translated[1], $translated[11]);
	}
}
