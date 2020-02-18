<?php

namespace Core;

use Core\Db;

class Model
{
  protected static $_db;
  protected $id;
  protected $_table;

  protected function __construct()
  {

  }

  public static function getDb()
  {
    if (!self::$_db) {
      self::$_db = Db::getInstance();
    }
    return self::$_db;
  }

  function select()
    {
      $where = ["id" => $this->id];
      $dbh = self::getDb();
      $result = $dbh->select($this->_table, $where)->getResult();
      return $result;
    }

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }
}
