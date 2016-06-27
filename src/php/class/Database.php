<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class Database {
    public function Database($host, $username, $password, $name) {
        $this->sql = new mysqli($host, $username, $password, $name);
        if ($this->sql->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->sql->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }

    public function prepStatement(&$stmt, $query) {
        if (!isset($stmt) || $stmt === null) {
            $stmt = mysqli_stmt_init($this->sql);
            mysqli_stmt_prepare($stmt, $query);
        }
    }
}

 ?>
