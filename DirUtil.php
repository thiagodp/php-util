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
 * Directory utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.1
 */
class DirUtil {

	/**
	 * Returns all the subdirectories from a start path.
	 *
	 * @param startPath	a string with the start path (defaults to current directory).
	 * @return			an array with all the found directories.
	 */
	static function allSubDirs( $startPath = '.' ) {		
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $startPath ), 
			RecursiveIteratorIterator::SELF_FIRST
			);
		$paths = array();
		foreach ( $iterator as $file ) {
			if ( $file->isDir() ) {
				$path = str_replace( '\\', '/', $file->getRealpath() );				
				array_push( $paths, $path );
			}
		}
		return $paths;
	}

}

?>