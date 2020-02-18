<?php 

namespace Core;
    
class Db
{
    private static $_instance = null;
    private $_pdo;
    private $_sth;
    private $_res;
    private $_rowCount;
    private $_lastInsertId;
    private $_error = false;

    private function __construct()
    {
        try {
            $this->_pdo = new \PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASSWORD);
            $this->_pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
    }

    function query($req, array $array = [])
    {
        $this->_sth = $this->_pdo->prepare($req);
        // foreach($array as $key => $value){
        //     self::$_sth->bindParam($key, $value);
        // }
        try {
            $this->_pdo->beginTransaction();
            if ($this->_sth->execute($array)) {
                $this->_lastInsertId = $this->_pdo->lastInsertId();
                $this->_pdo->commit();
                $this->_res = $this->_sth->fetchAll();
                $this->_rowCount = $this->_sth->rowCount();
            }
        } catch (\PDOException $e) {
            $this->_pdo->rollBack();
            $this->_error = true;
            echo "Error !!!!" . $e->getMessage();
        }
    }

    function select($tableName, array $where = [])
    {
        $wherereq = "";
        $where2 = [];
        if (count($where) == 0) {
            $insert = "SELECT * FROM " . $tableName;
        } else{
            foreach ($where as $key => $value) {
                $wherereq .= $key . "= :" . $key;
                $where2[":$key"] = $value;
            }
            $insert = "SELECT * FROM " . $tableName . " where " . $wherereq;
            
        }
        // echo $insert;

        $this->query($insert, $where2);
        
        return $this;
    }

    function insert($tableName, $array)
    {
        $insertToQuery = [];
        foreach ($array as $key => $value) {
            $insertToQuery[':' . $key] = $value;
        }
        $insert = "INSERT INTO " . $tableName . " (" . implode(',', array_keys($array)) . ") " . "values(" . implode(',', array_keys($insertToQuery)) . ")";
        echo $this->getRowCount();
        $this->query($insert, $insertToQuery);
        return $this->getLastInsertId();
    }

    function update($tableName, $array, $where)
    {
        $arrayVal = [];
        $wherereq = [];
        $update = [];

        foreach ($array as $key => $value) {
            $arrayVal[':' . $key] = $value;
            $update[] = $key . "= :" . $key;
        }

        foreach ($where as $key => $value) {
            $wherereq[] = $key . "=" . $value;
        }

        $insert = "UPDATE " . $tableName . " SET " . implode(' , ', $update) . " WHERE " . implode(' AND ', $wherereq);
        $this->query($insert, $arrayVal);
    }

    function delete($tableName, $where)
    {
        $wherereq = "";
        $whereval = [];

        foreach ($where as $key => $value) {
            $wherereq .= $key . "=" . $value;
            $whereval[$value] = $key;
        }

        $insert = "DELETE FROM " . $tableName . " where " . $wherereq;
        $this->query($insert, $whereval);
    }

    function getResult()
    {
        return $this->_res;
    }

    function getError()
    {
        return $this->_error;
    }

    function getRowCount()
    {
        return $this->_rowCount;
    }

    function getLastInsertId()
    {
        return $this->_lastInsertId;
    }

    public static function getInstance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}