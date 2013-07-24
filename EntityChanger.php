<?php

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