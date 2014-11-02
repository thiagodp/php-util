<?php

/**
 * Some of DataTables request parameters.
 *
 * @author	Thiago Delgado Pinto
 * @version	0.9
 * @see		https://datatables.net/manual/server-side#Sent-parameters 
 */
class DataTablesRequest {

	const KEY_DRAW		= 'draw';
	const KEY_LIMIT		= 'length';
	const KEY_OFFSET	= 'start';
	const KEY_SEARCH	= 'search';

	//
	// REQUEST CHECKING
	//

	/** @return bool */
	static function hasDraw() {
		return isset( $_REQUEST[ self::KEY_DRAW ] );
	}
	
	/** @return bool */
	static function hasLimit() {
		return isset( $_REQUEST[ self::KEY_LIMIT ] );
	}	
	
	/** @return bool */
	static function hasOffset() {
		return isset( $_REQUEST[ self::KEY_OFFSET ] );
	}

	/** @return bool */
	static function hasSearch() {
		return isset( $_REQUEST[ self::KEY_SEARCH ] );
	}
	
	/**
	 * @paran	string	$key	the sent column name.
	 * @return	bool
	 */
	static function hasSearchWithKey( $key ) {
		return isset( $_REQUEST[ self::KEY_SEARCH ] ) && isset( $_REQUEST[ self::KEY_SEARCH ][ $key ] );
	}
	
	//
	// VALUES
	//
	
	/** @return int */
	static function draw() {
		return self::naturalNumberFromKey( self::KEY_DRAW );
	}

	/** @return int */
	static function limit() {
		return self::naturalNumberFromKey( self::KEY_LIMIT );
	}
	
	/** @return int */
	static function offset() {
		return self::naturalNumberFromKey( self::KEY_OFFSET );
	}
	
	/** @return string or null */
	static function search() {
		return self::hasSearch() ? $_REQUEST[ self::KEY_SEARCH ] : null;
	}
	
	//
	// PRIVATE
	//
	
	/** @return int */	
	private static function naturalNumberFromKey( $key ) {
		$value = 0;
		if ( isset( $_REQUEST[ $key ] ) && is_integer( $_REQUEST[ $key ] ) ) {
			$value = intval( $_REQUEST[ $key ] );
		}
		return ( $value < 0 ) ? 0 : $value;
	}
	
}

?>