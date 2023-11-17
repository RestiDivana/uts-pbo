<?php

class Data
{
    private $conn;
    private $table_name = "mahasiswa";

    public $id;
    public $nama;
    public $nim;
    public $foto;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET nama=?, nim=?, foto=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sds", $this->nama, $this->nim, $this->foto);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read()
    {
        $query = "SELECT id, nama, nim, foto FROM " . $this->table_name;

        $result = $this->conn->query($query);

        return $result;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . " SET nama=?, nim=?, foto=? WHERE id=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("sdsi", $this->nama, $this->nim, $this->foto, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
