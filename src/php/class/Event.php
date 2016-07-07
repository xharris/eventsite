<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

class Event {
    private $valid = true;
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

            if ($stmt = $GLOBALS['DB']->prepStatement("SELECT `start`,`end` FROM event_time WHERE id=?")) {
                $stmt->bind_param("i", $id);
                $stmt->execute();

                $result = $stmt->execute();

                if ($result) {
                    foreach ($GLOBALS['DB']->getQueryResults($stmt) as $arr) {
                        foreach ($arr as $index => $value) {
                            $this->values[$index] = $value;
                        }
                    }
                }

                $stmt->close();
            }

        } else {
            $this->valid = false;
            $error = 'Event creation failed (event #' . $id . ')';
            throw new Exception($error);
            return false;
        }
    }

    public function getTitle() {
        if ($this->valid) {
            return $this->values["title"];
        }
    }

    public function getUUID() {
        if ($this->valid) {
            return $this->values['uuid'];
        }
    }

    public function getStartDateTime() {
        if ($this->valid) {
            return $this->values['start'];
        }
    }

    public function getEndDateTime() {
        if ($this->valid) {
            return $this->values['end'];
        }
    }

    public function getMarkerInfo() {
        $time_start = formatDateTime($this->getStartDateTime());
        $time_end = formatDateTime($this->getEndDateTime());



        $html_str = "".
        "<div class='event-marker-info'>".
            "<a class='title'>" . $this->getTitle() . "</a>".
            "<div class='times'>".
                "<p class='start'>" . $time_start . "</p>".
                "<p class='end'>" . $time_end . "</p>".
            "</div>".
        "</div>";

        return $html_str;
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
