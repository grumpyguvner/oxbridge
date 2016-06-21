<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="YouTubeShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][YouTube][Show]" class="form-control" id="YouTubeShow_<?php echo $lang['code']; ?>">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['YouTube']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['YouTube']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionYouTube_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionYouTube_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][youtube]" value="<?php echo $module_data[$lang['code']]['Positions']['youtube']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="YouTubeTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="YouTubeTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][YouTube][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['YouTube']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="YouTubeURL_<?php echo $lang['code']; ?>"><?php echo $youtube_url; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="YouTubeURL_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][YouTube][URL]" value="<?php echo $module_data[$lang['code']]['Widgets']['YouTube']['URL']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="YouTubeWidth_<?php echo $lang['code']; ?>"><?php echo $youtube_width; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="YouTubeWidth_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][YouTube][Width]" value="<?php echo $module_data[$lang['code']]['Widgets']['YouTube']['Width']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="YouTubeHeight_<?php echo $lang['code']; ?>"><?php echo $youtube_height; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="YouTubeHeight_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][YouTube][Height]" value="<?php echo $module_data[$lang['code']]['Widgets']['YouTube']['Height']; ?>" />
            </div>
    	</td>
    </tr>
</table>