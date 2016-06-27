$(function(){
    /*
    // test event
    var test = new xhhEvent({
        title : "Free bean's day!",
        description : "Come and get free beans",
        visibility : "public",
        score : 1,
        time_start : Date.now(),
        time_end : Date.now()
    });
    addEventToList(test);
    */
    $(".datepicker").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        defaultDate: new Date().toDateInputValue()
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
        long: placing_event_marker.getPosition().lng()
    };

    if (valid) {
        placing_event_marker.setDraggable(false);
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
            console.log(result)
        }
    });
}
