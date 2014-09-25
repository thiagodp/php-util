<?php

/**
 * Request
 *
 * @author	Thiago Delgado Pinto
 */
class Request {

	const METHOD_HEAD	= 'HEAD';
	const METHOD_GET	= 'GET';
	const METHOD_POST	= 'POST';
	const METHOD_PUT	= 'PUT';	
	const METHOD_DELETE	= 'DELETE';	
	
	const CONTENT_HTML	= 'application/x-www-form-urlencoded';	
	const CONTENT_JSON	= 'application/json';
	
	private $method;
	private $contentType;
	private $url;
	private $parameters;
	
	function __construct( $method = '', $contentType = '', $url = '', $parameters = array() ) {
		$this->method = $method;
		$this->contentType = $contentType;
		$this->url = $url;
		$this->parameters = $parameters;
	}
	
	function getMethod() { return $this->method; }
	function getContentType() { return $this->contentType; }
	function getUrl() { return $this->url; }
	function getParameters() { return $this->parameters; }
	
	//
	// Method
	//
	
	/** Return {@code true} whether the request method is HEAD. */
	static function methodIsHEAD() { return self::METHOD_HEAD == $this->method; }
	
	/** Return {@code true} whether the request method is GET. */
	static function methodIsGET() { return self::METHOD_GET == $this->method; }
	
	/** Return {@code true} whether the request method is POST. */
	static function methodIsPOST() { return self::METHOD_POST === $this->method; }
	
	/** Return {@code true} whether the request method is PUT. */
	static function methodIsPUT() { return self::METHOD_PUT === $this->method; }
	
	/** Return {@code true} whether the request method is DELETE. */
	static function methodIsDELETE() { return self::METHOD_DELETE === $this->method; }
	
	//
	// Content type
	//
	
	/** Return {@code true} whether the request content is HTML. */
	static function contentIsHTML() { return self::CONTENT_HTML === $this->contentType; }
	
	/** Return {@code true} whether the request content is JSON. */
	static function contentIsJSON() { return self::CONTENT_JSON === $this->contentType; }
}

?>