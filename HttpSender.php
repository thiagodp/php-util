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
 * A simple CURL-less http sender.
 *
 * @author	Thiago Delgado Pinto
 * @version	0.9
 */
class HttpSender {

	/**
	 * Send a POST request.
	 *
	 * @param url		the target url
	 * @param content	the array with the content to send. Example: array( 'name' => 'Bob' )
	 * @contentType		the content type. OPTIONAL, default 'application/x-www-form-urlencoded'.
	 * @encodeURL		true for encoding the supplied url, false otherwise. OPTIONAL, default false.
	 * @return			a string with the returning content or false in case of failure.
	 */
	function post( $url, array $content, $contentType='application/x-www-form-urlencoded',
		$encodeURL = false
		) {
		return $this->send( 'POST', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a GET request.
	 *
	 * @param url		the target url
	 * @param content	the array with the content to send. Example: array( 'name' => 'Bob' )
	 * @contentType		the content type. OPTIONAL, default 'application/x-www-form-urlencoded'.
	 * @encodeURL		true for encoding the supplied url, false otherwise. OPTIONAL, default false.
	 * @return			a string with the returning content or false in case of failure.
	 */
	function get( $url, array $content, $contentType='application/x-www-form-urlencoded',
		$encodeURL = false
		) {		
		return $this->send( 'GET', $url, $content, $contentType, $encodeURL );
	}	
	
	/**
	 * Send a request.
	 *
	 * @param url		the target url
	 * @param content	the array with the content to send. Example: array( 'name' => 'Bob' )
	 * @contentType		the content type
	 * @encodeURL		true for encoding the supplied url, false otherwise.
	 * @return			a string with the returning content or false in case of failure.
	 */
	function send( $method, $url, array $content, $contentType, $encodeURL ) {
		$options = array(
			'http' => array( // also works for https
				'header'  => 'Content-type: '. $contentType,
				'method'  => $method,
				'content' => http_build_query( $content )
			),
		);
		$context = stream_context_create( $options );
		$targetURL = ( $encodeURL ) ? urlencode( $url ) : $url;
		return file_get_contents( $targetURL , false, $context );
	}
	
}
?>