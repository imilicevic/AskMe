<?php
abstract class Model{
  protected $dbh;
  protected $stmt;

  public function __construct()
  {
    $this->dbh = new PDO("pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME, DB_USER, DB_PASS);
  }

  public function query($query){
    $this->stmt = $this->dbh->prepare($query);
  }

  // Binds the prep statement - function for WHERE clause and other bindings
  public function bind($param, $value, $type = null){
    if(is_null($type)){
      switch(true){
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->stmt->bindValue($param, $value, $type);
  }

  public function execute(){
    return $this->stmt->execute();
  }

  public function resultSet(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function singleResult(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function lastInsertId(){
    return $this->dbh->lastInsertId();
  }



  public static function parse_timestamp($timestamp, $format = 'd.m.Y. \a\t H:m')
  {
    date_default_timezone_set('Europe/Amsterdam');
    $formatted_timestamp = date($format, strtotime($timestamp));
    return $formatted_timestamp;
  }
}
