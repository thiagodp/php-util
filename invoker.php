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
 * METHOD_PARAMETER constants and to send the returning content back to the client machine,
 * using the JSON format. By default, the returned content is wrapped inside a Response object
 * (@see Response.php). We recommend to do so, because it turn it simpler and standardised the
 * way the client deal with responses from the server. However, if you do not want to wrap the
 * returned content, you can pass the RAW_PARAMETER argument (with an empty value).
 * <p>
 *
 * Whether the given class exists, the given method exists, and the given method works
 * as expected (without throwing an exception), the Response object will be instantiated like
 * this:
 * <code>
 * new Response( true, '', $data );
 * </code>
 * where <code>$data</code> is the return  value of the given method.
 *
 * Otherwise, the Response object will be instantiated like this:
 * <code>
 * new Response( false, $errorMessage, $exceptionClassName );
 * </code>
 * where <code>$errorMessage</code> is the error message or the exception message, and
 * <code>$exceptionClassName</code> is the the name of the exception class, or null,
 * if a exception was not thrown.
 *
 * </p>
 * <p>
 * How to use it:
 * <code>
 *   ...
 *	   <body>
 *     <!-- Using JQuery, but it is not necessary to use invoker.php -->
 * 	   <script type='text/javascript' charset='UTF-8' src='jquery.js' ></script>
 *
 *	   <script type='text/javascript' charset='UTF-8' >
 *     //
 *     // EXAMPLE 1
 *     // The client will send a POST request to invoker.php, passing the
 *     // expect arguments to it: "_c" and "_m". The server will instantiate
 *     // the given class (MyClass) and call the given method (myMethod). Then,
 *     // it will create a Response (PHP) object, put method's return value into
 *     // the "data" attribute, and return the object as JSON.
 *     //
 *     var data = { _c : 'MyClass', _m : 'myMethod' };
 *     var postResponseFn = function( response ) {
 *       console.log( response ); // Expect to show a Response object
 *     };
 *     $.post( 'php-util/invoker.php', data, postResponseFn, 'json' );
 *
 *     //
 *     // EXAMPLE 2 
 *     // We are configuring a "Save" button to send data from a form (myForm)
 *     // using a POST request to invoker.php. The request is passing the
 *     // expected arguments, "_c" and "_m", plus the form data.
 *     // The server will instantiate the given class (AnotherClass) and call the
 *     // given method (myMethod). Then, it will create a Response (PHP) object,
 *     // put method's return value into the "data" attribute, and return the
 *     // object as JSON. The client will receive the object and show an alert
 *     // message.
 *     // 
 *     var formSaveButtonClickFn = function() {
 *       var formData = $( '#myForm' ).serializeArray();
 *       formData[ formData.length ] = { name: '_c', value: 'AnotherClass' };
 *       formData[ formData.length ] = { name: '_m', value: 'anotherMethod' }; 
 *       var formResponseFn = function( response ) {
 *         alert( response.success ? 'Saved.' : response.message );
 *		 };
 *		 $.post( 'php-util/invoker.php', formData, formResponseFn, 'json' );
 *	   }; // function
 *
 *     $( '#saveButton' ).click( formSaveButtonClickFn );		
 *     </script>
 *   </body> 
 *   ...
 * </code>
 * </p>
 *
 * @author	Thiago Delgado Pinto
 * @version	1.2
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

function _error( $msg, $data = null ) {	
	die( JSON::encode( new Response( false, $msg, $data ) ) );
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
	_error( $e->getMessage(), get_class( $e ) ); // Send the exception class as the "data"
}
?>