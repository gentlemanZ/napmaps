<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 50%;
        width: 100%;
      }
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

    </style>
    <title>napmaps showcase</title>
    <style>
      #target {
        width: 345px;
      }
    </style>
  </head>
  <body>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <script>
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.
var marker;
function initAutocomplete() {
  var myLatLng ={lat: 42.350148, lng:  -71.107600};
  var WarrenLatLng = {lat:42.349391,  lng: -71.104134};
  var GSULatLng = {lat:42.351111,  lng: -71.108923};
  var CFALatLng = {lat:42.351280, lng:-71.113835};
  var LabLatLng = {lat:42.349937,lng: -71.106910};
  var CASLatLng = {lat:42.349925, lng:-71.101325};
  var map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  

  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
  var image = './';
  marker1 = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: myLatLng,
    //icon: image+'school-2.png'
  });
  attachSecretMessage(marker1, 'This is Boston University, We are doing a prototype presentation');

  markerWarren = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: WarrenLatLng,
    //icon: image+'school-2.png'
  });
  attachSecretMessage(markerWarren, 'This is warrentower, We are doing a prototype presentation');

  markerGSU = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: GSULatLng,
    //icon: image+'school-2.png'
  });
  attachSecretMessage(markerGSU, 'This is GSU, We are doing a prototype presentation');

  markerCFA = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: CFALatLng,
    //icon: image+'school-2.png'
  });
  attachSecretMessage(markerCFA, 'This is CFA, We are doing a prototype presentation');
 
  markerLab = new google.maps.Marker({
    map: map,
    position: LabLatLng,
    draggable: true,
    animation: google.maps.Animation.DROP,
    //icon: image+'school-2.png'
  });
  attachSecretMessage(markerLab, 'This is Ourlab, We are doing a prototype presentation');

  markerCAS = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position:  CASLatLng,
    //icon: image+'school-2.png'
  });
  attachSecretMessage(markerCAS, 'This is CAS, We are doing a prototype presentation');
  
  // [START region_getplaces]
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
    var mylat = map.getCenter().lat(); 
    var mylng = map.getCenter().lng();
    document.getElementById("demo").innerHTML = "Your lat cordinate is:"+mylat+"<br>Your lng cordinate is:"+mylng;
  });
  

  
  // [END region_getplaces]
}

function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

function attachSecretMessage(marker, secretMessage) {
  var infowindow = new google.maps.InfoWindow({
    content: secretMessage
  });

  marker.addListener('mouseover', function() {
    infowindow.open(marker.get('map'), marker);
  });
  marker.addListener('mouseout', function() {
    infowindow.close();
  });

}


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAWoyeopE7iUADMB-OBMJao8fNstnnwvjM&libraries=places&callback=initAutocomplete"
         async defer>
         </script>
    <p id="demo"></p>
  </body>
</html>