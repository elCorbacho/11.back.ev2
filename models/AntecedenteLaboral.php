<?php
class Model3 {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function create($data) {
        // Code to insert data into the database
    }

    public function read($id) {
        // Code to retrieve data from the database
    }

    public function update($id, $data) {
        // Code to update data in the database
    }

    public function delete($id) {
        // Code to delete data from the database
    }
}
?>