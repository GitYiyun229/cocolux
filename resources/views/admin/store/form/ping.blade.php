<div>
    <div id="map" style="height: 500px;"></div>
    <input type="hidden" name="latitude" id="latitude" value="{{ isset($latitude)?$latitude:0 }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ isset($longitude)?$longitude:0 }}">
</div>

<script src="https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Apwotc2pglOqY_bLannByqBGVxp6nHjH6ZGhPsTBOyfdyHbaJZnV87ozNmjKBdlF&mkt=vi-VN" async defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var latitude = parseFloat(document.getElementById('latitude').value);
        var longitude = parseFloat(document.getElementById('longitude').value);

        var map = new PingMap('#map', {
            center: [latitude, longitude],
            zoom: 12
        });

        var marker = new PingMarker(map, [latitude, longitude], {
            draggable: true,
            onDragEnd: function(event) {
                var latitudeInput = document.getElementById('latitude');
                var longitudeInput = document.getElementById('longitude');
                var latLng = event.target.getLatLng();
                latitudeInput.value = latLng.lat;
                longitudeInput.value = latLng.lng;
            }
        });
    });
</script>
