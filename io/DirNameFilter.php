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
 * Directory name filter that uses regular expression.
 *
 * <br />
 * How to use it:
 * <code>
 * $startPath = '.'; // Current directory
 * $pattern = '/^[^\.]/i'; // "Not starting with dot"
 *
 * $dirIt = new RecursiveDirectoryIterator( $startPath );
 * $filter = new DirNameFilter( $dirIt, $pattern );
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
class DirNameFilter extends FileSystemRegexFilter {

    public function accept() {
        return ( $this->isDir() && preg_match( $this->getRegex(), $this->getFilename() ) );
    }
}

?>