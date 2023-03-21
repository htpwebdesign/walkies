<style type="text/css">
.acf-map {
    width: 100%;
    height: 400px;
    border: #ccc solid 1px;
    margin: 20px 0;
}

#polygon-map,
#circle-map {
  height: 300px;
}

html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}

// Fixes potential theme css conflict.
.acf-map img {
   max-width: inherit !important;
}
</style>
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdcgV7xSlibF71okf0mzwkhfuH756GBOw&callback=Function.prototype"></script>
<script  type="text/javascript">
(function( $ ) {

/**
 * initPolygon
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */
function initCircle(coords) {    
    
    // Create gerenic map.
    var mapArgs = {
        zoom: 12,
        center: coords,
        mapTypeId: "terrain",    
    };
    var map = new google.maps.Map( $("#circle-map")[0], mapArgs );
  
    
    // Construct the circle.
    new google.maps.Circle({
      strokeColor: "#FF0000",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "#FF0000",
      fillOpacity: 0.35,
      map,
      center: coords,
      radius: Math.sqrt(2714856) * 2,
    });
}

/**
 * initPolygon
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */
function initPolygon( ) {

    // Create gerenic map.
    var mapArgs = {
        zoom: 5,
        center: { lat: 24.886, lng: -70.268 },
        mapTypeId: "terrain",    
    };
    var map = new google.maps.Map( $("#polygon-map")[0], mapArgs );

    // Define the LatLng coordinates for the polygon's path.
    const triangleCoords = [
      { lat: 25.774, lng: -80.19 },
      { lat: 18.466, lng: -66.118 },
      { lat: 32.321, lng: -64.757 },
      { lat: 25.774, lng: -80.19 },
    ];
  
    // Construct the polygon.
    const bermudaTriangle = new google.maps.Polygon({
      paths: triangleCoords,
      strokeColor: "#FF0000",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "#FF0000",
      fillOpacity: 0.35,
    });

    bermudaTriangle.setMap(map);

    // Return map instance.
    return map;
}


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
 */
function initMap( $el ) {

    // Find marker elements within map.
    var $markers = $el.find('.marker');

    // Create gerenic map.
    var mapArgs = {
        zoom        : $el.data('zoom') || 16,
        mapTypeId   : google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map( $el[0], mapArgs );
    
    // Add markers.
    map.markers = [];
    $markers.each(function(){
        initMarker( $(this), map );
    });

    // Center map based on markers.
    centerMap( map );

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
function initMarker( $marker, map ) {

    // Get position from marker.
    var lat = $marker.data('lat');
    var lng = $marker.data('lng');
    var latLng = {
        lat: parseFloat( lat ),
        lng: parseFloat( lng )
    };

    // Create marker instance.
    var marker = new google.maps.Marker({
        position : latLng,
        map: map
    });

    // Append to reference for later use.
    map.markers.push( marker );

    // If marker contains HTML, add it to an infoWindow.
    if( $marker.html() ){

        // Create info window.
        var infowindow = new google.maps.InfoWindow({
            content: $marker.html()
        });

        // Show info window when marker is clicked.
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open( map, marker );
        });
    }
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
function centerMap( map ) {

    // Create map boundaries from all map markers.
    var bounds = new google.maps.LatLngBounds();
    map.markers.forEach(function( marker ){
        bounds.extend({
            lat: marker.position.lat(),
            lng: marker.position.lng()
        });
    });

    // Case: Single marker.
    if( map.markers.length == 1 ){
        map.setCenter( bounds.getCenter() );

    // Case: Multiple markers.
    } else{
        map.fitBounds( bounds );
    }


}

async function geocode(map){
    // Test
    var address = encodeURIComponent(map);
    var url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=AIzaSyAkmD9wgJS733c_IWb_tCV5BTmQexK_jo0`;

    var response = await fetch(url);
    var resp = await response.json();


    // var resp = json_decode(resp_json, true);

    if(resp['status']=='OK'){
        var latVal = resp['results'][0]['geometry']['location']['lat'] ? resp['results'][0]['geometry']['location']['lat'] : ""
        var longVal = resp['results'][0]['geometry']['location']['lng'] ? resp['results'][0]['geometry']['location']['lng'] : ""

        if (latVal && longVal){
            return {lat: parseFloat(latVal), lng: parseFloat(longVal)};
        } else {
            return false;
        }
    } else {
        return false;
    }
}



// Render maps on page load.
$(document).ready(async function(){
    // if( $args['lo'] ) {
    //   echo $args['lo'];
    // }

    // $('.acf-map').each(function(){
    //     var map = initMap( $(this) );
        
    // });    
    
    // initPolygon();
    var geoTest = await geocode('555 Seymour St, Vancouver, BC V6B 3H6');
    initCircle(geoTest);
    console.log(geoTest);
});

})(jQuery);
</script>