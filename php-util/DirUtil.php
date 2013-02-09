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
 * @version	1.1
 */
class DirUtil {

	/**
	 * Returns all the subdirectories from a start path.
	 *
	 * @param string startPath
	 *	Start path to find. Defaul to '.' (current directory).
	 * @return array with all the found directories.
	 */
	static function allSubDirs( $startPath = '.', $forceReverseBars = true ) {		
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator( $startPath ), 
			RecursiveIteratorIterator::SELF_FIRST
			);
		$paths = array();
		foreach ( $iterator as $file ) {
			if ( $file->isDir() ) {
				$path = $file->getRealpath();
				if ( $forceReverseBars ) {
					$path = str_replace( '\\', '/', $path );
				}
				array_push( $paths, $path );
			}
		}
		return $paths;
	}

}

?>