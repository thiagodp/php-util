<?php
/* THIS FILE IS DISTRIBUTED UNDER THE CREATIVE COMMONS LICENCE (CC BY 3.0)
 * http://creativecommons.org/licenses/by/3.0/
 *
 * USE IT AT YOUR OWN RISK!
 */
 
/**
 * Load a class by its name.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.1
 */
class ClassLoader {

	private $debugMode = false;
	private $cache = array();
	private $levelDirs = array();
	private $subDirs = array();
	private $extensions = array();
	
	/**
	 * Allows to specify the directories and extensions where to find classes' files.
	 *
	 * @param array levelDirs
	 *	Levels where to find the files. Default to array( '.', '..' ).
	 * @param array levelDirs
	 *	Sub dirs where to find the files.
	 * @param array extensions
	 *	Extensions to find. Default to array( '.php' ).
	 */
	function __construct(
		array $levelDirs = array( '.', '..' ),
		array $subDirs = array(),
		array $extensions = array( '.php' )	
		) {
		$this->levelDirs = $levelDirs;
		$this->subDirs = $subDirs;
		$this->extensions = $extensions;
	}
		
	/**
	 * Tries to load a class with a given name.
	 *
	 * IMPORTANT:
	 *  - The name of the class and its file should be the same.
	 * 	- Uses <code>require_once</code> to include the files.
	 *  - All the found class paths are cached to faster the loading on future calls.
	 *
	 * @param string className
	 * 					Class name.
	 * @return true if the class is loaded.
	 */
	function load( $className ) {	
		// Check if it is in the cache
		if ( isset( $this->cache[ "$className" ] ) ) {
			$this->printCache( $className, true );
			require_once( $this->cache[ "$className" ] );
			return true;
		}
		// Search
		foreach( $this->levelDirs as $l ) {
			foreach( $this->subDirs as $s ) {
				foreach( $this->extensions as $e ) {
					$path = $this->makePath( $l, $s, $className, $e );	
					if ( $this->debugMode ) {
						echo "Trying to load path: '$path'.<br />";
					}
					if ( file_exists( $path ) ) {						
						// Add to cache
						$this->cache[ "$className" ] = $path;
						// Print cache
						$this->printCache( $className, false );
						// Load library
						require_once( $path );
						return true;
					} // if
				} // foreach
			} // foreach
		} // foreach
		return false;
	}
	
	
	function getDebugMode() {
		return $this->debugMode;
	}
	
	function setDebugMode( $debugMode ) {
		$this->debugMode = $debugMode;
	}
	
	/**
	 * Print the cache content if it is in debug mode.
	 */
	private function printCache( $className, $wasCached = false ) {
		if ( ! $this->debugMode || ! isset( $this->cache[ "$className" ] ) ) {
			return;
		}
		$text = 'Found in ' . ( $wasCached ? 'CACHED PATH: ' : 'PATH: ' );
		echo $text . $this->cache[ "$className" ] . '<br />';
	}

	/**
	 * Make a path.
	 *
	 * @param string level Directory level.
	 * @param string subdir Subdirectory.
	 * @param string className Class name.
	 * @param string extension Extension.
	 * @return The path.
	 */
	private function makePath( $level, $subDir, $className, $extension ) {
		$path = $className . $extension;
		if ( ! empty( $subDir ) ) {
			$path = $subDir .'/'. $path;
		}
		if ( ! empty( $level ) ) {
			$path = $level .'/'. $path;
		}
		$path = str_replace( '\\', '/', $path ); 
		return $path;
	}
	
}

?>