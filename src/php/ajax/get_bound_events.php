<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

/* RETURNS
 * array {
 *      events: string of event cards (html)
 *      markers: array of marker coordinates
 * }
 */

$lat_min = $_POST['lat_min'];
$lat_max = $_POST['lat_max'];
$long_min = $_POST['long_min'];
$long_max = $_POST['long_max'];


if ($stmt = $GLOBALS['DB']->prepStatement(
    "SELECT id, latitude, longitude FROM event_location WHERE (latitude BETWEEN ? AND ?) AND (longitude BETWEEN ? AND ?)"
    )) {
    $stmt->bind_param("dddd", $lat_min, $lat_max, $long_min, $long_max);
    $result = $stmt->execute();

    if ($result) {
        $ret_events = array();
        foreach ($GLOBALS['DB']->getQueryResults($stmt) as $arr) {
            $temp_event = new Event($arr['id']);
            array_push($ret_events, array(
                "id" => $arr['id'],
                "lat" => $arr['latitude'],
                "lng" => $arr['longitude'],
                "markerInfo" => htmlspecialchars($temp_event->getMarkerInfo())
            ));
        }
        echo json_encode($ret_events);
    }

    $stmt->close();
}


?>
