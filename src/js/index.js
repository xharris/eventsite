$(function(){
    /*
    // authenticate user
    var provider = new firebase.auth.GoogleAuthProvider();
    firebase.auth().signInWithPopup(provider).then(function(result) {
        // This gives you a Google Access Token. You can use it to access the Google API.
        var token = result.credential.accessToken;
        // The signed-in user info.
        var user = result.user;
        // ...
    }).catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        // The email of the user's account used.
        var email = error.email;
        // The firebase.auth.AuthCredential type that was used.
        var credential = error.credential;
        // ...
    });
    */
    var test = new xhhEvent({
        title : "Free bean's day!",
        description : "Come and get free beans",
        visibility : "public",
        score : 1,
        time_start : Date.now(),
        time_end : Date.now()
    });
    addEventToList(test);
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

    var new_event = new xhhEvent({
        title: in_title,
        description: in_description,
        visibility: in_visibility,
        marker: placing_event_marker
    });

    if (valid) {
        placing_event_marker.setDraggable(false);
        $(".form-new-event").addClass("hidden");
        clearInputs('.form-new-event');
        $(".form-new-event #radio1").prop("checked", true)
        addEventToList(new_event);
    }
}

function addEventToList(new_event) {
    var ev_element = getTemplateElement(".event");

    // fill in info
    ev_element.find(".title").html(new_event.title);
    ev_element.find(".score").html(new_event.score);
    ev_element.find(".time").html(new_event.getStartStr());

    // add the event to the list
    $(".sidebar > .event-list").append(ev_element);
}
