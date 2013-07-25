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
 * Load a class by its name.
 *
 * @author	Thiago Delgado Pinto
 * @version	2.0
 */
class ClassLoader {
	
	private $extensions;
	private $cachedFiles;
	private $debugMode;
	
	/**
	 * Allows to specify the directories and extensions where to find classes' files.
	 *
	 * @param dirs			an array with the bdirectories where to find the files.
	 * 						Hint: use DirUtil::allSubDirs() to get the subdirectories from a path.
	 * @param extensions	an array with the file extensions to find (defaults to '.php').
	 *						OPTIONAL default array( '.php' ).
	 * @param debugMode		true for printing debugging messages. OPTIONAL default false.
	 */
	function __construct(
		array $dirs,
		array $extensions = array( '.php' ),
		$debugMode = false
		) {		
		$this->dirs = $dirs;
		$this->extensions = count( $extensions ) > 0 ? $extensions : array( '.php' );
		$this->debugMode = $debugMode;
	}
	
	function getDebugMode() { return $this->debugMode; }	
	function setDebugMode( $debugMode ) { $this->debugMode = $debugMode; }	
	
	private function joinDirs( $d1, $d2 ) {
		return str_replace( array( '\\', '\\\\' ), '/', $d1 . $d2 );
	}
		
	/**
	 * Tries to load a class with a given name.
	 * <p>
	 * IMPORTANT:
	 * <ul>
	 *		<li>The name of the class and its file should be the same.</li>
	 * 		<li>Uses <code>require_once</code> to include the files.</li>
	 *  	<li>All the found class paths are cached to faster the loading on future calls.</li>
	 * </ul>
	 * </p>
	 *
	 * @param className	the class name.
	 * @return			true if the class is loaded, false otherwise.
	 */
	function load( $className ) {	
		// Check if it is in the cache
		if ( isset( $this->cachedFiles[ "$className" ] ) ) {
			if ( $this->debugMode ) echo 'Found in cache: ', $this->cachedFiles[ "$className" ], '<br />';
			require_once( $this->cachedFiles[ "$className" ] );
			return true;
		}		
		foreach ( $this->dirs as $dir ) {
			if ( $this->debugMode ) echo 'Dir ', $dir, '<br />';
			foreach ( $this->extensions as $ext ) {
				$path = $dir . '/'. $className . $ext;				
				if ( $this->debugMode ) echo "PATH: '$path'.<br />";	
				if ( file_exists( $path ) ) {										
					$this->cachedFiles[ "$className" ] = $path; // Add to cache
					if ( $this->debugMode ) echo 'FOUND. Added to cache: ', $this->cachedFiles[ "$className" ], '<br />';				
					require_once( $path ); // Load library
					return true;
				}
			}
		}
		return false;
	}	
}
?>