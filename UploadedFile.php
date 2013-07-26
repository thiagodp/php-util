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
 * Information about an uploaded file.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
class UploadedFile {

	private $name;
	private $type;
	private $size;
	private $tmpName;
	private $error;
	
	function __construct( $name, $type, $size, $tmpName, $error ) {
		$this->name = $name;
		$this->type = $type;
		$this->size = $size;
		$this->tmpName = $tmpName;
		$this->error = $error;
	}
	
	function getName() { return $this->name; }
	function getType() { return $this->type; }
	function getSize() { return $this->size; }
	function getTmpName() { return $this->tmpName; }
	function getError() { return $this->error; }
}

?>