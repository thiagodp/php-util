<?php

/**
 * Parameter utilities.
 *
 * @author	Thiago Delgado Pinto
 */
class ParamUtil {

	/**
	 * Return a value from the $_GET array using some options.
	 * @see {@code value()}.
	 */
	static function get( $key, $useTrim = true, $encodeAll = false ) {
		return self::value( $_GET, $key, $encodeAll );
	}

	/**
	 * Return a value from the $_POST array using some options.
	 * @see {@code value()}.
	 */
	static function post( $key, $useTrim = true, $encodeAll = false ) {
		return self::value( $_POST, $key, $encodeAll );
	}
	
	/**
	 * Return a value from the $_REQUEST array using some options.
	 * @see {@code value()}.
	 */	
	static function request( $key, $useTrim = true, $encodeAll = false ) {
		return self::value( $_REQUEST, $key, $encodeAll );
	}

	/**
	 * Returns a value from an array using some options.
	 *
	 * @param array		the target array.
	 * @param key		the array key.
	 * @param useTrim	option to use trim() in the value.
	 * @param encodeAll	option to encode all the characters, using
	 *					{@code htmlentities()}, or not, using
	 *					{@code htmlspecialchars()}. Remember that the latter
	 *					replaces only <, >, ", ', and & and it is recommended
	 *					for	most cases, since the accents are kept.
	 * @return			the encoded value or null if the key is not found.
	 */
	private static function value( array $array, $key, $useTrim, $encodeAll ) {
		if ( ! isset( $array[ $key ] ) ) {
			return null;
		}
		$content = ( $useTrim ) ? trim( $array[ $key ] ) : $array[ $key ];
		if ( $encodeAll ) {	
			return htmlentities( $content, ENT_COMPAT, 'UTF-8' );
		}
		return htmlspecialchars( $content, ENT_COMPAT, 'UTF-8' );
	}
}

?>