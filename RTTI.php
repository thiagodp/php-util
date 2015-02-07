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
 * @version	3.1
 */
class RTTI {
	
	const IS_PRIVATE	= ReflectionProperty::IS_PRIVATE;
	const IS_PROTECTED	= ReflectionProperty::IS_PROTECTED;
	const IS_PUBLIC		= ReflectionProperty::IS_PUBLIC;
	
	
	/**
	 * Return all the visibility flags.
	 * @return int
	 */
	static function allFlags() { 
		return ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC;
	}
	
	/**
	 *  Just a synonym to allFlags()
	 * @return int
	 */
	static function anyVisibility() {
		return self::allFlags();
	}
		

	/**
	 * Retrieve names and values from the attributes of a object, as a map.
	 * 
	 * @param object	$obj				The object.
	 *
	 * @param int		$visibilityFlags 	Filter visibility flags. Can be added.
	 *										Example: RTTI::IS_PRIVATE | RTTI::IS_PROTECTED
	 *
	 * @param string	$getterPrefix		The prefix for getter public methods (defaults to 'get').
	 *
	 * @param bool		$useCamelCase		If true, private and protected attributes will be accessed
	 * 										by camelCase public methods (default true).
	 *
	 * @return array
	 */
	static function getAttributes( $obj, $visibilityFlags, $getterPrefix = 'get', $useCamelCase = true ) {
		if ( ! isset( $obj ) ) {
			return array();
		}
		$attributes = array();
		$reflectionObject = new ReflectionObject( $obj );
		$currentClass = new ReflectionClass( $obj );
		
		while ( $currentClass !== false && ! $currentClass->isInterface() ) {	
		
			$properties = $currentClass->getProperties( $visibilityFlags );
				
			foreach ( $properties as $property ) {
				
				$attributeName = $property->getName();
				$methodName = $getterPrefix . ( $useCamelCase ? ucfirst( $attributeName ) : $attributeName );
				
				if ( $property->isPrivate() || $property->isProtected() ) {
				
					if ( $reflectionObject->hasMethod( $methodName ) ) {
						
						$method = $reflectionObject->getMethod( $methodName );
						if ( $method->isPublic() ) {
							$attributes[ $attributeName ] = $method->invoke( $obj );
						}
					}
					
				} else { // public
					
					try {
						$attributes[ $attributeName ] = $obj->{ $attributeName };
					} catch (Exception $e) {
						// Ignore
					}
				}
				
			}
			
			// No properties? -> try to retrieve only public properties
			if ( count( $properties ) < 1 ) {
				$properties = get_object_vars( $obj );
				foreach ( $properties as $k => $v ) {
					$attributes[ $k ] = $v;
				}
			}
			
			$currentClass = $currentClass->getParentClass();
		}
		return $attributes;		
	}		
	
	
	
	/**
	 * Retrieve names and values from the private attributes of a object, as a map.
	 * This method has been kept for backward compatibility.
	 * 
	 * @param object	$obj				The object.
	 * @param string	$getterPrefix		The prefix for getter public methods (defaults to 'get').
	 * @param bool		$useCamelCase		If true, private attributes will be accessed by camelCase public methods (default true).
	 * @return array
	 */
	static function getPrivateAttributes( $obj, $getterPrefix = 'get', $useCamelCase = true ) {
		return self::getAttributes( $obj, self::IS_PRIVATE, $getterPrefix, $useCamelCase );
	}
	
	
	
	/**
	 * Set the attribute values of a object.
	 * 
	 * @param array		$map				A map with the attribute names and values to be changed.
	 *
	 * @param object	$obj				The object to be changed.
	 *
	 * @param int		$visibilityFlags 	Filter visibility flags. Can be added.
	 * 										Example: RTTI::IS_PRIVATE | RTTI::IS_PROTECTED
	 *
	 * @param string	$setterPrefix		The prefix for setter public methods (defaults to 'set').
	 *
	 * @param bool		$useCamelCase		If true, private and protected attributes will be set by
	 *										camelCase public methods (default true).
	 */	
	static function setAttributes(
		array $map, &$obj, $visibilityFlags, $setterPrefix = 'set', $useCamelCase = true
		) {
		$reflectionObject = new ReflectionObject( $obj );
		$currentClass = new ReflectionClass( $obj );
		while ( $currentClass !== false && ! $currentClass->isInterface() ) {
		
			$properties = $currentClass->getProperties( $visibilityFlags );
				
			foreach ( $properties as $property ) {
				
				$attributeName = $property->getName();
				$methodName = $setterPrefix . ( $useCamelCase ? ucfirst( $attributeName ) : $attributeName );
				
				if ( $property->isPrivate() || $property->isProtected() ) {
					
					if ( $reflectionObject->hasMethod( $methodName ) ) {
						
						$method = $reflectionObject->getMethod( $methodName );
						if ( $method->isPublic() && array_key_exists( $attributeName, $map ) ) {
							$method->invoke( $obj, $map[ $attributeName ] );
						}
					}
					
				} else { // public
					try {
						if ( array_key_exists( $attributeName, $map ) ) {
							$obj->{ $attributeName } = $map[ $attributeName ];
						}
					} catch (Exception $e) {
						// Ignore
					}
				}
			}
			
			// No properties? -> try to retrieve only public properties
			if ( count( $properties ) < 1 ) {
				$properties = get_object_vars( $obj );
				foreach ( $properties as $attributeName => $v ) {
					if ( array_key_exists( $attributeName, $map ) ) { 
						try {
							$obj->{ $attributeName } = $map[ $attributeName ];
						} catch (Exception $e) {
							// Ignore
						}
					}
				}
			}			
			
			$currentClass = $currentClass->getParentClass();
		}
	}

	/**
	 * Set the attribute values of a object.
	 * This method has been kept for backward compatibility.
	 * 
	 * @param array		$map				A map with the attribute names and values to be changed.
	 *
	 * @param object	$obj				The object to be changed.
	 *
	 * @param string	$setterPrefix		The prefix for setter public methods (defaults to 'set').
	 *
	 * @param bool		$useCamelCase		If true, private and protected attributes will be set by
	 *										camelCase public methods (default true).
	 */	
	static function setPrivateAttributes(
		array $map, &$obj, $setterPrefix = 'set', $useCamelCase = true
		) {
		self::setAttributes( $map, $obj, RTTI::IS_PRIVATE, $setterPrefix, $useCamelCase );
	}

	
}

?>