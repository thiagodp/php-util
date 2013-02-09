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
 * 			<script type='text/javascript' src='jquery.js' ></script>
 *			<script type='text/javascript' >
 *				var data = { _c : 'SomeClass', _m : 'someMethod' };
 *				var showResponse = function( response ) {
 *					alert( 'Success: ' + response.success
 *						+ ' Message: ' + response.message
 *						+ ' Data: ' + ( response.data ? response.data : '' )
 *						);
 * 					}
 *				$.post( 'router.php', data, showResponse, 'json' );
 *			</script>
 *		</body> 
 * 		</html>
 * </code>
 * This will make router.php to create a SomeClass instance and call its someMethod method.<br />
 * The method return will be send back to the client (as JSON) in the "data" field.
 * </p>
 * <h2>HOW TO USE IT</h2>
 * <p>
 *		Put this file at your (root) source folder. Call it from your HTML passing the expected
 *		REQUEST parameters (currently _c and _m).
 * </p>
 *
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 *
 * @see		{@link JSON}, {@link Response}
 *
 */

require_once( 'autoload.php' );	// Uses __autoload

define( 'CLASS_PARAMETER', '_c' );
define( 'METHOD_PARAMETER', '_m' );

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
$className = htmlentities( $targetArray[ CLASS_PARAMETER ] );
$methodName = htmlentities( $targetArray[ METHOD_PARAMETER ] );
// Uses the __autoload to search for the class file and include it
if ( ! class_exists( $className, true ) ) {
	_error( "Class '${className}' not found." );
}
// Verifies if the method exists in the class instance
$obj = new $className;
if ( ! method_exists( $obj, $methodName ) ) {
	_error( "Method '${methodName}' not found in class '${className}'." );
}
// Calls the defined method, get its result and send to the client
try {
	$data = call_user_func( array( $obj, $methodName ) );
	die( JSON::encode( new Response( true, '', $data ) ) );
} catch (Exception $e) {
	_error( $e->getMessage() );
}
?>