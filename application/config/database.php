<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificats in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/
$active_group = 'master_base';
$query_builder = TRUE;

$db['default']['dsn'] = '';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_unicode_ci';
$db['default']['swap_pre'] = '';
$db['default']['encrypt'] = FALSE;
$db['default']['compress'] = FALSE;
$db['default']['stricton'] = FALSE;
$db['default']['failover'] = array();
$db['default']['save_queries'] = TRUE;
$db['default']['swap_pre'] = '';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['pconnect'] = FALSE;
$db['default']['dbprefix'] = '';
$db['default']['db_debug'] = FALSE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';

$db['master_base'] = array(
	'hostname' => (ENVIRONMENT == 'development' ? '192.168.0.186' : '10.4.8.14:13306'),
	'username' => 'pg_user',
	'password' => 'pg_pcode',
	'database' => 'tm_base'
);

$db['slave_base'] = array(
	'hostname' => (ENVIRONMENT == 'development' ? '192.168.0.186' : '10.4.8.14:13306'),
	'username' => 'pg_user',
	'password' => 'pg_pcode',
	'database' => 'tm_base'
);

$db['master_log'] = array(
	'hostname' => (ENVIRONMENT == 'development' ? '192.168.0.186' : '10.4.8.14:13306'),
	'username' => 'pg_user',
	'password' => 'pg_pcode',
	'database' => 'tm_log'
);

$db['slave_log'] = array(
	'hostname' => (ENVIRONMENT == 'development' ? '192.168.0.186' : '10.4.8.14:13306'),
	'username' => 'pg_user',
	'password' => 'pg_pcode',
	'database' => 'tm_log'
);

$CI = get_instance();
$dbArray = $CI->config->item('GAMEDB');

for ( $i = 0; $i < count( $dbArray ); $i++ )
{
	$db['master_game_'.$i] = array(
		'hostname' => $dbArray[$i]['master_hostname'],
		'username' => $dbArray[$i]['username'],
		'password' => $dbArray[$i]['password'],
		'database' => $dbArray[$i]['database']
	);

	$db['slave_game_'.$i] = array(
		'hostname' => $dbArray[$i]['slave_hostname'],
		'username' => $dbArray[$i]['username'],
		'password' => $dbArray[$i]['password'],
		'database' => $dbArray[$i]['database']
	);

	if ( !file_exists('/var/www/html/application/models/Model_Master_Game_'.$i.'.php') )
	{
		$content = file_get_contents('/var/www/html/application/models/Model_Master_Game_0.php');
		$content = str_replace('class Model_Master_Game_0 extends MY_Model', 'class Model_Master_Game_'.$i.' extends MY_Model', $content);
		$content = str_replace('$this->db = $this->load->database(\'master_game_0\', TRUE);', '$this->db = $this->load->database(\'master_game_'.$i.'\', TRUE);', $content);

		file_put_contents('/var/www/html/application/models/Model_Master_Game_'.$i.'.php', $content);
	}
}

foreach( $db as $dbkey => $dbval )
{
	foreach( $db['default'] as $key => $val )
	{
		$db[$dbkey][$key] = $val;
	}
}
