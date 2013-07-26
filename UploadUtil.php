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
 
require_once 'UploadedFile.php';

/**
 * Some useful functions related to file uploading.
 *
 * @see UploadedFile
 *
 * @author	Thiago Delgado Pinto
 * @version	0.1
 */
class UploadUtil {

	/**
	 * Create an array of {@code UploadedFile}s  from an array of files got from $_FILES variable
	 * with a given name.
	 *
	 * @param name	The key of the $_FILES variable with the array of uploaded files.
	 * @return		An array of {@code UploadFile} objects.
	 */
	static function uploadedFiles( $name ) {
		$attributes = array( 'name', 'type', 'size', 'tmp_name', 'error' );
		foreach ( $attributes as $attr ) {
			if ( ! isset( $_FILES[ $name ][ $attr ] ) ) {
				return array();
			}
		}
		$names = $_FILES[ $name ][ 'name' ];
		$types = $_FILES[ $name ][ 'type' ];
		$sizes = $_FILES[ $name ][ 'size' ];
		$tmpNames = $_FILES[ $name ][ 'tmp_name' ];
		$errors = $_FILES[ $name ][ 'error' ];		
		$files = array();
		$count = count( $_FILE[ $name ][ 'name' ] );
		for ( $i = 0; $i < $count; ++$i ) {
			$uf = new UploadedFile( $names[ $i ], $types[ $i ], $sizes[ $i ], $tmpNames[ $i ], $errors[ $i ] );
			array_push( $files, $uf );
		}
		return $files;
	}
	
	// SOME FILE FORMATS
	
	static function isImage( $type ) {
		return preg_match( "/(image).*/", $type );
	}
	
	static function isAudio( $type ) {
		return preg_match( "/(audio).*/", $type );
	}
	
	static function isVideo( $type ) {
		return preg_match( "/(video).*/", $type );
	}	

	// SOME FILE TYPES	
	
	static function isJpg( $type ) {
		return preg_match( "/(image)\/(jpg|jpeg)/", $type );
	}
	
	static function isPng( $type ) {
		return preg_match( "/(image)\/(png)/", $type );
	}
	
	static function isGif( $type ) {
		return preg_match( "/(image)\/(gif)/", $type );
	}
	
	static function isDoc( $type ) {
		return preg_match( "/(application)\/(msword)/", $type );
	}
	
	static function isXls( $type ) {
		return preg_match( "/(application)\/(excel)/", $type );
	}
	
	static function isPpt( $type ) {
		return preg_match( "/(application)\/(powerpoint)/", $type );
	}	
	
	static function isPdf( $type ) {
		return preg_match( "/(application)\/(pdf)/", $type );
	}
	
	static function isZip( $type ) {
		return preg_match( "/(application)\/(zip)/", $type );
	}	
}

?>