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
 * Casting utilities.
 *
 * @author	Thiago Delgado Pinto
 */
class CastUtil {

	/**
     * Convert an object to a specific class.
	 *
	 * This method was based on the code from 'rmirabelle', from
	 * http://php.net/manual/pt_BR/language.types.type-juggling.php
     *
     * @param object	the object to be casted.
     * @param className	the class name to cast the object to.
     * @return			the casted object object.
     */
    static function cast( $object, $className ) {
        if( ! isset( $object ) ) throw new IllegalArgumentException( 'object is null' );
        if( ! isset( $className ) ) throw new IllegalArgumentException( 'class name is null' );        
		$serializedObj = serialize( $object );
		$nameLength	= strlen( get_class( $object ) );
		$start = $nameLength + strlen( $nameLength ) + 6;
		$newObj = 'O:' . strlen( $className ) . ':"' . $className . '":' . substr( $serializedObj, $start );
		$newObj = unserialize( $newObj );
		$graph = new $className;
		foreach ( $newObj as $prop => $val ) {
			$graph->$prop = $val;
		}
		return $graph;
    }
}
?>