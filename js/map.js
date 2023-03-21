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
        strokeColor: "#f28482",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#f28482",
        fillOpacity: 0.35,
        map,
        center: coords,
        radius: Math.sqrt(2714856) * 2,
    });
}


// Render maps on page load.
$(document).ready(function(){
   
    var coords = { lat: Number($('#map-lat').text()), lng: Number($('#map-lng').text())}
    initCircle(coords);
   
});

})(jQuery);