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
 *		// Not necessary to include "MyClass.php" anymore !
 *
 *		$obj = new MyClass(); // Will search for MyClass.php
 *		?>
 * </code>
 * 
 * <br />
 * CONFIGURATION:
 * <p> 
 * 1.	Copy this file to your (root) source folder. It should
 * 		exists a 'php-util' folder inside it.
 * 2.	Create a "subdir.lst" file with your subdirectories (one per line)
 *		and keep it updated.
 * </p>
 
 * <br /> 
 * IMPORTANT:
 * 1.	If you do not create "subdir.lst" it will be created automatically.
 *		Do not forget about keeping it updated!
 * 2.	You do not need to use this external file! Just change the code to
 * 		use use a raw array like this:
 *		<code>
 *		$subDirs = array( '/path/to/mydir', '/path/to/myotherdir' );
 *		</code> 
 * </p>
 *
 *
 * @author	Thiago Delgado Pinto
 * @version	2.0
 *
 * @see		{@link ClassLoader} {@link DirUtil}
 */

require_once( 'php-util/ClassLoader.php' );	// Uses ClassLoader::load
require_once( 'php-util/io/DirUtil.php' );	// Uses DirUtil::allSubDirs

/**
 * Automatically load classes' files.
 *
 * @param className	the class name to be loaded.
 */
function __autoload( $className ) {
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
?>