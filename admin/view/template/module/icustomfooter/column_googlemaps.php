<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="GoogleMapsShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Show]" id="GoogleMapsShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['GoogleMaps']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['GoogleMaps']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionGoogleMaps_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionGoogleMaps_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][googlemaps]" value="<?php echo $module_data[$lang['code']]['Positions']['googlemaps']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="GoogleMapsTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="GoogleMapsTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['GoogleMaps']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="GoogleMapsAPIKey_<?php echo $lang['code']; ?>"><?php echo $maps_apikey; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="GoogleMapsAPIKey_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][APIKey]" value="<?php echo !empty($module_data[$lang['code']]['Widgets']['GoogleMaps']['APIKey']) ? $module_data[$lang['code']]['Widgets']['GoogleMaps']['APIKey'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="GoogleMapsLongitude_<?php echo $lang['code']; ?>"><?php echo $maps_longlat; ?></label>
        </td>
        <td>
        	<div class="col-xs-8">
            	<div id="GoogleMapsPoints_<?php echo $lang['code']; ?>">
                <?php if(isset($module_data[$lang['code']]['Widgets']['GoogleMaps']['Points'])) { ?>
                    <?php foreach ($module_data[$lang['code']]['Widgets']['GoogleMaps']['Points'] as $key => $point) { ?>
                        <div style="margin-top:5px;" class="row" data-id=<?php echo $key; ?>>
                            <div class="col-xs-3">
                                <input type="text" class="GoogleMapsName_<?php echo $lang['code']; ?> semiField form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Points][<?php echo $key; ?>][Name]" placeholder="Enter Point Name" value="<?php echo $point['Name']; ?>" />
                            </div>
                        	<div class="col-xs-3">
                            	<input type="text" class="GoogleMapsLongitude_<?php echo $lang['code']; ?> semiField form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Points][<?php echo $key; ?>][Longitude]" placeholder="Enter Point Longitude" value="<?php echo $point['Longitude']; ?>" />
                            </div>
                            <div class="col-xs-3">
                            	<input type="text" class="GoogleMapsLatitude_<?php echo $lang['code']; ?> semiField form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Points][<?php echo $key; ?>][Latitude]" placeholder="Enter Point Latitude" value="<?php echo $point['Latitude']; ?>" />
                     		</div>
                            <div class="col-xs-3">
                                <a data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger removeButton"><i class="fa fa-minus-circle"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                     <?php } ?>
                </div>
                <div class="row pointsbuttons">
                    <div class="col-xs-1">
                        <a onclick="addFilterRow();" data-toggle="tooltip" title="<?php echo $button_add_module; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a>
                    </div>
                    <div class="col-xs-3">
                        <button class="btn btn-info GoogleMapsPreviewButton" onclick="displayMaps('<?php echo $lang['code']; ?>')" id="GoogleMapsPreviewButton_<?php echo $lang['code']; ?>"><?php echo $preview; ?></button>
                    </div>
                </div>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top">
        	<label for="GoogleMapsPreviewDiv_<?php echo $lang['code']; ?>"><?php echo $maps_preview; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<div class="GoogleMapsPreviewDiv" data-longitude-selector="#GoogleMapsLongitude_<?php echo $lang['code']; ?>" data-latitude-selector="#GoogleMapsLatitude_<?php echo $lang['code']; ?>" data-apikey-selector="#GoogleMapsAPIKey_<?php echo $lang['code']; ?>" id="GoogleMapsPreviewDiv_<?php echo $lang['code']; ?>"></div>
            </div>
    	</td>
    </tr>
</table>
<script type="text/javascript"><!--

$('.removeButton').click( function(){
    $(this).parent().parent().remove();
});

function addFilterRow() {
    var selectedLang = $('ul.columnSettings .active').data('langcode');
    var filter_row =  $('#GoogleMapsPoints_'+selectedLang+' .row:last').data("id")+1;
    if(isNaN(filter_row)) filter_row = 0;


    html  = '<div style="margin-top:5px;" class="row" data-id="'+filter_row+'">';
        html  += '<div class="col-xs-3">';   
            html += '<input type="text" class="GoogleMapsName_'+selectedLang+' semiField form-control" name="<?php echo $moduleName; ?>['+ selectedLang +'][Widgets][GoogleMaps][Points]['+ filter_row +'][Name]"  placeholder="Enter Point Name" value=""/>';
        html += '</div>';
        html  += '<div class="col-xs-3">';   
            html += '<input type="text" class="GoogleMapsLongitude_'+selectedLang+' semiField form-control" name="<?php echo $moduleName; ?>['+ selectedLang +'][Widgets][GoogleMaps][Points]['+ filter_row +'][Longitude]"  placeholder="Enter Point Longitude" value=""/>';
        html += '</div>';
        html += '<div class="col-xs-3">';
            html += '<input type="text" class="GoogleMapsLatitude_'+selectedLang+' semiField form-control" name="<?php echo $moduleName; ?>['+ selectedLang +'][Widgets][GoogleMaps][Points]['+ filter_row +'][Latitude]"  placeholder="Enter Point Latitude" value="" />';
        html += '</div>';
        html += '<div class="col-xs-3">';
            html += '<a onclick="$(this).parent().parent().remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>';
        html += '</div>';
    html += '</div>';
   
    $('#GoogleMapsPoints_'+selectedLang).append(html);
}
//--></script>