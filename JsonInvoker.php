<?php

require_once 'Response.php';
require_once 'JSON.php';
require_once 'datatables/DataTablesResponse.php';

/**
 * Invokes methods and return the response (if present) in JSON format.
 *
 * @author	Thiago Delgado Pinto
 *
 * @version	1.1
 *
 *
 * How to use it:
 *
 *	class MyClass { // Example class
 *		private $id;
 *
 *	 	function __construct( $id = 0 ) {
 *			$this->id = $id;
 *		}
 *		function sayHelloTo( $name ) {
 *			return 'Hello, ' . $name;
 *		}
 *
 *		function objectWithName( $name ) {
 *			$obj = new StdClass();
 *			$obj->id = $this->id;
 *			$obj->name = $name;
 *			return $obj;
 *		} 
 *  }
 *
 *  $jsonString = JsonInvoker::invoke( 'MyClass', array(), 'sayHelloTo', array( 'Bob' ), JsonInvoker::RAW_FORMAT );
 *	echo $jsonString; // Hello, Bob
 *
 *  $jsonString = JsonInvoker::invoke( 'MyClass', array( 500 ), 'objectWithName', array( 'Bob' ), JsonInvoker::RAW_FORMAT ); 
 *  echo $jsonString; // { "id": 500, "name" : "Bob" }
 *  
 *  Notes:
 *  	- IT IS RECOMMEND TO USE die() INSTEAD OF USING echo() WHEN ANSWERING TO A CLIENT.
 *
 */
class JsonInvoker {

	//
	// Return formats
	//
	const RAW_FORMAT		= 'raw';	// The return content is not wrapped.
	const RESPONSE_FORMAT	= 'res';	// The return content is wrapped with a {@link Response} object.
	const DATATABLES_FORMAT	= 'dt';		// The return content is wrapped with a {@link DataTablesResponse} object.

	const DEFAULT_FORMAT	= self::RESPONSE_FORMAT;
	
	//
	// Options
	//
	
	/** When {@code true}, makes {@code Response.extra} to hold the exception message. */
	private static $debugMode = false;
	
	/** When {@code true}, uses an additional JSON::encode in "message" for RESPONSE_FORMAT and DATATABLES_FORMAT. */
	private static $doubleEncodeMessage = false;
	
	/** Use Gzip to compress the returning content. */ 
	private static $compress = false;
	
	/** Function used to create objects. It can be replaced, for instance, with another
	 *  method that calls a framework to create objects (e.g. Dice). */
	private static $creationFunction = null; // callable
	
	//
	// Getters/setters for Options
	//
	
	static function getDebugMode() { return self::$debugMode; }
	static function setDebugMode( $debugMode ) { self::$debugMode = $debugMode; }
	
	static function getDoubleEncodeMessage() { return self::$doubleEncodeMessage; }
	static function setDoubleEncodeMessage( $doubleEncodeMessage ) { self::$doubleEncodeMessage = $doubleEncodeMessage; }	
	
	static function getCompress() { return self::$compress; }
	static function setCompress( $compress ) { self::$compress = $compress; }
	
	static function getCreationFunction() { return self::$creationFunction; }
	static function setCreationFunction( $creationFunction ) { self::$creationFunction = $creationFunction; }
	
	//
	// Behaviour
	//

	/**
	 * Invoke a method and return a HTTP response with JSON content.
	 *
	 * @param string	$className			the class to be created.
	 * @param array		$constructorArgs	constructor arguments.
	 * @param string	$methodName	 		the method to be called.
	 * @param array		$methodArgs			method arguments.	 
	 * @param string	$jsonReturnFormat	the return format ('raw', 'res', or 'dt').
	 *
	 * @return string	a string in JSON format.
	 */
	static function invoke(
			$className,
			array $constructorArgs,
			$methodName,
			array $methodArgs,
			$jsonReturnFormat = null
			) {

		$returnFormat = isset( $jsonReturnFormat ) ? $jsonReturnFormat : self::DEFAULT_FORMAT;

		if ( ! class_exists( $className, true ) ) {
			$msg = "Class '${className}' not found.";
			return self::jsonContent( true, $msg, null, $returnFormat );
		}
		// Calls the defined method, get its result and send to the client
		try {
			// Create the instance
			$obj = self::createObject( $className, $constructorArgs );

			// Verifies if the method exists in the class instance
			if ( ! method_exists( $obj, $methodName ) ) {
				$msg = "Method '${methodName}' not found in class '${className}'.";
				return self::jsonContent( true, $msg, null, $returnFormat );
			}

			$data = call_user_func_array( array( $obj, $methodName ), $methodArgs );
			$extra = is_array( $data ) ? count( $data ) : null;
			return self::jsonContent( true, null, $data, $returnFormat, $extra );
			
		} catch (Exception $e) {
			$extra = self::$debugMode === true ? $e->getTraceAsString() : null;
			// Send the exception class as the "data" and, if in debug mode, the trace as "extra"
			return self::jsonContent( false, $e->getMessage(), get_class( $e ), $returnFormat, $extra );
		}
	}
	
	/**
	 *  Return a class instance using the defined function or PHP's reflection class.
	 *  
	 *  @return object
	 */
	static function createObject( $className, array $constructorArgs = array() ) {
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

	/**
	 *  Returns a HTTP response with JSON content, according to the formatting options.
	 *  
	 *  @return string
	 */
	static function jsonContent( $success, $msg, $data, $returnFormat, $extra = null ) {
		return JSON::encode( self::contentFor( $success, $msg, $data, $returnFormat, $extra ) );
	}
	
	/**
	 *  Creates the appropriated content, according to the formatting options.
	 *  
	 *  @return object
	 */
	static function contentFor( $success, $msg, $data, $returnFormat, $extra = null ) {
		$content = $data;
		$message = self::$doubleEncodeMessage === true ? JSON::encode( $msg ) : $msg;
		if ( self::RESPONSE_FORMAT === $returnFormat ) {
			$content = new Response( $success, $message, $data, $extra );
		} else if ( self::DATATABLES_FORMAT === $returnFormat ) {
			$count = isset( $data ) ? ( is_array( $data ) ? count( $data ) : 1 ) : 0;
			$draw = 1;
			$content = new DataTablesResponse( $count, $count, $data, $draw, $message );
		}
		return $content;
	}
}

?>