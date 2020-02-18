<?php

namespace App\Models;

use Core\Model;

class User extends Model
{

    public function __construct(){
        $this->_table = 'users';

    }

    function select()
    {
      $where = ["id_user" => $this->id];
      $dbh = parent::getDb();
      $result = $dbh->select($this->_table, $where)->getResult();
      return $result;
    }

    function selectAll()
    {
      $dbh = parent::getDb();
      $result = $dbh->select($this->_table)->getResult();
      return $result;
    }

    // public function selectAll()
    // {
    //     self::getDb()->select($this->_table);
    //     return self::getDb()->getResult();
    // }
}