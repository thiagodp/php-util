<?php

/**
 * Useful file-related methods.
 *
 * @author	Thiago Delgado Pinto
 * @version	0.1
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
}

?>