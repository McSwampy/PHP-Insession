This readme file will explain how to use this PHP class
First thing is to include the PHP file in the script that you are writing.

Example:
include_once 'PHP-Insession.php';

Now you can create an object with the class included above like this:
$class = new Insession();
$class->connect();

This is now the main control for the PHP-Insession OOP.

PHP-Insession is set up with the following details to access a MySQL Server
Server: localhost
Username: root
Password: <Blank>
Database: <None>

These variable can be changed by using the following:
$class->sql_server = "sqlserverlocation.net";
$class->sql_username = "sqlusername";
$class->sql_password = "sqlpassword";
$class->sql_database = "editthisdatabase";

NOTE:
If the database is not present in the $class->connect($database = "") function, the connection is just to the server.
A database will have to be selected later using $class->selectDb("Database_Name_Here");
This will run the $class->query("SQL QUery") function inside the class.
Make sure that you have been connected to the MySQL database when using this command.

This class file will include most MySQL queries and returned data will be in arrays

FUNCTIONS

connect($database)	Connects to MySQL server. If database specified, selects database on connection.
query($query)		Sends the input query to the MySQL database used in the connection above.
selectDb($database)	Selects a different database.
getDatabases()		Returns an array of database names.
getColumns($table)	Returns an array of column names in specified table.
