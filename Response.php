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
 * Default format for responses to the client. Good to be converted in JSON format.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0 
 */
class Response {

	private $success;	// Tells if everything is right.
	private $message;	// Message in case of success or error.
	private $data;		// Data to be sent in response.

	function __construct( $success = true, $message = '', $data = null ) {
		$this->success = $success;
		$this->message = $message;
		$this->data = $data;
	}
	
	function getSuccess() { return $this->success; }	
	function getMessage() {	return $this->message; }	
	function getData() { return $this->data; }	
}

?>