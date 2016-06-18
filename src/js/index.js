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
}
