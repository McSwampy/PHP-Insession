<?php
/*
To use this class simply incude it and declare the object.

Example:
include_once 'PHP-Insession.php';
$ClassInSession = new Insession();
$ClassInSession->sql_server = "mysqlserverhost.com";
$ClassInSession->sql_username = "MyHostGaveMeADumbUsername";
$ClassInSession->sql_password = "ThisPasswordIsLame";
$ClassInSession->sql_database = "Default_Database_Name";

Note:
The default sql info for this class is as following:
Server: localhost
Username: root
Password: <Blank>
Database: <Blank>

If a database has been pushed into the class via the connect, MySQL connection will connect to that database.
If no database was defined, the class will connect to the server, but you have to connect to a database later.
Example:

$ClassInSession->connect();
$result = $ClassInSession->query("SHOW DATABASES");
$data = mysqli_fetch_array($result, MYSQLI_NUM);
$database = $data[0];
$ClassInSession->selectDb($database);
*/
class Insession{
  var $sql_server = "localhost";
  var $sql_username = "root";
  var $sql_password = "";
  var $sql_database = "";
  var $conn;

  function connect($database = ""){
    if($database == ""){
      $conn = mysqli_connect($this->sql_server, $this->sql_username, $this->sql_password);
      if(mysqli_connect_errno() > 0){
        return mysqli_connect_error();
      }else{
        $this->conn = $conn;
        return $conn;
      }
    }else{
      $conn = mysqli_connect($this->sql_server, $this->sql_username, $this->sql_password, $database);
      if(mysqli_connect_errno() > 0){
        return mysqli_connect_error();
      }else{
        $this->conn = $conn;
        return $conn;
      }
    }
  }
  function query($sql){
    if(!$this->conn){
      $this->connect();
    }else{
      $r = mysqli_query($this->conn, $sql);
      if(mysqli_errno($this->conn) > 0){
        return mysqli_error($this->conn);
      }
      return $r;
    }
  }
  function selectDb($database){
    $this->sql_database = $database;
    mysqli_select_db($this->conn, $database);
    return true;
  }
  function getDatabases(){
    $databases = array();
    $r = $this->query("SHOW DATABASES");
    while($row = mysqli_fetch_array($r, MYSQLI_NUM)){
      $databases[] = $row[0];
    }
    return $databases;
  }
  function getColumns($table){
    $columns = array();
    $r = $this->query("SHOW COLUMNS FROM `$table`");
    while($row = mysqli_fetch_array($r, MYSQLI_NUM)){
      $columns[] = $row[0];
    }
    return $columns;
  }






  function displayError($error){
    $errorToDisplay = '
    <div id="PHPInsessionError" style="width: 100%; position: fixed; top: 20%; padding: 10px; border: 2px solid black; background-color: #222; color: white;">
      <button style="position: absolute; right: 0px; background-color: white; color: black; border: 1px solid white;" onclick="closePHPInsessionError(this)">X</button>
      <h3 style="padding: 0; margin: 0;">PHP Insession has experienced the following errors</h3>
      <p>$error<p>
    </div>
    ';
    if($this->error == true){
      echo $errorToDisplay;
    }else{
      $errorToDisplay .= '
      <script>
      function closePHPInsessionError(el){
        el.parentNode.style.display = "none";
      }
      </script>';
      $this->error = true;
      echo $errorToDisplay;
    }

  }
}
?>
