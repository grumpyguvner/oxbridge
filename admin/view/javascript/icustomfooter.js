Array.prototype.indexOf = function(obj, start) {
     for (var i = (start || 0), j = this.length; i < j; i++) {
         if (this[i] === obj) { return i; }
     }
     return -1;
}

var includedMapsAPIs = [];
function initialize_map (previewDiv, points) {
	
	var centerP = new google.maps.LatLng(points[0]['longitude'], points[0]['latitude']);
	
	var mapOptions = {
		center: centerP,
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(document.getElementById(previewDiv), mapOptions);

	var marker, i;
	for (i = 0; i < points.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(points[i]['longitude'], points[i]['latitude']),
        map: map
      });


      (function(marker, i) {
	        // add click event
	        google.maps.event.addListener(marker, 'click', function() {
	            infowindow = new google.maps.InfoWindow({
	                content: points[i]['name']
	            });
	            infowindow.open(map, marker);
	        });
	    })(marker, i);

  	}
}

function displayMaps (languange_id){
	var apikey = $('#GoogleMapsAPIKey_'+languange_id).val();
	var previewDiv =  'GoogleMapsPreviewDiv_'+languange_id;
	var points = [];
	$('#GoogleMapsPoints_'+languange_id+' .row').each(function(index) {
		points[index] = {name:$(this).find('.GoogleMapsName_'+languange_id).val(),longitude:$(this).find('.GoogleMapsLongitude_'+languange_id).val(), latitude:$(this).find('.GoogleMapsLatitude_'+languange_id).val() };
	});
		if (apikey == '') return;
		if (includedMapsAPIs.indexOf(apikey) == -1) {
			includedMapsAPIs.push(apikey);
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = 'https://maps.googleapis.com/maps/api/js?key=' + apikey;
			document.body.appendChild(script);
			setTimeout(function(){ displayMaps(languange_id); }, 1000);
		} else {
			if (document.readyState === "complete") initialize_map(previewDiv, points);
			else $(window).load(function() { initialize_map(previewDiv, points); });
		}
		
		

}


$(document).ready(function() {
	$('.dropdown-toggle').dropdown();
	
	//displayMaps();

	$('.GoogleMapsPreviewButton').on('click', function(e) {
		e.preventDefault();
	});

	
	$('.paymentIconsBrowse').click(function(e) {
		$($(this).attr('data-click-selector')).attr('data-browse-text-selector', $(this).attr('data-browse-text-selector'));
		$('.PaymentIcons').trigger('change');
		$($(this).attr('data-click-selector')).trigger('click');
	});
	
	$('.PaymentIcons').change(function() {
		$($(this).attr('data-browse-text-selector')).text($(this).val().substr($(this).val().lastIndexOf("/") + 1).substr($(this).val().lastIndexOf("\\") + 1));
	});
	
	$('.paymentIconsUploadButton').click(function(e) {
		e.preventDefault();
		$($(this).attr('data-name-source-selector')).removeClass('error');
		if ($($(this).attr('data-name-selector')).val() == '') {
			$($(this).attr('data-name-source-selector')).addClass('error');
			return false;
		}
		$('#PaymentIconName').val($($(this).attr('data-name-selector')).val());
		$('#form_payment_icons').submit();
	});
	
	$('.store_tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$('.store_name').text($(this).text());
		$('input[name="store"]').val($('.store_tabs a').index(this));
		$($(this).attr('data-target').substr(0, $(this).attr('data-target').indexOf(',', 0)) + ' .sub_tabs li:first a').trigger('click');
	});
	
	$('.store_tabs li:eq(' + parseInt($('input[name="store"]').first().val()) + ') a').trigger('click');
	
	$('.sub_tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$('input[name="tab"]').val($('.sub_tabs a').index(this));
		$($(this).attr('data-target') + ' .column_tabs li:first a').trigger('click');
	});
	
	$('.sub_tabs li:eq(' + parseInt($('input[name="tab"]').first().val()) + ') a').trigger('click');
	
	$('.column_tabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$('.column_tabs a').each(function() {
			if ($($(this).attr('data-target')).is(':visible') || !$($(this).attr('data-target')).hasClass('active')) {
				$(this).children('i').removeClass('icon-white');
			}
		});
		$(this).children('i').addClass('icon-white');
		$('input[name="subtab"]').val($('.column_tabs a').index(this));
	});
	$('.column_tabs li:eq(' + parseInt($('input[name="subtab"]').first().val()) + ') a').trigger('click');
});