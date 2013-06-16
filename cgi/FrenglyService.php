<?php
class FrenglyService {
	private static $configuration = array(
		'login'    => 'angua1990@gmail.com',
		'password' => 'angulskitranslator'
	);

	private static $langs = array(
		"de", "it", "fi", "pl", "pt", "fr", "en", "ar", "hi", "es", "ja", "nl",
		"bg", "ar", "bg", "zh-CN", "zh-TW", "hr", "cs", "da", "nl", "en", "tl",
		"fi", "fr", "de", "el", "iw", "hi", "hu", "id", "ga", "it", "ja", "ko",
		"la", "no", "fa", "pl", "pt", "ro", "ru", "sr", "sk", "es", "sv", "th",
		"tr", "vi"
	);

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
		if ( ! is_string( $what ) || ! is_string( $from ) || ! is_string( $to ) ) {
			throw new \InvalidArgumentException( "Invalid argument type passed" );
		}
		elseif ( $from === '' || $to === '' || ! in_array( $to, self::$langs ) || ! in_array( $from, self::$langs ) ) {
			throw new \InvalidArgumentException( "Not supported language passed" );
		}
		elseif ( $what === '' ) {
			return '';
		}
		$what     = urlencode( $what );
		$response = file_get_contents( "http://syslang.com/?src=$from&dest=$to&text=$what&email=" . self::$configuration['login'] . "&password=" . self::$configuration['password'] . "&outformat=json" );
		$resObj   = json_decode( $response );
		if ( ! ( $resObj instanceof stdClass ) ) {
			$xmlObj = simplexml_load_string( $response );
			throw new \RuntimeException( (string) $xmlObj );
		}
		return $resObj->translation;
	}
}
