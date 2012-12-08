<?php
/* THIS FILE IS DISTRIBUTED UNDER THE CREATIVE COMMONS LICENCE (CC BY 3.0)
 * http://creativecommons.org/licenses/by/3.0/
 *
 * USE IT AT YOUR OWN RISK!
 */
 
/**
 * Directory utilities.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
class DirUtil {

	/**
	 * Returns all the subdirectories from a start path.
	 *
	 * @param string startPath
	 *	Start path to find. Defaul to '.' (current directory).
	 * @return array with all the found directories.
	 */
	static function allSubDirs( $startPath = '.' ) {		
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $startPath ), 
			RecursiveIteratorIterator::SELF_FIRST
			);
		$paths = array();
		foreach ( $iterator as $file ) {
			if ( $file->isDir() ) {
				array_push( $paths, $file->getRealpath() );
			}
		}
		return $paths;
	}

}

?>