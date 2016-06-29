<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class Database {
    public function Database($host, $username, $password, $name) {
        $this->sql = new mysqli($host, $username, $password, $name);
        if ($this->sql->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->sql->connect_errno . ") " . $this->mysqli->connect_error;
        }
    }

    public function prepStatement($query) {
        return $this->sql->prepare($query);
    }

    public function getQueryResults($object) {
        $resultArray = array();
        if (is_a($object, 'mysqli_result')) {
            // result object - fetch each result and put into array
            while ($arr = mysqli_fetch_assoc($object)) {
                $resultArray[] = $arr;
            }
        } else if (is_a($object, 'mysqli_stmt')) {
            // prepared statement - determine fields in result, bind to result, then fetch each row
            // Setup parameters array
            $params = array();
            $funcResults = array();
            $params[0] = $object;
            foreach (mysqli_fetch_fields(mysqli_stmt_result_metadata($object)) as $field) {
                $funcResults[$field->name] = null;
                $params[$field->name] = &$funcResults[$field->name];
            }
            call_user_func_array("mysqli_stmt_bind_result", $params);
            mysqli_free_result(mysqli_stmt_result_metadata($object));

            // Fetch each row
            while (mysqli_stmt_fetch($object)) {
                $rowArray = array();
                foreach ($funcResults as $key => $value) {
                    $rowArray[$key] = $params[$key];
                }
                $resultArray[] = $rowArray;
            }
        }
        return $resultArray;
    }

    public function generateUUID($table, $column="uuid") {
        do {
            $randString = randomString();
            if ($stmt = $this->prepStatement("SELECT id FROM $table WHERE $column = ?")) {
                $stmt->bind_param("s", $randString);
                $stmt->execute();

                $used = ($stmt->num_rows() > 0);

                $stmt->close();
            }
        } while ($used);

        return $randString;
    }
}

 ?>
