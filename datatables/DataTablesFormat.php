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
 * Representa o formato esperado pelo plugin jQuery.DataTables.
 * 
 * @see http://datatables.net/
 *
 * @version 0.2
 * @author Thiago Delgado Pinto
 */
class DataTablesFormat {
	
	private $recordsTotal = 0;
	private $recordsFiltered = 0;
	private $data = array();
	
	function __construct( $recordsTotal, $recordsFiltered, $data ) {
		$this->recordsTotal = $recordsTotal;
		$this->recordsFiltered = $recordsFiltered;
		$this->data = $data;
	}
	
	function getRecordsTotal() { return $this->recordsTotal; }
	function getRecordsFiltered() { return $this->recordsFiltered; }
	function getData() { return $this->data; }
}

?>