$(function(){
    // pad numbers to 2 digits
    function twoDigits(d) {
        if(0 <= d && d < 10) return "0" + d.toString();
        if(-10 < d && d < 0) return "-0" + (-1*d).toString();
        return d.toString();
    }

    /**
     * …and then create the method to output the date string as desired.
     * Some people hate using prototypes this way, but if you are going
     * to apply this to more than one Date object, having it as a prototype
     * makes sense.
     **/
    Date.prototype.toMysqlFormat = function() {
        var date = this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate()) + " " + twoDigits(this.getHours()) + ":" + twoDigits(this.getMinutes()) + ":" + twoDigits(this.getSeconds());
        console.log(date);
        return date;
    };

    $(".datepicker").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        defaultDate: new Date().toDateInputValue(),
        clear: ''
    });

    $(".datepicker").val(new Date().format("d mmmm, yyyy"));

    $(".timepicker").pickatime({
        //selectMonths: true, // Creates a dropdown to control month
    });

})

function btn_addEvent() {
    placing_event = true;
    $(".place-event-helpertext").removeClass("hidden");
}

/*
var ev_template = getTemplateElement(".event");
ev_template.find(".title").val("boogers");
ev_template.appendTo(".sidebar > .event-list");
*/

function confirmEventMarker() {
    placing_event = false;
    $(".place-event-helpertext").addClass("hidden");
    if (undefined != placing_event_marker) {
        // show new event form
        $(".form-new-event").removeClass("hidden");
    }
}

function submitEvent() {
    var valid = true;
    // get inputs
    var in_title = $("#in-title").val();
    var in_description = $("#in-description").val();
    var in_visibility = $('input[name="in-visibility"]:checked').val();

    var new_event = {
        title: in_title,
        description: in_description,
        visibility: in_visibility,
        lat: placing_event_marker.getPosition().lat(),
        long: placing_event_marker.getPosition().lng(),
        start: new Date($("#in-start-date").val() + " " + $("#in-start-time").val()).toMysqlFormat(),
        end: new Date($("#in-end-date").val() + " " + $("#in-end-time").val()).toMysqlFormat()
    };

    if (valid) {
        placing_event_marker.setMap(null);
        placing_event_marker = null;
        $(".form-new-event").addClass("hidden");
        clearInputs('.form-new-event');
        $(".form-new-event #radio1").prop("checked", true);

        addEvent(new_event);
    }
}

function addEvent(new_event) {
    $.ajax({
        type: "POST",
        url: "php/ajax/new_event.php",
        data: new_event,
        success: function(result) {
            loadEventsBounds(map.getBounds());
        }
    });
}

// checks if id of event is in list
function eventPrinted(event) {
    return !printed_event_ids.includes(event.id)
}

// load map markers and event list for events in a certain area
// bounds [maps.LatLngBounds] - area to load
function loadEventsBounds(bounds) {
    var b_NE = bounds.getNorthEast();//.getPosition();
    var b_SW = bounds.getSouthWest();//.getPosition();
    var bound_values = {
        lat_min: b_SW.lat(),
        lat_max: b_NE.lat(),
        long_min: b_SW.lng(),
        long_max: b_NE.lng()
    }
    $.ajax({
        type: "POST",
        url: "php/ajax/get_bound_events.php",
        data: bound_values,
        success: function(result) {
            // organize results into array
            var events = [];
            JSON.parse(result).forEach(function(event) {
                events.push({
                    id: event.id,
                    lat: event.lat,
                    lng: event.lng,
                    markerInfo: event.markerInfo})
            })
            // remove events that were already added
            events = events.filter(eventPrinted)

            // display new events
            events.forEach(function(event) {
                eventList_addEvent(event.id);
                map_addMarker({lat: event.lat, lng: event.lng}, unescape(event.markerInfo));
            })
        }
    })
}

// removes all events from homepage list
function eventList_clear() {
    $(".event-list").html("");
    printed_event_ids = [];
    map_clearEventMarkers();
}

// adds an event to the main homepage list
function eventList_addEvent(id) {
    printed_event_ids.push(id);
    $.ajax({
        type: "POST",
        url: "php/ajax/print_event.php",
        data: {
            id: id
        },
        success: function(result) {
            $(".event-list").append(result);
        }
    })
}

// adds a marker with COORDS and popup description INFO
// coords = {lat, lng}
function map_addMarker(coords, info) {
    info = $('<div/>').html(info).text() || "";

    var mark = new google.maps.Marker({
       position: new google.maps.LatLng(coords.lat, coords.lng),
       map: map,
       draggable: false
    });
    mark.addListener('click', function() {
        info_window.open(map, mark);
        info_window.setContent(info)
    });
    event_markers.push(mark);
}
