<?php

/**
 * DataTables request parameters.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 * @see		https://datatables.net/manual/server-side#Sent-parameters 
 */
class DataTablesRequest {

	const KEY_DRAW					= 'draw';
	// Limit, Offset
	const KEY_LIMIT					= 'length';
	const KEY_OFFSET				= 'start';
	// Search
	const KEY_SEARCH				= 'search';
	const KEY_SEARCH_VALUE			= 'value';
	// Filter
	const KEY_COLUMNS				= 'columns';
	const KEY_COLUMN_NAME			= 'data';
	const KEY_COLUMN_SEARCH			= 'search';
	const KEY_COLUMN_SEARCH_VALUE	= 'value';
	// Order
	const KEY_ORDER					= 'order';
	const KEY_ORDER_COLUMN_INDEX	= 'column';
	const KEY_ORDER_DIRECTION		= 'dir';

	
	private $request; // Holds a reference to the request array
	

	/**
	 * @param array $requestArray	the reference to the request array.
	 */
	function __construct( array &$requestArray ) {
		$this->request = &$requestArray;
	}

	//
	// REQUEST CHECKING
	//

	/** @return bool */
	function hasDraw() {
		return isset( $this->request[ self::KEY_DRAW ] );
	}
	
	/** @return bool */
	function hasLimit() {
		return isset( $this->request[ self::KEY_LIMIT ] );
	}	
	
	/** @return bool */
	function hasOffset() {
		return isset( $this->request[ self::KEY_OFFSET ] );
	}

	/** @return bool */
	function hasSearch() {
		return isset( $this->request[ self::KEY_SEARCH ], $this->request[ self::KEY_SEARCH ][ self::KEY_SEARCH_VALUE ] );
	}
	
	
	//
	// VALUES
	//
	
	/** @return int */
	function draw() {
		return $this->naturalNumberFromKey( self::KEY_DRAW );
	}

	/** @return int */
	function limit() {
		return $this->naturalNumberFromKey( self::KEY_LIMIT );
	}
	
	/** @return int */
	function offset() {
		return $this->naturalNumberFromKey( self::KEY_OFFSET );
	}
	
	/** @return string or null */
	function search() {
		return $this->hasSearch() ? $this->request[ self::KEY_SEARCH ][ self::KEY_SEARCH_VALUE ] : null;
	}
	
	/**
	 * Return the filters as a map with the field names and its corresponding values.
	 * @return	array			
	 */
	function filters() {
		if ( ! isset( $this->request[ self::KEY_COLUMNS ] ) ) { return array(); }
		$filters = array();
		$columns = $this->request[ self::KEY_COLUMNS ];
		
		foreach ( $columns as $col ) {
	
			if ( ! isset(	$col[ self::KEY_COLUMN_NAME ],
							$col[ self::KEY_COLUMN_SEARCH ],
							$col[ self::KEY_COLUMN_SEARCH ][ self::KEY_COLUMN_SEARCH_VALUE ] ) )	{
				continue;
			}
			
			$name = $col[ self::KEY_COLUMN_NAME ];
			$search = $col[ self::KEY_COLUMN_SEARCH ][ self::KEY_COLUMN_SEARCH_VALUE ];
			
			$filters[ $name ] = $search;
		}
		return $filters;
	}
	
	/**
	 * Return the orders from a request array.
	 *
	 * @param	array $fieldNames	an aray containing the field names.
	 * @return	array				a map with the field names and its corresponding order directions (ASC or DESC).
	 */
	function orders( array $fieldNames ) {
		if ( ! isset( $this->request[ self::KEY_ORDER ] ) ) { return array(); }
		$orders = array();
		$columns = $this->request[ self::KEY_ORDER ];
		foreach ( $columns as $value ) {
				if ( ! isset( $value[ self::KEY_ORDER_COLUMN_INDEX ], $value[ self::KEY_ORDER_DIRECTION ] ) ) { continue; }
				$index = $value[ self::KEY_ORDER_COLUMN_INDEX ];
				$orders[ $fieldNames[ $index ] ] = $value[ self::KEY_ORDER_DIRECTION ];
		}
		return $orders;
	}
	
	
	
	/** @return int */	
	private function naturalNumberFromKey( $key ) {
		if ( ! isset( $this->request[ $key ] ) ) {
			return 0;
		}
		$value = intval( $this->request[ $key ] );
		return ( $value < 0 ) ? 0 : $value;
	}
	
}

?>