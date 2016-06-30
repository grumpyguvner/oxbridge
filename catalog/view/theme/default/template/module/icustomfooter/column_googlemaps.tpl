<?php if ($idata[$langcode]['Widgets']['GoogleMaps']['Show'] == 'true'): ?>
    <li class="iGoogleMaps iWidget grid_footer_3">
        <div class="iWidgetWrapper">
            <h2><?php echo $idata[$langcode]['Widgets']['GoogleMaps']['Title']; ?></h2>
            <div class="belowTitleContainer">
                <?php if(!empty($idata[$langcode]['Widgets']['GoogleMaps']['APIKey'])): ?>
                    <div id="iCustomFooterGoogleMap"></div>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $idata[$langcode]['Widgets']['GoogleMaps']['APIKey'] ?>" type="text/javascript"></script>
    <?php if(isset($idata[$langcode]['Widgets']['GoogleMaps']['Points'])){ ?>
    <script type="text/javascript">
         var points = [];
         <?php  foreach ($idata[$langcode]['Widgets']['GoogleMaps']['Points'] as $value) { ?>
             points.push(<?php echo json_encode($value); ?>); 
          <?php  }  ?>

        function initialize_icustomfooter_googlemap() {
            var centerP = new google.maps.LatLng(points[0]['Longitude'], points[0]['Latitude']);
            
            var mapOptions = {
                center: centerP,
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            
            var map = new google.maps.Map(document.getElementById('iCustomFooterGoogleMap'), mapOptions);

            var marker, i;

    for (var i in points){
        if (points.hasOwnProperty(i)) {
                  marker = new google.maps.Marker({
                    position: new google.maps.LatLng(points[i]['Longitude'], points[i]['Latitude']),
                    map: map
                  });


                  (function(marker, i) {
                        // add click event
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow = new google.maps.InfoWindow({
                                content: points[i]['Name']
                            });
                            infowindow.open(map, marker);
                        });
                    })(marker, i);

                }

            }
        }
        google.maps.event.addDomListener(window, 'load', initialize_icustomfooter_googlemap);
    </script>
    <?php } ?>
<?php endif; ?>
