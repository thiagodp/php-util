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
	 * Return all the entities.
	 *
	 * @param limit		the maximum number of entities to retrieve. OPTIONAL.
	 * @param offset	the number of entities to ignore. OPTIONAL.
	 * @param orders	the array with the keys as columns and values as the order for sorting.
	 *					OPTIONAL. Example: array( 'email' => 'asc' ) to sort by 'email' ascending.
	 * @param filters	the array with the keys as columns and values for filtering. OPTIONAL.
	 *					Example: array( 'email' => 'myemail@site.com' ) to filter by 'email'. 
	 * @param exactly	true for an exact search in the filter, false otherwise.
	 * @return			an array with the entities.	
	 */
	function all( $limit = 0, $offset = 0,
		array $orders = array(),
		array $filters = array(),
		$exactly = false
		);
}

?>