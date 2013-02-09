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
 * Array utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0 
 */
class ArrayUtil {

	/**
	 * Check for non existing keys in an array.
	 * 
	 * @param array keys
	 * 					Array of keys to check in the target array.
	 * @param array targetArray
	 * 					The target array.
	 * @return array
	 * 					An array with the keys not found.
	 */
	static function nonExistingKeys( array $keys, array $targetArray ) {
		$notFound = array();
		foreach ( $keys as $k ) {
			if ( ! isset( $targetArray[ "$k" ] ) ) { // if ! array_key_exists( $k, $targetArray )
				array_push( $notFound, $k );
			}
		}
		return $notFound;
	}
}

?>