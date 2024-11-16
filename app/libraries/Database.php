<?php

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;

    private $dbh;
    private $statement;
    private $error;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

        );

        //instantiate PDO

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //prepared statement
    public function query($sql)
    {
        $this->statement = $this->dbh->prepare($sql);
    }

    //bind parameters
    public function bind($param, $value, $type = NULL)
    {
        if (is_null($type)) {
            switch (true) {
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

        $this->statement->bindValue($param, $value, $type);
    }

    //execute the prepared statement
    public function execute()
    {
        return $this->statement->execute();
    }

    //get multiple records as the result
    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    //get single record as the result
    public function single()
    {
        $this->execute();
        return $this->statement->fetch();
    }

    //get row count

    public function rowCount()
    {
        return $this->statement->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function commit()
    {
        return $this->dbh->commit();
    }

    public function rollBack()
    {
        return $this->dbh->rollBack();
    }
}
