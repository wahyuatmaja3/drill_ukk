<?php

class Database
{
    // Property untuk koneksi
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "drillukk_coba_pembayaranspp";

    // Db handler untuk koneksi ke database
    private $dbh;
    // Stmt untuk menginisialisasi query dan mengembalikan data
    private $stmt;

    public function __construct()
    {
        // Buat Data Source Name untuk koneksi
        $dsn = "mysql:hostname=$this->host;dbname=$this->dbname;";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true
        ];

        // Koneksi ke database
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    }

    //Inisialisasi Statement
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // Binding data
    public function bind($param, $value, $type = null)
    {
        // Check type null, jika true maka ubah type menjadi type data $value
        if (is_null($type)) {
            // Ubah $type
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
                    break;
            }
        }

        // Binding Query
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    // Mengembalikan data lebih dari satu row
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengembalikan sebuah data (single)
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
