<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="FacebookShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][Show]" id="FacebookShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionFacebook_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionFacebook_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][facebook]" value="<?php echo $module_data[$lang['code']]['Positions']['facebook']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookURL_<?php echo $lang['code']; ?>"><?php echo $facebook_pageurl; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookURL_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][URL]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['URL']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookHeight_<?php echo $lang['code']; ?>"><?php echo $facebook_widgetheight; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookHeight_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][Height]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['Height']; ?>" />
            </div>
    	</td>
    </tr>
</table>