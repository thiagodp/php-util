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
 * @version	2.1
 */
class RTTI {

	/**
	 * Get the names and values of private attributes as a map.
	 * 
	 * @param obj			the object to get the private attributes.
	 * @param getterPrefix	the getter prefix used to get the values (defaults to 'get').
	 * @param useCamelCase	if uses camel case in method names (default to true).
	 * @return				an map with the found attribute names and their values.
	 */
	static function getPrivateAttributes( $obj, $getterPrefix = 'get', $useCamelCase = true ) {
		if ( ! isset( $obj ) ) {
			return array();
		}
		$attributes = array();
		$reflectionObject = new ReflectionObject( $obj );
		$currentClass = new ReflectionClass( $obj );
		while ( $currentClass !== false && ! $currentClass->isInterface() ) {					
			$properties = $currentClass->getProperties( ReflectionProperty::IS_PRIVATE );
			foreach ( $properties as $property ) {
				$attributeName = $property->getName();
				$methodName = $getterPrefix . ( $useCamelCase ? ucfirst( $attributeName ) : $attributeName );
				if ( $reflectionObject->hasMethod( $methodName ) ) {
					$method = $reflectionObject->getMethod( $methodName );
					if ( $method->isPublic() ) {
						$attributes[ $attributeName ] = $method->invoke( $obj );
					}
				}
			}
			$currentClass = $currentClass->getParentClass();
		}
		return $attributes;		
	}

	/**
	 * Set the attributes of an object with the values of a given array.
	 *
	 * @param map			the array that contains the keys and values.
	 * @param obj			the object to fill with the array values.
	 * @param setterPrefix	the prefix used for setters (default to 'set').
	 * @param useCamelCase	if uses camel case in method names (default to true).
	 */
	static function setPrivateAttributes(
		array $map, &$obj, $setterPrefix = 'set', $useCamelCase = true ) {
		
		$reflectionObject = new ReflectionObject( $obj );
		$currentClass = new ReflectionClass( $obj );
		while ( $currentClass !== false && ! $currentClass->isInterface() ) {					
			$properties = $currentClass->getProperties( ReflectionProperty::IS_PRIVATE );
			foreach ( $properties as $property ) {
				$attributeName = $property->getName();
				$methodName = $setterPrefix . ( $useCamelCase ? ucfirst( $attributeName ) : $attributeName );
				if ( $reflectionObject->hasMethod( $methodName ) ) {
					$method = $reflectionObject->getMethod( $methodName );
					if ( $method->isPublic() && array_key_exists( $attributeName, $map ) ) {
						$method->invoke( $obj, $map[ $attributeName ] );
					}
				}
			}
			$currentClass = $currentClass->getParentClass();
		}
	}
	
}

?>