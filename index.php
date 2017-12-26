<!DOCTYPE html>
<html>
<head>
	<title>TT - Blood</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./style.css" />
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <style>
      /* Always set the map height explicitly to define the size of the div
      * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .btn-success:focus{box-shadow: none;} .btn:focus{box-shadow: none;}
    </style>
  </head>
  <body>
    <div id="map"></div>
    <div class="centering">
      <div class="col-6 mx-auto">
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control" id="address" placeholder="Location">
            <button class="input-group-addon btn btn-success" id="submit">
              <i class="fa fa-search fa-fw"></i>
            </button>
          </div>
        </div>
        
        <br />
        <div class="list-groups list-group-horizontal">
          <button class="list-group-item list-group-item-action text-center">O+</button>
          <button class="list-group-item list-group-item-action text-center">O-</button>
          <button class="list-group-item list-group-item-action text-center">A+</button>
          <button class="list-group-item list-group-item-action text-center">A-</button>
          <button class="list-group-item list-group-item-action text-center">B-</button>
          <button class="list-group-item list-group-item-action text-center">B+</button>
          <button class="list-group-item list-group-item-action text-center">AB+</button>
          <button class="list-group-item list-group-item-action text-center">AB-</button>
        </div>
      </div>
    </div>
    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            loadHospitals(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
      function loadHospitals(loca) {
        var locationforHopitals = loca;

        map = new google.maps.Map(document.getElementById('map'), {
          center: locationforHopitals,
          zoom: 13
        });

        infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: locationforHopitals,
          radius: 3500,
          type: ['hospital']
        }, callback);
      }

      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }

      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name);
          infowindow.open(map, this);
        });
      }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtUwHNbLUw5cTlSV1R2xBR6Vjk2VlLhlE&libraries=places&callback=initMap"></script>
  </body>
  </html>