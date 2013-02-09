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
 * Run time type information utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.1
 */
class RTTI {

	/**
	 * Get private attribute names and their values as a map.
	 * 
	 * @param obj			the object to get the private attributes.
	 * @param getterPrefix	the getter prefix used to get the values (defaults to 'get').
	 * @param useCamelCase	if uses camel case in method name (default to true).
	 * @return				an map with the found attribute names and their values.
	 */
	static function getPrivateAttributes( $obj, $getterPrefix = 'get', $useCamelCase = true ) {
		$attributes = array();
		$reflectionObject = new ReflectionObject( $obj );
		$properties = $reflectionObject->getProperties( ReflectionProperty::IS_PRIVATE );
		foreach ( $properties as $p ) {
			$attributeName = $p->getName();
			$methodName = $getterPrefix . ( $useCamelCase ? ucfirst( $attributeName ) : $attributeName );
			$attributes[ $attributeName ] = $reflectionObject->getMethod( $methodName )->invoke( $obj );
		}
		return $attributes;
	}

}

?>