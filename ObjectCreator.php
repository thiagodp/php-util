<?php

/**
 * Dynamic object creator
 *
 * @author	Thiago Delgado Pinto
 * @version 0.9.2
 */
class ObjectCreator {

	/**
	 * Create an object from an array. The object will use array's keys as
	 * public attributes.
	 *
	 * WARNING: The generated object will replace sub arrays converting them
	 *			to objects. If you do not want this behaviour, just cast an
	 * 			array to an	object like this:
     *
	 *			$obj = (object) $yourArray;
	 *
	 *
	 * @param array	the array map containing the keys and values.
	 * @param 		the class name to create on demand (optional).
	 * @return		a object.
	 */
	static function fromArray(
		array $array,
		$className = 'stdClass'
		) {
		$class = self::classDeclaration( $array, $className );
		eval( $class );
		return new $className;
	}
	
	/**
	 * Create a class declaration from the given array and class name.
	 *
	 * @param array	the array map containing the keys and values.
	 * @param 		the class name.
	 * @return		string.	 
	 */
	static function classDeclaration( array $array, $className ) {

		function serializeValue( $value ) {
			$type = gettype( $value );
		
			if ( 'string' == $type ) { return '"' . $value . '"'; }
			if ( 'integer' == $type || 'double' == $type  ) { return $value; }
			if ( 'boolean' == $type  ) { return $value ? 'true' : 'false'; }
			if ( 'array' == $type && ((array) $value) === $value ) {
				$str = '';
				foreach ( $value as $k => $v ) {
					$str .= ( '' == $str ) ? 'array( ' : ', ';
					if ( is_numeric( $k ) ) {
						$str .= " '$k' => " . serializeValue( $v );				
					} else {
						$str .= " $k => " . serializeValue( $v );
					}
				}
				$str .= ' )';
				return $str;
			}
			return '';
		}

		function attr( $value ) {
			return ' = ' . serializeValue( $value );
		}

		$class = "class $className { \n";
		foreach ( $array as $key => $value ) {
			if ( is_numeric( $key ) ) {
				$class .= "public \$unknown${key}" . attr( $value ) . ";\n";
			} else {
				$class .= "public \$$key" . attr( $value ) . ";\n";
			}
		}
		$class .= "\n}";
		
		return $class;
	}
}

?>