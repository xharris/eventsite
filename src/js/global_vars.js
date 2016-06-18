// firebase
var fire_DB;

// google maps
var map;

$(function(){
    // init firebase
    fire_DB = firebase.database();

});

var initialLocation;
var newyork;
var browserSupportFlag =  new Boolean();

function initMap() {
    newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);

    // init google maps
    map = new google.maps.Map($("#gmap")[0], {
        center: newyork,
        scrollwheel: false,
        zoom: 8
    });

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            map.setCenter(initialLocation);
            map.setZoom(18);
        });
    }

}
