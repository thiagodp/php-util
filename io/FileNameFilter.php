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
 
require_once 'FileSystemRegexFilter.php';

/**
 * File name filter that uses regular expression.
 *
 * <br />
 * How to use it:
 * <code>
 * $startPath = '.'; // Current directory
 * $pattern = '/\.php$/i'; // "Terminating with .php"
 *
 * $dirIt = new RecursiveDirectoryIterator( $startPath );
 * $filter = new FileNameFilter( $dirIt, $pattern );
 * $itIt = new RecursiveIteratorIterator( $filter, RecursiveIteratorIterator::SELF_FIRST ); 
 *
 * foreach ( $itIt as $file ) {
 * 		echo $file->getFilename(), ' (', $file->getRealpath(), ') <br />'; 
 * }
 * </code>
 * 
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
class FileNameFilter extends FileSystemRegexFilter {

    public function accept() {
        return ( $this->isFile() && preg_match( $this->getRegex(), $this->getFilename() ) );
    }
}

?>