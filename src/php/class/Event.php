<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class Event {

    /* $info = {
     *  title [string]
     *  description [string]
     *  visibility [bool]
     *  lat [decimal]
     *  long [decimal]
     */
    public static function constructEvent($info) {
        $title = $info['title'];
        $descr = $info['description'];
        $vis = $info['visibility'];
        $lat = $info['lat'];
        $long = $info['long'];

        $stmt = null;
        $GLOBALS['DB']->prepStatement($stmt, "INSERT INTO event (name, description, visibility) Output.id VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $descr, $vis);
        $stmt->bind_result($result);
        $result = $stmt->execute();

        if ($result) {
            $result = $stmt->fetch();
            var_dump($result);
        }

        $stmt->close();

/*
        $stmt = null;
        $GLOBALS['DB']->prepStatement($stmt, "INSERT INTO event_location (id, lat, long) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $id, $lag, $long);
        $stmt->execute();
        $stmt->close();
        */
    }
}

 ?>
