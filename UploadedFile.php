<?php

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