<table class="table">
	<tr>
    	<td class="col-xs-2"><label for="PaymentIconsShow"><?php echo $paymenticons_showpaymenticons; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][PaymentIcons][Show]" class="form-control" id="PaymentIconsShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['PaymentIcons']['Show']) && $module_data['Settings']['PaymentIcons']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['PaymentIcons']['Show']) && $module_data['Settings']['PaymentIcons']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top"><label for="PaymentIconsList" class="control-label"><?php echo $paymenticons_uploadicons; ?></label></td>
        <td>
        	<div class="col-xs-10" id="paymentIconNameParent">
                <div class="paymenticons_container">
                    <div>
                        <input name="paymentIconName" class="form-control item-inline" id="paymentIconName" type="text" placeholder="<?php echo $paymenticons_titleoftheicon; ?>" />
                        <span data-click-selector="#PaymentIcons" class="paymentIconsBrowse btn btn-primary item-inline item-top" data-browse-text-selector="#PaymentIconsValue" data-toggle="tooltip" title="<?php echo $paymenticons_addfiles; ?>"><i class="fa fa-folder-open-o"></i></span>
                        <span id="PaymentIconsValue" class="PaymentIconsValues"></span>
                    </div>
                    <div>
                        <button class="paymentIconsUploadButton btn btn-success" data-name-source-selector="#paymentIconNameParent" data-name-selector="#paymentIconName"><i class="fa fa-upload"></i>&nbsp;<?php echo $paymenticons_upload; ?></button>
                    </div>
                    <div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top"><label for="PaymentIconsList"><?php echo $paymenticons_paymenticons; ?></label></td>
        <td>
            <table class="table paymenticons_list">
				<?php foreach ($images as $icon_index => $icon) : ?>
                <tr class="paymenticon">
                    <td class="paymenticon_move">
						<?php if ($icon_index > 0) : ?>
                    		<a href="<?php echo $icon['moveup']; ?>"><i class="fa fa-chevron-up"></i></a>
						<?php endif; ?>
                    </td>
                    <td class="paymenticon_move">
						<?php if ($icon_index < count($images) - 1) : ?>
                        	<a href="<?php echo $icon['movedown']; ?>"><i class="fa fa-chevron-down"></i></a>
						<?php endif; ?>
                    </td>
                    <td class="paymenticon_image">
                    	<img src="<?php echo $icon['path']; ?>" alt="<?php echo $icon['name']; ?>" />
                    </td>
                    <td class="paymenticon_name"><?php echo $icon['name']; ?></td>
                    <td class="paymenticon_remove">
                    	<a class="btn btn-danger btn-xs" data-toggle="tooltip" title="<?php echo $paymenticons_delete; ?>" onclick="return confirm('<?php echo str_replace('{IMAGE}', $icon['name'], $paymenticons_confirm_delete); ?>');" href="<?php echo $icon['delete']; ?>"><i class="fa fa-times"></i></a>
                	</td>
                </tr>
                <?php endforeach; ?>
            </table>
    	</td>
    </tr>
</table>