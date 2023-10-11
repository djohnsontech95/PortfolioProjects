<!DOCTYPE html>
<html>
<head>
    <title>Map View | AptiStudy</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDExOGbvM044CGR411HzN82eixCzsoqFDQ"></script>
</head>
<body>


<!-- div element to hold the map on your HTML page: -->
<div id="map" style="height: 1100px;"></div>


<!-- Use JavaScript to initialize the map and add markers, if needed. Here is an example of how to initialize a map centered on a specific location: -->
<script>
    function initMap() {
        var location = {lat: 39.16832412920662, lng: -86.5230968264925}; //bloomington   
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: location
        });
        var marker1 = new google.maps.Marker({ // wells 
            position: {lat: 39.171116822232534, lng: -86.5167966940991},
            map: map
        })
        google.maps.event.addListener(marker1, "click", () => {
            var infowindow = new google.maps.InfoWindow();
            infowindow.setContent(`<div id="content"><div id="siteNotice"></div><h2 id="firstHeading" class="firstHeading">Herman B. Wells Library</h2><div id="bodyContent"><p>1320 E 10th St, Bloomington, IN 47405</p></div></div>`);
            infowindow.open(map, marker1);
        });

        var marker2 = new google.maps.Marker({ // luddy hall 
            position: {lat: 39.172712, lng: -86.523221},
            map: map
        })
        google.maps.event.addListener(marker2, "click", () => {
            var infowindow = new google.maps.InfoWindow();
            infowindow.setContent(`<div id="content"><div id="siteNotice"></div><h2 id="firstHeading" class="firstHeading">Luddy Hall</h2><div id="bodyContent"><p>700 N Woodlawn Ave, Bloomington, IN 47408</p></div></div>`);
            infowindow.open(map, marker2);
        });

        var marker3 = new google.maps.Marker({ // IMU
            position: {lat: 39.167616, lng: -86.523173},
            map: map
        })
        google.maps.event.addListener(marker3, "click", () => {
            var infowindow = new google.maps.InfoWindow();
            infowindow.setContent(`<div id="content"><div id="siteNotice"></div><h2 id="firstHeading" class="firstHeading">Indiana Memorial Union</h2><div id="bodyContent"><p>900 E 7th St, Bloomington, IN 47405</p></div></div>`);
            infowindow.open(map, marker3);
        });

        var marker4 = new google.maps.Marker({ // hodge hall
            position: {lat: 39.17210666098869, lng: -86.51857709127313},
            map: map
        })
        google.maps.event.addListener(marker4, "click", () => {
            var infowindow = new google.maps.InfoWindow();
            infowindow.setContent(`<div id="content"><div id="siteNotice"></div><h2 id="firstHeading" class="firstHeading">Hodge Hall</h2><div id="bodyContent"><p>1309 E 10th St, Bloomington, IN 47405</p></div></div>`);
            infowindow.open(map, marker4);
        });

        var marker5 = new google.maps.Marker({ // global and international studies building
            position: {lat: 39.17057003137311, lng: -86.51793558845547},
            map: map
        })
        google.maps.event.addListener(marker5, "click", () => {
            var infowindow = new google.maps.InfoWindow();
            infowindow.setContent(`<div id="content"><div id="siteNotice"></div><h2 id="firstHeading" class="firstHeading">Global and International Studies Building</h2><div id="bodyContent"><p>355 Eagleson Ave, Bloomington, IN 47405</p></div></div>`);
            infowindow.open(map, marker5);
        });
    }
</script>

<!-- Call the initMap function when the page loads: -->
<body onload="initMap()">

<!-- adding markers on the  -->

</body>
</html>