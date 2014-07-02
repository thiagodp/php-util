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
 * Entity changer.
 *
 * @author	Thiago Delgado Pinto
 */
interface EntityChanger {

	/**
	 * Add an entity.
	 *
	 * @param obj	the entity to add.
	 */
	function add( $obj );
	
	/**
	 * Update an entity.
	 *
	 * @param obj	the entity to update.
	 */	
	function update( $obj );
	
	/**
	 * Remove an entity.
	 *
	 * @param obj	the entity to remove.
	 */	
	function remove( $obj );	
}

?>