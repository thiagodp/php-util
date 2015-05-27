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
 * @version	1.1
 */
class HttpSender {

	/**
	 * Send a HTTP POST request. This a convenience method for #send().
	 *
	 * @see #send().
	 */
	function post( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {
		return $this->send( 'POST', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a HTTP GET request. This a convenience method for #send().
	 *
	 * @see #send().
	 */
	function get( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'GET', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a HTTP PUT request. This a convenience method for #send().
	 *
	 * @see #send().
	 */	
	function put( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'PUT', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a HTTP DELETE request. This a convenience method for #send().
	 *
	 * @see #send().
	 */	
	function delete( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'DELETE', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a HTTP PATCH request. This a convenience method for #send().
	 *
	 * @see #send().
	 */	
	function patch( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'PATCH', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a HTTP HEAD request. This a convenience method for #send().
	 *
	 * @see #send().
	 */	
	function head( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'HEAD', $url, $content, $contentType, $encodeURL );
	}	

	/**
	 * Send a HTTP OPTIONS request. This a convenience method for #send().
	 *
	 * @see #send().
	 */	
	function options( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'OPTIONS', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a simple HTTP request.
	 *
	 * @param string	method		the HTTP method to use.
	 * @param string	url			the url.
	 * @param array		content		the array with the content to send.
	 *								Example: array( '{ "name": "Bob" }' ).
	 * @param string	contentType	the content type.
	 *								Example: 'application/json'.
	 * @param bool		encodeURL	true for encoding the supplied url, false otherwise.
	 *
	 * @return			a string with the returning content or false in case of failure.
	 */
	function send( $method, $url, array $content, $contentType, $encodeURL ) {
		$options = array(
			'http' => array( // also works with https
				'header'  => 'Content-type: '. $contentType,
				'method'  => $method,
				'content' => http_build_query( $content )
			),
		);		
		return $this->request( $options, $url, $encodeURL );
	}
	
	/**
	 * Send a request to a resource.
	 *
	 * @param array 	options		specify the header for the request.
	 * @param string	url			the url.
	 * @param bool		encodeURL	true for encoding the supplied url, false otherwise.
	 *
	 * @return			a string with the returning content or false in case of failure.
	 */
	function request( array $options, $url, $encodeURL ) {
		$context = stream_context_create( $options );
		$targetURL = $encodeURL ? urlencode( $url ) : $url;
		return file_get_contents( $targetURL , false, $context );
	}
	
}
?>