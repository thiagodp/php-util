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
 * A simple but useful wrapper for PDO.
 *
 * @see PDO
 * 
 * @author	Thiago Delgado Pinto
 * @version	0.2
 */
class PDOWrapper {

	private $pdo;
	
	function __construct( PDO $pdo ) {
		$this->pdo = $pdo;
	}
	
	function getPDO() {
		return $this->pdo;
	}
	
	/**
	 * Create a PDO object using a cached connection.
	 *
	 * @see http://www.php.net/manual/en/pdo.connections.php
	 */
	static function create( $dsn, $username = '', $password = '', $options = array() ) { // throw
		// Cache the connection and reuse it
		if ( ! isset( $options[ PDO::ATTR_PERSISTENT ] ) ) {
			$options[ PDO::ATTR_PERSISTENT ] = true;
		}
		return new PDO( $dsn, $username, $password, $options );
	}
	
	/**
	 * Create a PDO object using a cached connection and the "mode exception".
	 *
	 * @see http://www.php.net/manual/en/pdo.connections.php
	 */
	static function createInModeException( $dsn, $username = '', $password = '', $options = array() ) { // throw
		$pdo = self::create( $dsn, $username, $password, $options );
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		return $pdo;
	}
	
	/**
	 * Generate an ID for a table based on its MAX value.
	 *
	 * @param tableName		the name of the table.
	 * @param idFieldName	the name of the id field.
	 * @return				the next id value or 1 if there are no records.
	 */
	function generateId( $tableName, $idFieldName = 'id' ) { // throws
		$maxColumn = 'M_A_X_';
		$cmd = "select MAX( $idFieldName ) as '$maxColumn' from $tableName";
		$result = $this->query( $cmd );		
		if ( isset( $result[ 0 ][ $maxColumn ] ) ) {
			return 1 + $result[ 0 ][ $maxColumn ];
		}
		return 1;
	}
	
	/**
	 * Delete a record by its id.
	 *
	 * @param id			the id value.
	 * @param tableName		the name of the table.
	 * @param idFieldName	the name of the id field.
	 * @return				the number of deleted records.
	 */
	function deleteWithId( $id, $tableName, $idFieldName = 'id' ) { // throws
		$cmd = "delete from $tableName where $idFieldName = ?";
		return $this->run( $cmd, array( $id ) );
	}
	
	/**
	 * Count the number of records of a table.
	 *
	 * @param tableName		the name of the table.
	 * @param idFieldName	the name of the id field.
	 * @param whereClause	the where clause.
	 * @param parameters	the parameters for the where clause.
	 * @return				the number of rows.
	 */
	function countRows(
		$tableName,
		$idFieldName = 'id',
		$whereClause = '',
		array $parameters = array()
		) {	// throws
		$countColumn = 'C_O_U_N_T_';
		$cmd = "select count( $idFieldName ) as '$countColumn' from $tableName $whereClause" ;
		$result = $this->query( $cmd, $parameters );
		if ( isset( $result[ 0 ][ $countColumn ] ) ) {
			return $result[ 0 ][ $countColumn ];
		}
		return 0;
	}
	
	/**
	 * Make limit and offset clauses for a SQL statement.<br />
	 * IMPORTANT: Different databases use different SQL dialects. Please see if your database is
	 * supported.<br />
	 *
	 * <h3>Currently supported databases:</h3>
	 * <ul>
	 *	<li>MySQL</li>
	 *	<li>PostgreSQL</li>
	 *	<li>Firebird</li>
	 *	<li>SQLite</li>
	 *	<li>DB2</li>
	 *	<li>MS SQL Server 2008 (just for limit)</li>
	 * </ul>
	 *
	 * @see http://troels.arvin.dk/db/rdbms/
	 * @see http://www.jooq.org/doc/3.0/manual/sql-building/sql-statements/select-statement/limit-clause/
	 * on the support about limit and offset in different relational databases.
	 *
	 * @param limit		the maximum number of records to retrieve.
	 * @param offset	the number of records to ignore (or "jump").
	 * @return			a string with the clauses.
	 */
	function makeLimitOffset( $limit = 0, $offset = 0 ) { // throw
		if ( ! is_integer( $limit ) ) throw new InvalidArgumentException( 'Limit is not a number.' );
		if ( ! is_integer( $offset ) ) throw new InvalidArgumentException( 'Offset is not a number.' );
		$sql = '';
		$drv = $this->driverName();
		// Limit clause
		if ( $limit > 0 ) {
			// MySQL, PostgreSQL, SQLite, HSQLDB, H2
			if (   $this->isMySQL( $drv )
				|| $this->isPostgreSQL( $drv )
				|| $this->isSQLite( $drv )
				) $sql .= " LIMIT $limit ";
			// Firebird
			else if ( $this->isFirebird ) $sql .= " FIRST $limit ";			
			// MS SQL Server 2008+
			else if ( $this->isSQLServer( $drv ) ) $sql .= " TOP $limit ";
			// IBM DB2, ANSI-SQL 2008
			else $sql .= " FETCH FIRST $limit ROWS ONLY ";
		}
		// Offset clause		
		if ( $offset > 0 ) {
			// MySQL, PostgreSQL, SQLite, HSQLDB, H2
			if (   $this->isMySQL( $drv )
				|| $this->isPostgreSQL( $drv ) 
				|| $this->isSQLite( $drv )
				) {
				if ( $limit > 0 ) $sql .= " OFFSET $offset ";
				else $sql .= " LIMIT 9999999999999 OFFSET $offset "; // OFFSET needs a LIMIT
			// Firebird
			} else if ( $this->isFirebird ) $sql .= " SKIP $offset ";
			// IBM DB2, ANSI-SQL 2008
			else $sql .= " OFFSET $offset ROWS ";
		}
		return $sql;
	}
	
	/**
	 * Make a query and return an array of objects.<br />
	 *
	 * How to use it:< br />
	 * <code>
	 * class UserRepositoryInRDB { // User repository in a relational database
	 * 		...
	 *		private function rowToUser( array $row ) {
	 *			// Creates a User object with a login and a password
	 *			return new User( $row[ 'login' ], $row[ 'password' ] );
	 *		}
	 *
	 *		public function allUsers($limit = 0, $offset = 0) { // throw
	 *			$query = 'SELECT * FROM user' . $this->makeLimitOffset( $limit, $offset );
	 *			return $this->pdoWrapper->queryObjects( array( $this, 'rowToUser' ), $query );
	 *		}
	 * }
	 * </code>
	 *
	 * @param recordToObjectCallback	the callback to transform a record into an object.
	 * @param sql						the query to execute.
	 * @param parameters				the query parameters.
	 * @return							an array of objects.
	 */
	function queryObjects( $recordToObjectCallback, $sql, array $parameters = array() ) { // throws
		$objects = array();	
		$ps = $this->execute( $sql, $parameters );
		foreach ( $ps as $row ) {
			$obj = call_user_func( $recordToObjectCallback, $row ); // Transform a row into an object
			array_push( $objects, $obj );
		}
		return $objects;
	}
	
	/**
	 * Return an object with the given id or null if not found.
	 *
	 * @param recordToObjectCallback	the callback to transform a record into an object.
	 * @param id						the id value.
	 * @param tableName					the table name.
	 * @param idFieldName				the name of the id field.
	 * @return							the object with the given id or null if not found.
	 */
	function objectWithId( $recordToObjectCallback, $id, $tableName, $idFieldName = 'id' ) {
		$cmd = "SELECT * FROM $tableName WHERE $idFieldName = ?";
		$params = array( $id );
		$objects = $this->queryObjects( $recordToObjectCallback, $cmd, $params );
		if ( count( $objects ) > 0 ) {
			return $objects[ 0 ];
		}
		return null;
	}
	
	/**
	 * Return all the records as objects.
	 *
	 * @param recordToObjectCallback	the callback to transform a record into an object.
	 * @param tableName					the table name.
	 * @param limit						the maximum number of records to retrieve.
	 * @param offset					the number of records to ignore (or "jump").
	 * @return							an array of objects.
	 */
	function allObjects( $recordToObjectCallback, $tableName, $limit = 0, $offset = 0 ) {
		$cmd = "SELECT * FROM $tableName" . $this->makeLimitOffset( $limit, $offset );
		return $this->queryObjects( $recordToObjectCallback, $cmd );
	}
	
	/**
	 * Run a command with the supplied parameters and return the number of affected rows.
	 * 
	 * @param command		the command to run.
	 * @param parameters	the array of parameters for the command.
	 * @return				the number of affected rows.
	 */
	function run( $command, array $parameters = array() ) { // throws
		$ps = $this->execute( $command, $parameters );
		return $ps->rowCount();
	}

	/**
	 * Run a query with the supplied parameters and return an array of rows.
	 * 
	 * @param query			the query to run.
	 * @param parameters	the array of parameters for the query.
	 * @return				an array of rows.
	 */
	function query( $query, array $parameters = array() ) { // throws
		$ps = $this->execute( $query, $parameters );
		return $ps->fetchAll();
	}

	/**
	 * Execute a command with the supplied parameters and return a PDOStatement object.
	 * 
	 * @param command		the command to execute.
	 * @param parameters	the array of parameters for the command.
	 * @return				a {@code PDOStatement} object.
	 */	
	function execute( $command, array $parameters = array() ) { // throws
		$ps = $this->pdo->prepare( $command );
		if ( ! $ps->execute( $parameters ) ) {
			throw new DatabaseException( 'SQL error: ' . $command );
		}
		return $ps;
	}
	
	// UTIL

	/**
	 * Return the last inserted id.
	 *
	 * @param name	the name of the sequence, if needed. OPTIONAL.
	 * @return 		a string.
	 */
	function lastInsertId( $name = null ) {
		return $this->pdo->lastInsertId( $name );
	}
	
	// TRANSACTION
	
	function inTransaction() {
		return $this->pdo->inTransaction();
	}

	function beginTransaction() {
		if ( ! $this->inTransaction() ) {
			$this->pdo->beginTransaction();
		}
	}
	
	function commit() {
		if ( $this->inTransaction() ) {
			$this->pdo->commit();
		}		
	}
	
	function rollBack() {
		if ( $this->inTransaction() ) {
			$this->pdo->rollBack();
		}
	}
	
	// ATTRIBUTES
	
	function driverName() {
		return $this->pdo->getAttribute( constant( 'PDO::ATTR_DRIVER_NAME' ) );
	}
	
	private function isDriverName( $expected, $value = '' ) {
		$driverName = empty( $value ) ? $this->driverName() : $value;
		return $expected === $driverName;
		
	}
	
	function isMySQL( $driverName = '' ) {
		return $this->isDriverName( 'mysql', $driverName );
	}
	
	function isFirebird( $driverName = '' ) {
		return $this->isDriverName( 'firebird', $driverName );
	}	
		
	function isPostgreSQL( $driverName = '' ) {
		return $this->isDriverName( 'pgsql', $driverName );
	}
	
	function isSQLite( $driverName = '' ) {
		return $this->isDriverName( 'sqlite', $driverName )
			|| $this->isDriverName( 'sqlite2', $driverName );
	}
	
	function isSQLServer( $driverName = '' ) {
		return $this->isDriverName( 'sqlsrv', $driverName );
	}
	
	function isOracle( $driverName = '' ) {
		return $this->isDriverName( 'oci', $driverName );
	}
	
	function isDB2( $driverName = '' ) {
		return $this->isDriverName( 'ibm', $driverName );
	}	
	
	function isODBC( $driverName = '' ) {
		return $this->isDriverName( 'odbc', $driverName );
	}	
}
?>