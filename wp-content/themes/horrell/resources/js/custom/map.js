(function ($) {

    /**
     * initMap
     *
     * Renders a Google Map onto the selected jQuery element
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @return  object The map instance.
     * 
     *  cspell: ignore horrell
     */
    function initMap($el) {

        // Find marker elements within map.
        var $markers = $el.find('.marker');

        // Create generic map.
        var mapArgs = {
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };
        var map = new google.maps.Map($el[0], mapArgs);

        // Add markers.
        map.markers = [];
        $markers.each(function () {
            initMarker($(this), map);
        });

        // Center map based on markers.
        centerMap(map);

        // Return map instance.
        return map;
    }

    /**
     * initMarker
     *
     * Creates a marker for the given jQuery element and map.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @param   object The map instance.
     * @return  object The marker instance.
     */
    function initMarker($marker, map) {

        // Get position from marker.
        var lat = $marker.data('lat');
        var lng = $marker.data('lng');
        var latLng = {
            lat: parseFloat(lat),
            lng: parseFloat(lng)
        };

        // Create marker instance.
        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: horrell_obj.map_details.icon,
            html: { content: horrell_obj.map_details.html }
        });

        // Append to reference for later use.
        map.markers.push(marker);
        google.maps.event.addListener(marker, 'click', function () {
            window.open("https://goo.gl/maps/" + horrell_obj.map_details.gs_company_location_id, '_blank');
        });

    }

    /**
     * centerMap
     *
     * Centers the map showing all markers in view.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   object The map instance.
     * @return  void
     */
    function centerMap(map) {

        // Create map boundaries from all map markers.
        var bounds = new google.maps.LatLngBounds();
        map.markers.forEach(function (marker) {
            bounds.extend({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
        });

        // Case: Single marker.
        if (map.markers.length == 1) {
            map.setCenter(bounds.getCenter());

            // Case: Multiple markers.
        } else {
            map.fitBounds(bounds);
        }
    }

    // Render maps on page load.
    $(document).ready(function () {
        $('.acf-map').each(function () {
            var map = initMap($(this));
        });
    });

})(jQuery);