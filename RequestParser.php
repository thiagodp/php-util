<?php

require_once 'Request.php';

/**
 * Request parser
 *
 * @author	Thiago Delgado Pinto
 */
class RequestParser {

	/** Return a new {@link Request} object with the request content. */
	static function createObject() {
		return new Request(
			self::method(),
			self::contentType(),
			self::uri(),
			self::parameters()
			);
	}
	
	/** Return request's URI. */
	static function uri() {
		return self::val( $_SERVER, 'REQUEST_URI' );
	}
	
	/** Return request's path info. */
	static function pathInfo() {
		return self::val( $_SERVER, 'PATH_INFO' );
	}

	/** Return request's HTTP method. */
	static function method() {
		return self::val( $_SERVER, 'REQUEST_METHOD' );
	}
	
	/** Return request's content type. */
	static function contentType() {
		// 1st try: It is necessary to config .htaccess for getting CONTENT_TYPE
		$value = self::val( $_SERVER, 'CONTENT_TYPE' );
		
		// 2nd try: Getting all headers
		if ( ! isset( $value ) ) {
			$accept = self::val( getallheaders(), 'Accept' );
			if ( isset( $accept ) ) {
				$content = explode( ',', $accept );
				if ( count( $content ) > 0 ) {
					$value = $content[ 0 ];
				}
			}
		}
		
		return $value;
	}
	
	/** Return request's query string. */
	static function queryString() {
		return self::val( $_SERVER, 'QUERY_STRING' );
	}
	
	/** Return request's query array */
	static function queryArray() {
		if ( isset( $_SERVER[ 'QUERY_STRING' ] ) ) {
			$params = array();
			parse_str( $_SERVER[ 'QUERY_STRING' ], $params );
			return $params;
		}
		return null;
	}
	
	/** Return an array with the request parameters */
	static function parameters() {
		$params = self::queryArray();
		if ( ! isset( $params ) ) { $params = array(); }
		
		// PUT/POST incoming stream
		$content = file_get_contents( 'php://input' );
		$fields = array();
		switch ( self::contentType() ) {
			case Request::CONTENT_HTML: $fields = json_decode( $content ); break;
			case Request::CONTENT_JSON: parse_str( $content, $fields ); break;
			default: return $params;
		}
		// Add content from $fields to $params
		foreach ( $fields as $key => $value ) {
			$params[ $key ] = $value;
		}
		return $params;
	}
	
	/** Return a timestamp of the start of the request */
	static function time() {
		return self::val( $_SERVER, 'REQUEST_TIME' );
	}
	
	/** Return a timestamp of the start of the request, with microsecond precision */
	static function timeFloat() {
		return self::val( $_SERVER, 'REQUEST_TIME_FLOAT' );
	}
	
	/** Return the value for the given array key or {@code null} if not found. */
	private static function val( array $array, $key ) {
		return isset( $array[ $key ] ) ? $array[ $key ] : null;
	}
}

?>