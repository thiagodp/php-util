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
 * class Permition extends Flag {
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
 * Now you can add, check or remove this flags easily:
 *
 * $p = new Permition();
 * $p->add( Permition::all() );
 * echo '<br />', $p->get(); // 15
 * $p->add( Permition::CREATE ); 
 * echo '<br />', $p->get(); // stay 15 !
 * $p->remove( Permition::CREATE ); 
 * echo '<br />', $p->get(); // 13 
 * echo '<br />', $p->has( Permition::CREATE ) ? 'can create' : 'cannot create';
 * </pre>
 *
 */
class Flag {

	private $content = 0;
	
	function get() {
		return $this->content;
	}
	
	function has( $value ) {
		if ( ! $this->isValid( $value ) ) { return; }
		return $value == ( $this->content & $value );
	}

	function add( $value ) {
		if ( ! $this->isValid( $value ) ) { return; }
		$this->content |= $value;
		return $this;
	}
	
	function remove( $value ) {
		if ( ! $this->isValid( $value ) ) { return; }
		$this->content &= ~$value;
		return $this;
	}
	
	private function isValid( $value ) {
		return is_integer( $value ) && $value >= 0;
	}
}

?>