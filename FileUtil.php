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
 * Useful file-related methods.
 *
 * @author	Thiago Delgado Pinto
 * @version	0.2
 */
class FileUtil {

	/**
	 * Returns the readable file or folder size.
	 *
	 * @param bytes the size in bytes.
	 * @return		a string with the size in the appropriate size.
	 */
	static function readableSize( $bytes ) {
		if      ( $bytes >= 1073741824 ) return number_format( $bytes / 1073741824, 2 ) . ' GB';
        else if ( $bytes >= 1048576 ) return number_format( $bytes / 1048576, 2 ) . ' MB';
        else if ( $bytes >= 1024 ) return number_format( $bytes / 1024, 2 ) . ' KB';
        else if ( $bytes >  1 ) return $bytes . ' bytes';
        else if ( $bytes == 1 ) return $bytes . ' byte';
		return '0 bytes';
	}
	
	/**
	 * Prevent the direct access to the current file, redirecting the user to another page.
	 *
	 * @param urlToRedirect	the url used to redirect the user.
	 */
	static function preventDirectAccessToTheCurrentFile( $urlToRedirect ) {
		$whereTheFileIs	= basename( $_SERVER[ 'PHP_SELF' ] );
		$whereTheFileWasCalled = basename( __FILE__ );
		if ( $whereTheFileIs === $whereTheFileWasCalled ) {
			// Prevent loop
			if ( $urlToRedirect === $whereTheFileIs ) {
				die( 'You have tried to redirect to the same URL.' );
			}
			header( "Location: $urlToRedirect" );
			die();
		}
	}	
}
?>