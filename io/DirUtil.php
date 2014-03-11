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
 
 
require_once 'DirNameFilter.php';

/**
 * Directory utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	2.0
 */
class DirUtil {

	/**
	 * Returns all the subdirectories from a start path.
	 *
	 * @param startPath
	 *			a string with the start path (defaults to current directory).
	 * @param pattern
	 *			a regex pattern used to filter the directories.
	 *			The default value is '/^[^\.]/i' (not starting with dot).
	 * @return	an array with all the found directories.
	 * @throw	UnexpectedValueException
	 */
	static function allSubDirs( $startPath = '.', $pattern = '/^[^\.]/i' ) {
	
		$dirIt = new RecursiveDirectoryIterator( $startPath );
		$filter = new DirNameFilter( $dirIt, $pattern );
		$itIt = new RecursiveIteratorIterator( $filter, RecursiveIteratorIterator::SELF_FIRST );
	
		$paths = array();
		foreach ( $itIt as $file ) {
			if ( $file->isDir() ) {
				// Replace \ with /
				$path = str_replace( '\\', '/', $file->getPathname() );
				// Do not allow duplicates
				if ( array_search( $path, $paths ) !== false ) {
					continue;
				}
				array_push( $paths, $path );
			}
		}
		return $paths;
	}

}
?>