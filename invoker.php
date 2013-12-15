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
 * This file allows to automatically call a class method defined by the CLASS_PARAMETER and the
 * METHOD_PARAMETER and sends back to the client its return, in JSON format, using the Response
 * class structure.
 *
 * <h2>EXAMPLE</h2>
 * <p>
 * <code>
 *		<html>
 *		<body>
 * 			<script type='text/javascript' charset='UTF-8' src='jquery.js' ></script>
 *			<script type='text/javascript' charset='UTF-8' >
 *				// Example 1
 *				var data = { _c : 'SomeClass', _m : 'someMethod' };
 *				var responseFn = function( response ) {
 *					console.log( response ); // See Response.php
 * 				};
 *				$.post( 'invoker.php', data, responseFn, 'json' );
 *
 *				// Example 2 
 *				$( '#saveButton' ).click( function() {
 *					var formData = $( '#aForm' ).serializeArray();
 *					formData[ formData.length ] = { name: '_c', value: 'AnotherClass' };
 *					formData[ formData.length ] = { name: '_m', value: 'anotherMethod' }; 
 *					var formResponseFn = function( response ) {
 *						alert( response.success ? 'Saved.' : response.message );
 *					};
 *					$.post( 'invoker.php', formData, formResponseFn, 'json' );
 *				}; // click
 *				
 *			</script>
 *		</body> 
 * 		</html>
 * </code>
 * This will make invoker.php to create a SomeClass instance and call its someMethod method.<br />
 * The method return will be send back to the client (as JSON) in the "data" field.
 * </p>
 * <h2>HOW TO USE IT</h2>
 * <p>
 * Call it from your HTML file passing the expected REQUEST parameters (currently _c and _m).
 * </p>
 *
 *
 * @author	Thiago Delgado Pinto
 * @version	1.1.3
 *
 * @see		{@link JSON}, {@link Response}
 *
 */
require_once( 'autoload.php' );

mb_internal_encoding( 'UTF-8' );
header( 'Content-type: text/json; charset=UTF-8' );

define( 'CLASS_PARAMETER', '_c' );
define( 'METHOD_PARAMETER', '_m' );
define( 'RAW_PARAMETER', '_raw' );

function _error( $msg ) {	
	die( JSON::encode( new Response( false, $msg ) ) );
}

$targetArray = $_REQUEST;
// Verifies the expected parameters
$params = array( CLASS_PARAMETER, METHOD_PARAMETER );
foreach ( $params as $p ) {
	if ( ! isset( $targetArray[ "$p" ] ) ) {
		_error( "Parameter '$p' not sent." );
	}
}
$className = htmlentities( $targetArray[ CLASS_PARAMETER ], ENT_QUOTES, 'UTF-8' );
$methodName = htmlentities( $targetArray[ METHOD_PARAMETER ], ENT_QUOTES, 'UTF-8' );
// Uses the __autoload to search for the class file and include it
if ( ! class_exists( $className, true ) ) {
	_error( "Class '${className}' not found." );
}
// Calls the defined method, get its result and send to the client
try {
	// Verifies if the method exists in the class instance
	$obj = new $className;
	if ( ! method_exists( $obj, $methodName ) ) {
		_error( "Method '${methodName}' not found in class '${className}'." );
	}
	$data = call_user_func( array( $obj, $methodName ) );
	if ( isset( $_REQUEST[ RAW_PARAMETER ] ) ) {
		die( JSON::encode( $data ) );
	} else {
		die( JSON::encode( new Response( true, '', $data ) ) );
	}
} catch (Exception $e) {
	_error( $e->getMessage() );
}
?>