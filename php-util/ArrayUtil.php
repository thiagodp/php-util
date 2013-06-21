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
 * @version	1.1 
 */
class ArrayUtil {

	/**
	 * Check for non existing keys in an array.
	 * 
	 * @param keys			an array with the keys to check in the target array.
	 * @param targetArray	the target array.
	 * @return				an array with the keys not found.
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

	/**
	 * Removes an item from an array.
	 *
	 * @param array array				the array with the item.
	 * @param unknown_type item			the item to remove.
	 * @param boolean reindexArray		option to reindex the array after removing. Default is true.
	 * @param boolean compareItemTypes	option to compare the items with === instead of ==. Default is false.
	 * @return							true if removed, false otherwise.
	 */
	static function removeItem( array &$array, $item, $reindexArray = true, $compareItemTypes = false ) {
		if ( ! isset( $array ) || ! isset( $item ) ) {
			return false;
		}
		$key = array_search( $item, $array, $compareItemTypes );
		if ( false === $key ) {
			return false;
		}
		unset( $array[ $key ] );
		if ( $reindexArray ) {
			$array = array_values( $array );
		}
		return true;
	}

}
?>