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
 
require_once 'EntityFinder.php';
require_once 'EntityChanger.php';
require_once 'EntityCounter.php';

/**
 * A simple entity repository.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
interface EntityRepository extends EntityFinder, EntityChanger, EntityCounter {
}

?>