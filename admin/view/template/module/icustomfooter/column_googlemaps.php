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
        	<div class="col-xs-4">
            	<div class="row">
                	<div class="col-xs-6">
                    	<input type="text" class="GoogleMapsLongitude semiField form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Longitude]" value="<?php echo $module_data[$lang['code']]['Widgets']['GoogleMaps']['Longitude']; ?>" id="GoogleMapsLongitude_<?php echo $lang['code']; ?>" />
                    </div>
                    <div class="col-xs-6">
                    	<input type="text" class="GoogleMapsLatitude semiField form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][GoogleMaps][Latitude]" value="<?php echo $module_data[$lang['code']]['Widgets']['GoogleMaps']['Latitude']; ?>" id="GoogleMapsLatitude_<?php echo $lang['code']; ?>" />
             		</div>
                </div>
                <button class="btn btn-info GoogleMapsPreviewButton" id="GoogleMapsPreviewButton_<?php echo $lang['code']; ?>"><?php echo $preview; ?></button>
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