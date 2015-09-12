<?php

/**
 * Invokes a method and return its response.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
class MethodInvoker {
	
	/// Function or method used for creating objects. Use it whether you wish
	/// using dependency injection frameworks.
	private static $creationFunction = null; // callable
		
	static function getCreationFunction() { return self::$creationFunction; }
	static function setCreationFunction( $creationFunction ) { self::$creationFunction = $creationFunction; }
	
	/**
	 * Invoke a method and return its returned data.
	 *
	 * @param string	$className			the class to be created.
	 * @param string	$methodName	 		the method to be called.	 
	 * @param array		$constructorArgs	constructor arguments.
	 * @param array		$methodArgs			method arguments.
	 *
	 * @return mixed	the data returned by the method.
	 *
	 * @throws InvalidArgumentException or any exception thrown by the called method.
	 */
	function invoke(
		$className,
		$methodName,
		array $constructorArgs = array(),
		array $methodArgs = array()
		) {
		
		if ( ! class_exists( $className, true ) ) {
			throw new InvalidArgumentException( "Class '${className}' not found." );
		}
		$obj = $this->createObject( $className, $constructorArgs );
		if ( ! method_exists( $obj, $methodName ) ) {
			throw new InvalidArgumentException( "Method '${methodName}' not found in class '${className}'." );
		}
		return call_user_func_array( array( $obj, $methodName ), $methodArgs );
	}
	
	/**
	 *  Return a class instance using the defined function or PHP's reflection class.
	 *  
	 *  @return object
	 */
	function createObject( $className, array $constructorArgs = array() ) {
		$instance = null;
		if ( isset( self::$creationFunction ) ) {
			$args = $constructorArgs;
			array_unshift( $args, $className );
			$instance = call_user_func_array( self::$creationFunction, $args );
		} else {
			$class = new ReflectionClass( $className );
			$instance = $class->newInstanceArgs( $constructorArgs );
		}
		return $instance;
	}

}

?>