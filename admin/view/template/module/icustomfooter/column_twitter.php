<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="TwitterShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Twitter][Show]" id="TwitterShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Twitter']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Twitter']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionTwitter_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionTwitter_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][twitter]" value="<?php echo $module_data[$lang['code']]['Positions']['twitter']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="TwitterTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="TwitterTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Twitter][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['Twitter']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="TwitterProfile_<?php echo $lang['code']; ?>"><?php echo $twitter_profile; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="TwitterProfile_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Twitter][Profile]" value="<?php echo $module_data[$lang['code']]['Widgets']['Twitter']['Profile']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="TwitterWidgetID_<?php echo $lang['code']; ?>"><?php echo $twitter_widget_id; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="TwitterWidgetID_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Twitter][WidgetID]" value="<?php echo !empty($module_data[$lang['code']]['Widgets']['Twitter']['WidgetID']) ? $module_data[$lang['code']]['Widgets']['Twitter']['WidgetID'] : ''; ?>" />
            </div>
    	</td>
    </tr>
</table>