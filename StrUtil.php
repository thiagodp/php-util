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
 * @author		Thiago Delgado Pinto
 * @version		1.0
 */
class StrUtil {

	/**
	 * Transform a snake_case string into a camelCase string.
	 *
	 * @param string $snake	the string to convert
	 * @return string
	 */
	static function snakeToCamel( $snake ) {
			$pieces = explode( '_', $snake );
			$count = count( $pieces );
			if ( 1 == $count ) {
				return $snake;
			}
			$str = $pieces[ 0 ];
			for ( $i = 1; $i < $count; ++$i ) {
				$p = $pieces[ $i ];
				$str .= mb_strtoupper( $p[ 0 ] ) . mb_substr( $p, 1 );
			}
			return $str;
	}

	/**
	 * Transform a camelCase string into a snake_case string.
	 *
	 * @param string $camel	the string to convert
	 * @return string
	 */
	static function camelToSnake( $camel ) {
		return mb_strtolower( preg_replace( '/([A-Z])/u', "_$1", $camel ) );
	}

	/**
	 * Transform a text to uppercase.
	 *
	 * @deprecated	Use {@link mb_strtoupper} instead.
	 *
	 * @param text		the text to transform.
	 * @param encoding	the character encoding to use. default is {@link mb_internal_encoding()}.
	 * @return			the text in uppercase.
	 */
	static function toUpper( $text, $encoding = null ) {
		$enc = is_string( $encoding ) ? $encoding : mb_internal_encoding();
		return mb_strtoupper( $text, $enc );
	}

	/**
	 * Transform a text to lowercase.
	 *
	 * @deprecated	Use {@link mb_strtolower} instead.
	 *
	 * @param text		the text to transform.
	 * @param encoding	the character encoding to use. default is {@link mb_internal_encoding()}.
	 * @return			the text in lowercase.
	 */
	static function toLower( $text, $encoding = null ) {
		$enc = is_string( $encoding ) ? $encoding : mb_internal_encoding();
		return mb_strtolower( $text, $enc );
	}
	
	/**
	 * Transform all the letters to lowercase and just the first letter of each word to uppercase.
	 * 
	 * This method can be replaced by {@code mb_convert_case( 'your text here', MB_CASE_TITLE )} when
	 * the {@code exceptions} parameter is not given.
	 *
	 * How to use it:
	 * #( 'john von neumann', array( ' von ' ) ) ==> 'John von Neumann'
	 * #( 'JOHN VON NEUMANN', array( ' von ' ) ) ==> 'John von Neumann'
	 * #( 'maria da silva e castro', array( ' da ', ' e '  ) ) ==> 'Maria da Silva e Castro'
	 *
	 * @see {@link commonNameExceptions}.
	 * 
	 * @param text			text to transform.
	 * @param exceptions	array of words to ignore exceptions.
	 * @param encoding		the character encoding to use. default is {@link mb_internal_encoding()}.
	 * @return				the transformed text.
	 */
	static function upperCaseFirst(
		$text,
		array $exceptions = array(),
		$encoding = null
		) {
		$enc = is_string( $encoding ) ? $encoding : mb_internal_encoding();
		$newText = mb_convert_case( $text, MB_CASE_TITLE, $enc );
		if ( count( $exceptions ) < 1 ) {
			return $newText;
		}
		foreach ( $exceptions as $e ) {
			$newText = str_replace( mb_convert_case( $e, MB_CASE_TITLE, $enc ),
				mb_convert_case( $e, MB_CASE_LOWER, $enc ), $newText );
		}
		return $newText;
	}

	/** Common name separators to be used as exceptions with {@link upperCaseFirst}. */
	static function commonNameSeparators() {
		return array(
			' de ', ' da ', ' di ', ' del ', ' della ',
			' e ', ' i ', ' y ',
			' van ', ' von '
			);
	}
}

?>