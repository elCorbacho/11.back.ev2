<?php

class Model1 {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function create($data) {
        // Code to insert data into the database
    }

    public function read($id) {
        // Code to retrieve data from the database by ID
    }

    public function update($id, $data) {
        // Code to update data in the database by ID
    }

    public function delete($id) {
        // Code to delete data from the database by ID
    }

    public function getAll() {
        // Code to retrieve all records from the database
    }
}