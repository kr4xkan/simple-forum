<?php

function db() {
    static $conn;

    $servername = "db:3306";
    $username = "root";
    $password = "admin";

    if ($conn === NULL) {
        $conn = new mysqli($servername, $username, $password, "db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    return $conn;
}
