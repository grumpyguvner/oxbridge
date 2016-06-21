<table class="table">
	<tr>
    	<td class="col-xs-2"><label for="Custom<?php echo $i; ?>Show_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label></td>
        <td>
        	<div class="col-xs-4">
                <select class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Custom<?php echo $i; ?>][Show]" id="Custom<?php echo $i; ?>Show_<?php echo $lang['code']; ?>">
                    <option value="true" <?php echo (!empty($module_data[$lang['code']]['Widgets']['Custom' . $i]['Show']) && $module_data[$lang['code']]['Widgets']['Custom' . $i]['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data[$lang['code']]['Widgets']['Custom' . $i]['Show']) && $module_data[$lang['code']]['Widgets']['Custom' . $i]['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="ColumnPositionCustom<?php echo $i; ?>_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label></td>
        <td>
        	<div class="col-xs-4">
                <input id="ColumnPositionCustom<?php echo $i; ?>_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][Custom<?php echo $i; ?>]" value="<?php echo !empty($module_data[$lang['code']]['Positions']['Custom' . $i]) ? $module_data[$lang['code']]['Positions']['Custom' . $i] : '10'; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="Custom<?php echo $i; ?>Title_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label></td>
        <td>
        	<div class="col-xs-4">
                <input id="Custom<?php echo $i; ?>Title_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Custom<?php echo $i; ?>][Title]" value="<?php echo !empty($module_data[$lang['code']]['Widgets']['Custom' . $i]['Title']) ? $module_data[$lang['code']]['Widgets']['Custom' . $i]['Title'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top"><label for="Custom<?php echo $i; ?>Text_<?php echo $lang['code']; ?>"><?php echo $custom_text; ?></label></td>
        <td>
        	<div class="col-xs-12">
                <textarea id="Custom<?php echo $i; ?>Text_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Custom<?php echo $i; ?>][Text]"><?php echo !empty($module_data[$lang['code']]['Widgets']['Custom' . $i]['Text']) ? $module_data[$lang['code']]['Widgets']['Custom' . $i]['Text'] : ''; ?></textarea>
            </div>
    	</td>
    </tr>
</table>
<script type="text/javascript"><!--
	$('#Custom<?php echo $i; ?>Text_<?php echo $lang['code']; ?>').summernote({
		height: 300
	});
//--></script> 