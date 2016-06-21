Array.prototype.indexOf = function(obj, start) {
     for (var i = (start || 0), j = this.length; i < j; i++) {
         if (this[i] === obj) { return i; }
     }
     return -1;
}

var includedMapsAPIs = [];
var initialize_map = function(previewDiv, longitude, latitude) {
	var myLatlng = new google.maps.LatLng(longitude, latitude);
	
	var mapOptions = {
		center: myLatlng,
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	var map = new google.maps.Map(previewDiv, mapOptions);
	
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: ""
	});
}

var displayMaps = function() {
	$('.GoogleMapsPreviewDiv').each(function(index, previewDiv) {
		var apikey = $($(previewDiv).attr('data-apikey-selector')).val();
		var longitude = parseFloat($($(previewDiv).attr('data-longitude-selector')).val().replace(/,/g, '.'));
		var latitude = parseFloat($($(previewDiv).attr('data-latitude-selector')).val().replace(/,/g, '.'));
		
		if (apikey == '') return;
		
		if (includedMapsAPIs.indexOf(apikey) == -1) {
			includedMapsAPIs.push(apikey);
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = 'https://maps.googleapis.com/maps/api/js?key=' + apikey + '&sensor=false&callback=displayMaps';
			document.body.appendChild(script);
		} else {
			if (document.readyState === "complete") initialize_map(previewDiv, longitude, latitude);
			else $(window).load(function() { initialize_map(previewDiv, longitude, latitude); });
		}
	});
}


$(document).ready(function() {
	$('.dropdown-toggle').dropdown();
	
	displayMaps();
	
	$('.GoogleMapsPreviewButton').click(function(e) {
		e.preventDefault();
		displayMaps();
		return false;
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