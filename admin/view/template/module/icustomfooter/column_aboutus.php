<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="AboutUsShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][AboutUs][Show]" id="AboutUsShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['AboutUs']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['AboutUs']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionAboutus_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionAboutus_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][aboutus]" value="<?php echo $module_data[$lang['code']]['Positions']['aboutus']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="AboutUsTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="AboutUsTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][AboutUs][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['AboutUs']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top">
        	<label for="AboutUsText_<?php echo $lang['code']; ?>"><?php echo $aboutus_text; ?></label>
        </td>
        <td>
        	<div class="col-xs-12">
            	<textarea id="AboutUsText_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][AboutUs][Text]"><?php echo $module_data[$lang['code']]['Widgets']['AboutUs']['Text']; ?></textarea>
            </div>
    	</td>
    </tr>
</table>
<script type="text/javascript"><!--
	$('#AboutUsText_<?php echo $lang['code']; ?>').summernote({
		height: 300
	});
//--></script>