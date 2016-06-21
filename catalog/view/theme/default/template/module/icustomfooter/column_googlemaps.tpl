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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $idata[$langcode]['Widgets']['GoogleMaps']['APIKey'] ?>&sensor=false" type="text/javascript"></script>
    <script type="text/javascript">
        function initialize_icustomfooter_googlemap() {
            var myLatlng = new google.maps.LatLng(<?php echo $idata[$langcode]['Widgets']['GoogleMaps']['Longitude']?>, <?php echo $idata[$langcode]['Widgets']['GoogleMaps']['Latitude']?>)
            var mapOptions = {
              center: myLatlng,
              zoom: 12,
              mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("iCustomFooterGoogleMap"), mapOptions);
                
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: ""
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize_icustomfooter_googlemap);
    </script>
<?php endif; ?>
