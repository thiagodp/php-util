<?php

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