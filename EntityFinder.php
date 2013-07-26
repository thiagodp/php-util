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
 * Entity finder.
 *
 * @author	Thiago Delgado Pinto
 */
interface EntityFinder {

	/**
	 * Return true if the given object exists.
	 *
	 * @param obj	the object to verify.
	 * @return		true if the object exists, false otherwise.
	 */
	function exists( $obj );

	/**
	 * Return an entity with a given id.
	 *
	 * @param id	the entity id.
	 * @return		an entity with the id.
	 */
	function withId( $id );
	
	/**
	 * Return an array of entities with the supplied filters.
	 *
	 * @param filters	the array of filters with information to find the entities.
	 * @param exactly	true for an extact search, false otherwise.
	 * @param limit		the maximum number of entities to retrieve. OPTIONAL.
	 * @param offset	the number of entities to ignore. OPTIONAL.
	 * @return			an array with the found entities.
	 */	
	function with( array $filters, $exactly = false, $limit = 0, $offset = 0 );
	
	/**
	 * Return all the entities.
	 *
	 * @param limit		the maximum number of entities to retrieve. OPTIONAL.
	 * @param offset	the number of entities to ignore. OPTIONAL.
	 * @return			an array with the entities.	
	 */
	function all( $limit = 0, $offset = 0 );
}

?>