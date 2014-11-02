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
 * Receiving format expected by jQuery.DataTables.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 * @see		https://datatables.net/manual/server-side#Returned-data
 */
class DataTablesResponse {
	
	private $draw = 0;				// Asynchronous sequence call
	private $recordsTotal = 0;		// Total records
	private $recordsFiltered = 0;	// Total filtered records
	private $data = array();		// Data
	private $error = null;			// Error message (if occurred)
	
	function __construct( $recordsTotal, $recordsFiltered, $data, $draw = 0, $error = null ) {
		$this->recordsTotal = $recordsTotal;
		$this->recordsFiltered = $recordsFiltered;
		$this->data = $data;
		$this->draw = $draw;
		$this->error = $error;
	}
	
	function getRecordsTotal() { return $this->recordsTotal; }
	function getRecordsFiltered() { return $this->recordsFiltered; }
	function getData() { return $this->data; }
	function getDraw() { return $this->draw; }
	function getError() { return $this->error; }
}

?>