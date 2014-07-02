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
 * @version 0.1
 * @author Thiago Delgado Pinto
 */
class DataTablesFormat {
	
	private $iTotalRecords = 0;
	private $iTotalDisplayRecords = 0;
	private $aaData = array();
	
	function __construct( $maxRows, $rowsToDisplay, $data ) {
		$this->iTotalRecords = $maxRows;
		$this->iTotalDisplayRecords = $rowsToDisplay;
		$this->aaData = $data;
	}
	
	function getITotalRecords() { return $this->iTotalRecords; }
	function getITotalDisplayRecords() { return $this->iTotalDisplayRecords; }
	function getAaData() { return $this->aaData; }
}

?>