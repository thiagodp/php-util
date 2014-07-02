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
 * By default, this file allows to automatically load a class without
 * need to include its name (ex: require_once 'MyClass.php').
 *
 * The class file should have the same name of it class. By default,
 * the file extension should be ".php", but you can configure it easily.
 *
 * <br />
 * USE EXAMPLE:
 * <code>
 *		<?php
 * 		require_once( 'autoload.php' );
 *		// Not necessary to include "MyClass.php" anymore ;)
 *
 *		$obj = new MyClass(); // Will search for MyClass.php
 *		?>
 * </code>
 * 
 * <br />
 * <pre>
 * OPTIONAL CONFIGURATIONS:
 *
 * - You may want to use autoload.php in your root php folder, in order to
 *   load any file you want to. For doing so, copy this file to your (root)
 *   php source folder. The "php-util" project folder should exist under it.
 *
 * - By default, autoload.php creates a "subdir.lst" in the first time it is
 *   executed. This file will contain all the subdirectories under its current
 *   folder. You may want to manually define your own subdirectories, in order
 *   to lower the load time.
 *
 * - You do not need to use subdir.lst. Instead, just change the source code
 *   to use a simple array like this:
 *   <code>
 *	 $subDirs = array( '/path/to/dir1', '/path/to/dir2', '/path/to/dirN' );
 *	 </code> 
 *   
 * </pre>
 * <br />
 *
 * IMPORTANT: Whether you prefer using subdir.lst (this is the default behaviour),
 *            do not forget about keeping it updated.
 *
 *
 * @author	Thiago Delgado Pinto
 * @version	3.1
 *
 * @see		{@link ClassLoader} {@link DirUtil}
 */

 
// Whether the current file can see a 'php-util' folder, its dependencies are
// inside this folder. Otherwise, they are in the current folder.
$phpUtilPath = file_exists( 'php-util' ) ? 'php-util/' : '';
 
require_once( $phpUtilPath . 'ClassLoader.php' );	// Uses ClassLoader::load
require_once( $phpUtilPath . 'io/DirUtil.php' );	// Uses DirUtil::allSubDirs

/**
 * Automatically load classes' files.
 *
 * @param className	the class name to be loaded.
 */
function phpUtilAutoload( $className ) {
	static $classLoader = null; // Created just once
	if ( ! isset( $classLoader ) ) { 

		// File to store the directories list
		define( 'SUB_DIR_FILE', 'subdir.lst' );
		$subDirs = array();
	
		if ( file_exists( SUB_DIR_FILE ) ) {
			// Load the subdirectories from the file		
			$content = file_get_contents( SUB_DIR_FILE );
			$subDirs = explode( PHP_EOL, $content );
		} else {
			// Save the subdirectories to the file
			$subDirs = DirUtil::allSubDirs( '.' );
			$content = implode( PHP_EOL, $subDirs );
			file_put_contents( SUB_DIR_FILE, $content, LOCK_EX );			
		}
		
		// Here you can configure other file extensions. Example:
		// $classLoader = new ClassLoader( $subDirs,
		// 		array( '.php', '.class.php' ) );
		$classLoader = new ClassLoader( $subDirs );
	}
	// Load the class
	$classLoader->load( $className );
}

// Register
spl_autoload_register( 'phpUtilAutoload' );
?>