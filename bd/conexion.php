<?php
class DataBase
{
  public static function connect()
  {
//      $serverName = "10.10.11.21\SQLEXPRESS";
//      $connectionInfo = array( "Database"=>"DBHANSON", "UID"=>"userName", "PWD"=>"password");
//      $db = sqlsrv_connect( $serverName, $connectionInfo);
//      return $db;


    $db = new mysqli("localhost", "root","","todoagro");
    $db->query("SET NAMES 'utf8'");
    date_default_timezone_set('America/Guayaquil');
    return $db;
  }

}
?>