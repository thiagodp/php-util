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
 * This file allows to automatically load a class without declaring its file, where the file have
 * the same name as the class, plus '.php' or '.class.php'. The file will be searched in all the
 * subdirectories where the 'autoload.php' file is in.
 *
 * <h2>EXAMPLE</h2>
 * <p> 
 * <code>
 *		<?php
 * 		require_once( 'autoload.php' );
 *		$obj = new MyClass(); // Will search for MyClass.php or MyClass.class.php
 *		?>
 * </code>
 * </p> 
 * <h2>HOW TO USE IT</h2>
 * <p> 
 *		Put this file at your (root) source folder. It should exists a 'php-util' folder inside it.
 * </p>
 *
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 *
 * @see		{@link ClassLoader} {@link DirUtil}
 */
 
// IMPORTANT: autoload.php should be put in a folder a level up from php-util.
require_once( 'php-util/ClassLoader.php' );	// Uses ClassLoader::load
require_once( 'php-util/DirUtil.php' );		// Uses DirUtil::allSubDirs

/**
 * Allows to automatically load classes' files.
 *
 * @param className	the class name to be loaded.
 */
function __autoload( $className ) {
	static $classLoader = null;
	if ( ! isset( $classLoader ) ) {	
		$subDirs = DirUtil::allSubDirs( '.' );
		$classLoader = new ClassLoader( $subDirs );
	}
	$classLoader->load( $className );
}
?>