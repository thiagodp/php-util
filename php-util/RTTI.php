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
 * @version	1.2
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
		if ( ! isset( $obj ) ) {
			return array();
		}
		$attributes = array();
		$reflectionObject = new ReflectionObject( $obj );		
		$className = get_class( $obj );
		$currentClass = new ReflectionClass( $className );
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

}

?>