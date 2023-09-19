<div>
    <input type="text" id="location-input" placeholder="Chọn vị trí trên bản đồ">
    <div id="map" style="height: 500px;"></div>
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places&callback=initMap" async defer></script>
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 0, lng: 0},
            zoom: 15
        });

        var input = document.getElementById('location-input');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            var latitudeInput = document.getElementById('latitude');
            var longitudeInput = document.getElementById('longitude');
            latitudeInput.value = place.geometry.location.lat();
            longitudeInput.value = place.geometry.location.lng();

            map.setCenter(place.geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });
        });
    }
</script>
