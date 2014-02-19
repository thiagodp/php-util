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
 * A regex-based filter for files and directories.
 *
 * @author	Thiago Delgado Pinto
 * @version	1.0
 */
abstract class FileSystemRegexFilter extends RecursiveRegexIterator {
    
	private $regex;
	
    public function __construct(RecursiveIterator $it, $regex) {
        $this->regex = $regex;
        parent::__construct( $it, $this->regex );
    }
	
	public function getRegex() { return $this->regex; }
}

?>