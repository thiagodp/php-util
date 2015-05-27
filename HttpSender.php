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
 * @version	1.0
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
	 * Send a HTTP OPTIONS request. This a convenience method for #send().
	 *
	 * @see #send().
	 */	
	function options( $url, array $content, $contentType='application/x-www-form-urlencoded', $encodeURL = false ) {		
		return $this->send( 'OPTIONS', $url, $content, $contentType, $encodeURL );
	}
	
	/**
	 * Send a HTTP request.
	 *
	 * @param url		the target url
	 * @param content	the array with the content to send. Example: array( 'name' => 'Bob' )
	 * @contentType		the content type
	 * @encodeURL		true for encoding the supplied url, false otherwise.
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
		$context = stream_context_create( $options );
		$targetURL = $encodeURL ? urlencode( $url ) : $url;
		return file_get_contents( $targetURL , false, $context );
	}
	
}
?>