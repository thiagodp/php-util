<?php
/* THIS FILE:
 * a)	BELONGS TO THE 'PHP-UTIL' LIBRARY:
 *		https://github.com/thiagodp/php-util
 *
 * b)	IS DISTRIBUTED UNDER THE CREATIVE COMMONS LICENCE (CC BY 3.0):
 * 		http://creativecommons.org/licenses/by/3.0/
 *
 * USE IT AT YOUR OWN RISK!
 */
 
/**
 * Useful string functions.
 *
 * @author	Thiago Delgado Pinto
 * @version	0.9
 */
class StrUtil {

	/**
	 * Transform a not encoded string to uppercase.
	 *
	 * @param text	A not encoded text.
	 * @return		A not encoded text in uppercase.
	 */
	static function toUpper( $text ) {
		return self::applyCase( $text, true );
	}

	/**
	 * Transform a not encoded string to lowercase.
	 *
	 * @param text	A not encoded text.
	 * @return		A not encoded text in lowercase.
	 */
	static function toLower( $text ) {
		return self::applyCase( $text, false );
	}
	
	/**
	 * Transform all the letters to lowercase and just the first letter of each word to uppercase.
	 *
	 * TODO: Add a parameter "exceptions" where can be supplied the words to not consider.
	 * 
	 * @param text		The text to transform.
	 * @param separator	Array of separator characters (one character per value).
	 * @return			The transformed text.
	 */
	static function upperCaseFirst( $text, $separator = array( ' ' ) ) {
		return preg_replace( '/([' . implode( '', $separator ) . ']|^)([a-z])/e',
			'"$1".StrUtil::toUpper("$2")', StrUtil::toLower( $text ) );
	}
	
	/**
	 * Apply a case transformation to the text.
	 *
	 * @param text				A not encoded text.
	 * @param convertToUpper	true to transform to upper case or false to lower case.
	 * @return 					A not encoded text transformed to upper or lower case.
	 */
	private static function applyCase( $text, $convertToUpper = false ) {		
		$func = $convertToUpper ? 'strtoupper' : 'strtolower'; // Choose the function to apply
		$newText = htmlentities( $func( $text ) ); // Convert to entities
		$range = $convertToUpper ? 'a-z' : 'A-Z'; // Choose the character range after "&"
		$search = '/\&(['. $range .'])(acute|cedil|circ|elig|horn|grave|ring|slash|th|tilde|uml);/e'; // Example: &aacute;
		$newText2 = preg_replace( $search, "'&'.". $func ."('\\1').'\\2'.';'", $newText ); // Example: &aacute; becomes &Aacute;
		return html_entity_decode( $newText2 ); // Decode the entities
	}	
}

?>