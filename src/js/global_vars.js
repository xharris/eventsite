// firebase
var fire_DB;

// google maps
var map;

var placing_event = false;
var placing_event_marker;

$(function(){
    // init firebase
    fire_DB = firebase.database();

});

function getTemplateElement(element_sel) {
    return $('#template').find(element_sel).clone();
}

function clearInputs(element_sel) {
    jQuery(element_sel).find(':input').each(function() {
    switch(this.type) {
        case 'password':
        case 'text':
        case 'textarea':
        case 'file':
        case 'select-one':
        case 'select-multiple':
            jQuery(this).val('');
            break;
        case 'checkbox':
        case 'radio':
            this.checked = false;
    }
  });
}

var initialLocation;
var newyork;
var browserSupportFlag =  new Boolean();

function initMap() {
    newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);

    // init google maps
    map = new google.maps.Map($("#gmap")[0], {
        center: newyork,
        scrollwheel: true,
        zoom: 8
    });

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            map.setCenter(initialLocation);
            map.setZoom(18);
        });
    }

    initAutocomplete();

    map.addListener('click', function(event) {
        if (placing_event) {
            placeMarker(event.latLng);
        }
    });
}

function placeMarker(location) {
    // remove old marker
    if (undefined != placing_event_marker) {
        placing_event_marker.setMap(null);
    }
    placing_event_marker = new google.maps.Marker({
        position: location,
        map: map,
        draggable: true
    });
}

function initAutocomplete() {
  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers.
    markers.forEach(function(marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}
