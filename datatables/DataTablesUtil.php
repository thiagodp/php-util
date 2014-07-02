<?php

/**
 * DataTables utility functions.
 *
 * @author	Thiago Delgado Pinto
 */
class DataTablesUtil {

	/**
	 * Return true if the client sent the search parameter, or false otherwise.
	 */
	static function hasSearch() {
		return ( isset( $_REQUEST[ 'sSearch' ] )
			&& mb_strlen( $_REQUEST[ 'sSearch' ] ) > 0 );
	}
	
	/**
	 * Return the value of the search parameter.
	 */
	static function search() {
		return self::hasSearch() ? $_REQUEST[ 'sSearch' ] : null;
	}
	
	/**
	 * Return true if the client sent the limit parameter, or false otherwise.
	 */
	static function hasLimit() {
		return isset( $_REQUEST[ 'iDisplayLength' ] );
	}

	/**
	 * Return the value of the search parameter as an integer.
	 */
	static function limit() {
		if ( self::hasLimit() ) {
			$value = intval( $_REQUEST[ 'iDisplayLength' ] );
			return ( $value < 0 ) ? 0 : $value;
		}
		return 0;
	}

	/**
	 * Return true if the client sent the offset parameter, or false otherwise.
	 */	
	static function hasOffset() {
		return isset( $_REQUEST[ 'iDisplayStart' ] );
	}

	/**
	 * Return the value of the offset parameter as an integer.
	 */	
	static function offset() {
		if ( self::hasOffset() ) {
			$value = intval( $_REQUEST[ 'iDisplayStart' ] );
			return ( $value < 0 ) ? 0 : $value;
		}
		return 0;		
	}
}

?>