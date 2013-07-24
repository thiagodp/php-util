<?php

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