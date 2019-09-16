var map;
var markers = [];
var infoWindow;
var locationSelect;

function initMap() {
    var defaultcoord = {lat: 45.777222, lng: 3.087025};
    map = new google.maps.Map(document.getElementById('map'), {
        center: defaultcoord,
        zoom: 6,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
    });
    infoWindow = new google.maps.InfoWindow();
}

$(document).ready(function() {

    var $ = jQuery;

    //si clique sur le button ou si appuie sur entrer, on exécute la fonction searchLocations
    searchButton = document.getElementById("searchButton").onclick = searchLocations;
    document.getElementById("formMap").onsubmit = searchLocations;

    locationSelect = document.getElementById("locationSelect");
    locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
            google.maps.event.trigger(markers[markerNum], 'click');
        }
    };

    /**
     * On vérifie que l'adresse saisie dans le champ de recherche est correct. Sinon renvoie une erreur ou on charge tous les magasins
     */
    function searchLocations() {
        var address = document.getElementById("addressInput").value;

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({address: address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                searchLocationsNear(results[0].geometry.location);
            } else {
                var xmlUrl = "//"+window.location.hostname+"/sites/cestdeuxeuros/files/locations/locations.xml";

                map.markers = map.markers || []
                downloadUrl(xmlUrl, function(data) {
                    var xml = parseXml(data);
                    var markerNodes = xml.documentElement.getElementsByTagName("marker");
                    var bounds = new google.maps.LatLngBounds();
                    for (var i = 0; i < markerNodes.length; i++) {
                        var id = markerNodes[i].getAttribute("id");
                        var name = markerNodes[i].getAttribute("name");
                        var address = markerNodes[i].getAttribute("address")+'<br/>'+markerNodes[i].getAttribute("city");
                        var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                        var latlng = new google.maps.LatLng(
                            parseFloat(markerNodes[i].getAttribute("lat")),
                            parseFloat(markerNodes[i].getAttribute("lng")));

                        createOption(name, distance, i);
                        createMarker(latlng, name, address);
                        bounds.extend(latlng);

                        mapShops(id, name, markerNodes[i].getAttribute("address"), markerNodes[i].getAttribute("city"), markerNodes[i].getAttribute("postal"), markerNodes[i].getAttribute("phone"), markerNodes[i].getAttribute("hours1"));
                    }
                    map.fitBounds(bounds);
                    locationSelect.style.visibility = "visible";
                    locationSelect.onchange = function() {
                        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
                        google.maps.event.trigger(markers[markerNum], 'click');
                    };
                });
                alert('Veuillez saisir une adresse valide');
            }
        });

        return (false);
    }

    function searchLocationsNear(center) {
        clearLocations();
        var radius = document.getElementById("radiusSelect").value;

        var searchUrl = "//"+window.location.hostname+"/all-shops/" + center.lat() + '/' + center.lng() + '/' + radius;

       downloadUrl(searchUrl, testAudrey);

       return(false);
    }

    function clearLocations() {
        infoWindow.close();
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers.length = 0;

        locationSelect.innerHTML = "";
        var option = document.createElement("option");
        option.value = "none";
        option.innerHTML = "Tous les magasins :";
        locationSelect.appendChild(option);
        $("#shopsList").html("");
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request.responseText, request.status);
            }

        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}

    function testAudrey(data) {
        if (data === "<markers></markers>") {
            downloadUrl("/sites/cestdeuxeuros/files/locations/locations.xml",testAudrey);
        } else {
            var xml = parseXml(data);

            var markerNodes = xml.documentElement.getElementsByTagName("marker");
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markerNodes.length; i++) {
                var id = markerNodes[i].getAttribute("id");
                var name = markerNodes[i].getAttribute("name");
                var address = markerNodes[i].getAttribute("address")+'<br/>'+markerNodes[i].getAttribute("city");
                var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                var latlng = new google.maps.LatLng(
                    parseFloat(markerNodes[i].getAttribute("lat")),
                    parseFloat(markerNodes[i].getAttribute("lng")));

                createOption(name, distance, i);
                createMarker(latlng, name, address);
                bounds.extend(latlng);

                mapShops(id, name, markerNodes[i].getAttribute("address"), markerNodes[i]
                    .getAttribute("city"), markerNodes[i].getAttribute("postal"), markerNodes[i]
                    .getAttribute("phone"), markerNodes[i].getAttribute("hours1"));
            }
            map.fitBounds(bounds);
            locationSelect.style.visibility = "visible";
            locationSelect.onchange = function() {
                var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
                google.maps.event.trigger(markers[markerNum], 'click');
            };
        }
    }

    function parseXml(str) {
        if (window.ActiveXObject) {
            var doc = new ActiveXObject('Microsoft.XMLDOM');
            doc.loadXML(str);
            return doc;
        } else if (window.DOMParser) {
            return (new DOMParser).parseFromString(str, 'text/xml');
        }
    }
    function createOption(name, distance, num) {
        var option = document.createElement("option");
        option.value = num;
        option.innerHTML = name;
        locationSelect.appendChild(option);
    }
    function createMarker(latlng, name, address) {
        var html = "<b>" + name + "</b> <br/>" + address;
        var marker = new google.maps.Marker({
            map: map,
            position: latlng
        });
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
        markers.push(marker);
    }
    function mapShops(id, name, address, city, postal, phone, hours) {

        if (phone.length !== 0) {
            var phoneSet = "<p class='tel'><i class='fas fa-mobile-alt'></i>" + phone + "</p>";
        } else {
            var phoneSet = '';
        }

        $("#shopsList").append("" +
            "<div class='row'>" +
                "<div class='col-12 col-sm-6'>" +
                    "<h3>C'est deux euros :</h3>" +
                    "<span class='adresse'><i class='fas fa-map-marker-alt'></i>" + address + "</span>" +
                    "<span class='ville'><i class='far fa-map'></i>" + postal + " " + city + " </span>" +
                    phoneSet +
                "</div>" +
                "<div class='col-12 col-sm-6'>" +
                    "<h3 class='horaires'>Horaires :</h3>" +
                    "<p>" + hours.replace("/","<br/>")+"</p>" +
                "</div>" +
            "</div>" +
            "<hr />"
        );
    }
});
