<?php

/**
 * Control the bits of a flag. Useful for defining values such as
 * the UNIX's file system protection flags or enumerated values.
 * 
 * @author	Thiago Delgado Pinto
 *
 * <pre>
 * Example on how using it:
 *
 * class Permission extends Flag {
 *
 * 		const ACCESS = 1;
 *		const CREATE = 2;
 *		const MODIFY = 4;
 *		const REMOVE = 8;
 * 		
 *		static function all() {
 * 			return self::ACCESS + self::CREATE + self::MODIFY + self::REMOVE;
 *		} 
 *	}
 *
 * Now you can add, check, and remove flags easily:
 *
 * $p = new Permission( Permission::all() );
 * echo '<br />', $p->get(); // 15
 * $p->add( Permission::CREATE ); 
 * echo '<br />', $p->get(); // stay 15 !
 * $p->remove( Permission::CREATE ); 
 * echo '<br />', $p->get(); // 13 
 * echo '<br />', $p->has( Permission::CREATE ) ? 'can create' : 'cannot create';
 * </pre>
 *
 */
class Flag {

	private $content = 0;
	
	function __construct( $value = 0 ) {
		if ( $value != 0 ) {
			$this->add( $value );
		}
	}
	
	/// Return the content of the flag.
	final function get() {
		return $this->content;
	}
	
	/// Return true whether it has a certain flag.
	final function has( $value ) {
		if ( ! $this->isValid( $value ) ) { return; }
		return $value == ( $this->content & $value );
	}

	/// Add the given flag.
	final function add( $value ) {
		if ( ! $this->isValid( $value ) ) { return; }
		$this->content |= $value;
		return $this;
	}
	
	/// Remove the given flag.
	final function remove( $value ) {
		if ( ! $this->isValid( $value ) ) { return; }
		$this->content &= ~$value;
		return $this;
	}
	
	/// Return true whether the flag value is considered valid.
	protected function isValid( $value ) {
		return is_integer( $value ) && $value >= 0;
	}
} 
?>