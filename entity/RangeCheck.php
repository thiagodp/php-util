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

require_once 'BusinessRuleException.php';
 
/**
 * Useful methods for checking range and length in domain data.
 *
 * @author	Thiago Delgado Pinto
 */
class RangeCheck {

	/***
	 * Check if a number is positive and throw an exception with a given
	 * message otherwise.
	 *
	 * @param number	the number to check.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */
	static function positive( $number, $msg ) {
		self::minValue( $number, 0, $msg );
	}

	/***
	 * Check if a number is greater than a minimum value and
	 * throw an exception with a given message otherwise.
	 *
	 * @param number	the number to check.
	 * @param min		the minimum value.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */
	static function minValue( $number, $min, $msg ) {
		if ( ! is_numeric( $number ) || $number < $min )
			throw new BusinessRuleException( $msg );
	}

	/***
	 * Check if a number is lower than a maximum value and
	 * throw an exception with a given message otherwise.
	 *
	 * @param number	the number to check.
	 * @param max		the maximum value.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */	
	static function maxValue( $number, $max, $msg ) {
		if ( ! is_numeric( $number ) || $number > $max )
			throw new BusinessRuleException( $msg );
	}
	
	/***
	 * Check if a number is greater than a minimum value,
	 * lower than a maximum value, and throw an exception
	 * with a given message otherwise.
	 *
	 * @param number	the number to check.
	 * @param min		the minimum value.
	 * @param max		the maximum value.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */	
	static function valueRange( $number, $min, $max, $msg ) {
		if ( ! is_numeric( $number ) || $number < $min || $number > $max )
			throw new BusinessRuleException( $msg );
	}	

	/***
	 * Check if a value's length is greater than a minimum value
	 * and throw an exception with a given message otherwise.
	 *
	 * @param value		the value to check.
	 * @param min		the minimum length.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */	
	static function minLength( $value, $min, $msg ) {
		if ( mb_strlen( $value ) < $min )
			throw new BusinessRuleException( $msg );
	}

	/***
	 * Check if a value's length is lower than a maximum value
	 * and throw an exception with a given message otherwise.
	 *
	 * @param value		the value to check.
	 * @param max		the maximum length.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */
	static function maxLength( $value, $max, $msg ) {
		if ( mb_strlen( $value ) > $max )
			throw new BusinessRuleException( $msg );
	}

	/***
	 * Check if a value's length is greater than a minimum value,
	 * lower than a maximum value, and throw an exception with a
	 * given message otherwise.
	 *
	 * @param value		the value to check.
	 * @param min		the minimum length.
	 * @param max		the maximum length.
	 * @param msg		the exception message.
	 * @throw			BusinessRuleException.
	 */	
	static function valueLength( $value, $min, $max, $msg ) {
		$len = mb_strlen( $value );
		if ( $len < $min || $len > $max )
			throw new BusinessRuleException( $msg );
	}
}
?>