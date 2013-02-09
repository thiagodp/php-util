<?php
/* THIS FILE IS DISTRIBUTED UNDER THE CREATIVE COMMONS LICENCE (CC BY 3.0)
 * http://creativecommons.org/licenses/by/3.0/
 * 
 * USE IT AT YOUR OWN RISK!
 */

/**
 * Run time type information utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
class RTTI {

	/**
	 * Get private attribute names and their values (by calling the public methods started
	 * with <code>$getterPrefix</code>).  
	 * 
	 * @param unknown_type $obj
	 * 		Object of any class 
	 * @param string $getterPrefix
	 * 		The prefix for getter methods (default is 'get').
	 * @return array of attributes
	 */
	static function getPrivateAttributes( $obj, $getterPrefix = 'get' ) {
		$attributes = array();
		$reflecionObject = new ReflectionObject( $obj );
		foreach ( $reflecionObject->getProperties( ReflectionProperty::IS_PRIVATE ) as $property ) {
			$attributes[ $property->getName() ] = $reflecionObject->getMethod(
					$getterPrefix . ucfirst( $property->getName() ) )->invoke( $obj );
		}
		return $attributes;
	}

}

?>