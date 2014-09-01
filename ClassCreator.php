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
 * How to use it:
 *  > Run this file into your browser and follow the instructions. :)
 *
 * @author	Thiago Delgado Pinto
 * @version	1.1
 */ 

//
// FUNCTIONS
//
  
function __generateQuery( array $parameters ) {
	$q = '';
	foreach ( $parameters as $key => $value ) {
		$q .= ( '' === $q ) ? '?' : '&';
		$q .= "$key=$value"; 
	}
	return $q;
}

function __defaultValue( $value ) {
	$type = gettype( $value );
	if ( 'string'  === $type ) { return '"' . $value . '"'; }
	if ( 'boolean' === $type ) { return $value ? '1' : '0'; }
	return $value;
}

function __initialValueFor( $type, $nullify = false ) {
	if ( 'string'  === $type ) { return ' = \'\''; }
	if ( 'integer' === $type || 'int'   === $type ) { return ' = 0'; }
	if ( 'double'  === $type || 'float' === $type ) { return ' = 0.0'; }
	if ( 'boolean' === $type || 'bool'  === $type ) { return ' = false'; }
	if ( 'array'   === $type ) { return ' = array()'; }
	if ( $nullify ) { return ' = null'; }
	return ''; // None
}

function __getterNameFor( $field, $getter ) {
	return $getter . __functionName( $field );
}

function __setterNameFor( $field, $setter ) {
	return $setter . __functionName( $field );
}

function __functionName( $field ) {
	return mb_strtoupper( mb_substr( $field, 0, 1 ) )
		. mb_substr( $field, 1 );
}

function __setterParameterFor( $field, $type ) {
	if ( 'array' === mb_strtolower( $type ) ) {
		return 'array $' . $field;
	}
	
	$ignoredTypes = array( '', 'boolean', 'bool', 'integer', 'int',
	  'double', 'float', 'string', 'object', 'resource',
	  'NULL', 'unknown type' );
	if ( ! in_array( mb_strtolower( $type ), $ignoredTypes ) ) {
		return $type . ' $' . $field;
	}
	
	return '$' . $field;
}

//
// DEFINITIONS
//

// Parameters

define( '_HELP', '_h' );

define( '_CLASS', '_c' );

define( '_FOLDER', '_f' );
define( '_OVERWRITE', '_o' );
define( '_EXTENSION', '_x' );
define( '_GETTER', '_g' );
define( '_SETTER', '_s' );
define( '_NULLIFY', '_n' );

// Default values

define( 'DEFAULT_FOLDER', __DIR__ );
define( 'DEFAULT_OVERWRITE', false );
define( 'DEFAULT_EXTENSION', '.php' );
define( 'DEFAULT_GETTER', 'get' );
define( 'DEFAULT_SETTER', 'set' );
define( 'DEFAULT_TYPE', 'string' );
define( 'DEFAULT_NULLIFY', false );

// Example values

define( 'EXAMPLE_CLASS_NAME', 'Contact' );

$exampleParameters = array(
	_CLASS => EXAMPLE_CLASS_NAME
	, 'id' => 'integer'
	, 'name' => 'string'
	, 'emails' => 'array'
	, 'gender' => 'Gender'
	);

//
// CHECKINGS
//

$options = array(
	  _HELP => 'for presenting this help'
	  , _CLASS => 'for defining the class name (<b>mandatory parameter</b>)'
	  , _FOLDER => 'for defining the target folder (default to the current folder, currently <code>' . __defaultValue( DEFAULT_FOLDER ) . '</code>)'
	  , _OVERWRITE => 'for overwrite the class file (default <code>' . __defaultValue( DEFAULT_OVERWRITE ) . '</code>)'
	  , _EXTENSION => 'for defining the class file extension (default <code>' . __defaultValue( DEFAULT_EXTENSION ) . '</code>)'
	  , _GETTER => 'for defining the getter prefix (default <code>' . __defaultValue( DEFAULT_GETTER ) . '</code>)'
	  , _SETTER => 'for defining the setter prefix (default <code>' . __defaultValue( DEFAULT_SETTER ) . '</code>)'
	  , _NULLIFY => 'for setting <code>NULL</code> as the initial value for your own data types (default <code>' . __defaultValue( DEFAULT_NULLIFY ) . '</code>)'
	  );
	  
ksort( $options );
	  
$helpMode = isset( $_GET[ _HELP ] ) || ! isset( $_GET[ _CLASS ] );

// Checking needed parameters

$class = $helpMode ? EXAMPLE_CLASS_NAME : $_GET[ _CLASS ];

// Defining parameters

$parameters = $helpMode ? $exampleParameters : $_GET;

// Checking options

$folder = isset( $parameters[ _FOLDER ] ) ? $parameters[ _FOLDER ] : DEFAULT_FOLDER;
$overwrite = isset( $parameters[ _OVERWRITE ] ) ? (boolean) $parameters[ _OVERWRITE ] : DEFAULT_OVERWRITE;
$extension = isset( $parameters[ _EXTENSION ] ) ? $parameters[ _EXTENSION ] : DEFAULT_EXTENSION;
$getter = isset( $parameters[ _GETTER ] ) ? $parameters[ _GETTER ] : DEFAULT_GETTER;
$setter = isset( $parameters[ _SETTER ] ) ? $parameters[ _SETTER ] : DEFAULT_SETTER;
$nullify = isset( $parameters[ _NULLIFY ] ) ? (boolean) $parameters[ _NULLIFY ] : DEFAULT_NULLIFY;


//
// PROCESSING
//

if ( $helpMode ) {

	$msg = '<h1>HELP</h1>Parameters are:<br /> <ul>';
	foreach ( $options as $key => $value ) {
		$msg .= '<li> <code>'. $key . '</code> ' . $value . '</li>';
	}
	$msg .= '</ul>';
	$msg .= '<p><b>Any other parameters will be understanded as class fields, and their ';
	$msg .= 'values as field types.</b> Default type is <code>' . DEFAULT_TYPE . '</code>.</p>';
	$msg .= '<p>For instance:<br /><br />'
		. '<code>' . __generateQuery( $exampleParameters ) . '</code>'
		. '<br /><br />will generate a file named <code>'
		. $class . $extension
		. '</code> with the following definition:';
		
	echo $msg;
}

// Checking class existence

$filePath = $folder . '/' . $class . $extension;

if ( ! $helpMode && file_exists( $filePath ) && ! (boolean) $overwrite ) {
	die( 'File already exists: <code>"' . $filePath . '"</code>.<br /><br />'
	  . 'Whether you want to overwrite this file, pass the parameter '
	  . '<code>' . _OVERWRITE . '=' . __defaultValue( true ) . '</code>'  );
}

// Class fields

$fields = array();

foreach ( $parameters as $key => $value ) {
	$fieldName = trim( $key );
	$fieldType = trim( $value );
	// Ignore options
	if ( isset( $options[ $fieldName ] ) ) { continue; }
	// Add to fields. The value is the field type.
	$fields[ $fieldName ] = ( '' === $fieldType ) ? DEFAULT_TYPE : $fieldType;
}

// Class content

$content = 'class ' . $class . ' {'
	. PHP_EOL;
foreach ( $fields as $field => $type ) {
	$content .=	PHP_EOL . "\tprivate \$$field" . __initialValueFor( $type, $nullify ) . ';';
}
$content .=	PHP_EOL;
foreach ( $fields as $field => $type ) {
	$content .= ''
		// Getter
		. PHP_EOL . "\tfunction " . __getterNameFor( $field, $getter ) . '() { '
		. "return \$$field; }"
		// Setter
		. PHP_EOL . "\tfunction " . __setterNameFor( $field, $setter ) . '( '
		. __setterParameterFor( $field, $type ) .' ) { '
		. '$this->' . $field . ' = $' . $field . '; }'
		. PHP_EOL
		;
}

$content .=	PHP_EOL . '}';

// File content

$fileContent = '<?php' . PHP_EOL . PHP_EOL . $content . PHP_EOL . '?>';

// Presenting the results

if ( ! $helpMode ) {
	echo '<br />Generating file <code>' . $filePath . '</code> ...<br />';
	
	$bytes = file_put_contents( $filePath, $fileContent );

	if ( false === $bytes ) {
		die( '<br />Sorry, there was an error generating the file.' );
	}

	echo '<br />SUCCESS! File has ' . $bytes . ' bytes.';
}

echo '<hr /><pre><code>';
echo "$content";
echo '</code></pre>';
?>