<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class Event {
    private $values = array();

    public function Event($id) {
        if ($stmt = $GLOBALS['DB']->prepStatement("SELECT * FROM event WHERE id=?")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->execute();

            $this->values = array();

            if ($result) {
                foreach ($GLOBALS['DB']->getQueryResults($stmt) as $arr) {
                    foreach ($arr as $index => $value) {
                        $this->values[$index] = $value;
                    }
                }
            }

            $stmt->close();
        } else {
            echo "Invalid Event ($id)";
            return false;
        }
    }

    public function getTitle() {
        return $this->values["title"];
    }

    /* $info = {
     *  title [string]
     *  description [string]
     *  visibility [bool]
     *  lat [decimal]
     *  long [decimal]
     */
    public static function newEvent($info) {
        $title = $info['title'];
        $descr = $info['description'];
        $vis = $info['visibility'];
        $lat = $info['lat'];
        $long = $info['long'];
        $start = $info['start'];
        $end = $info['end'];

        $event_id = -1;
        $uuid = $GLOBALS['DB']->generateUUID("event");
        echo $uuid;

        if ($stmt = $GLOBALS['DB']->prepStatement("INSERT INTO event (uuid,title,description,visibility) VALUES (?,?,?,?)")) {
            $stmt->bind_param("ssss", $uuid, $title, $descr, $vis);
            $stmt->execute();

            $event_id = $GLOBALS['DB']->sql->insert_id;

            $stmt->close();
        }

        // successfully created new event
        if ($event_id > -1) {
            // location
            if ($stmt = $GLOBALS['DB']->prepStatement("INSERT INTO event_location (id,latitude,longitude) VALUES (?,?,?)")) {
                $stmt->bind_param("idd", $event_id, $lat, $long);
                $stmt->execute();
                $stmt->close();
            }
            // start/end time
            if ($stmt = $GLOBALS['DB']->prepStatement("INSERT INTO event_time (`id`,`start`,`end`) VALUES (?,?,?)")) {
                $stmt->bind_param("iss", $event_id, $start, $end);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    public static function getAllEvents() {
        $ret_events = array();
        if ($stmt = $GLOBALS['DB']->prepStatement("SELECT id FROM event")) {
            $result = $stmt->execute();

            if ($result) {
                foreach ($GLOBALS['DB']->getQueryResults($stmt) as $arr) {
                    array_push($ret_events, $arr['id']);
                }
            }

            $stmt->close();
        }
        return $ret_events;
    }
}

 ?>
