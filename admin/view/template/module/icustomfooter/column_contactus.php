<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="ContactsShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Show]" id="ContactsShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Contacts']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Contacts']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionContactus_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionContactus_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][contacts]" value="<?php echo $module_data[$lang['code']]['Positions']['contacts']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsIconSet_<?php echo $lang['code']; ?>"><?php echo $contactus_iconset; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][IconSet]" id="ContactsIconSet_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="whiteicons" <?php echo ($module_data[$lang['code']]['Widgets']['Contacts']['IconSet'] == 'whiteicons') ? 'selected=selected' : ''; ?>><?php echo $whiteicons; ?></option>
                    <option value="blueicons" <?php echo ($module_data[$lang['code']]['Widgets']['Contacts']['IconSet'] == 'blueicons') ? 'selected=selected' : ''; ?>><?php echo $blueicons; ?></option>
                    <option value="greenicons" <?php echo ($module_data[$lang['code']]['Widgets']['Contacts']['IconSet'] == 'greenicons') ? 'selected=selected' : ''; ?>><?php echo $greenicons; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top">
        	<label for="ContactsText_<?php echo $lang['code']; ?>"><?php echo $contactus_text; ?></label>
        </td>
        <td>
        	<div class="col-xs-12">
            	<textarea id="ContactUs_<?php echo $lang['code']; ?>" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Text]"><?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Text']; ?></textarea>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsAddress1_<?php echo $lang['code']; ?>"><?php echo $contactus_address; ?> 1</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsAddress1_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Address1]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Address1']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsAddress2_<?php echo $lang['code']; ?>"><?php echo $contactus_address; ?> 2</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsAddress2_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Address2]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Address2']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsPhone1_<?php echo $lang['code']; ?>"><?php echo $contactus_phone; ?> 1</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsPhone1_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Phone1]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Phone1']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsPhone2_<?php echo $lang['code']; ?>"><?php echo $contactus_phone; ?> 2</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsPhone2_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Phone2]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Phone2']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsFax1_<?php echo $lang['code']; ?>"><?php echo $contactus_fax; ?> 1</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsFax1_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Fax1]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Fax1']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsFax2_<?php echo $lang['code']; ?>"><?php echo $contactus_fax; ?> 2</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsFax2_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Fax2]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Fax2']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsEmail1_<?php echo $lang['code']; ?>"><?php echo $contactus_email; ?> 1</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsEmail1_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Email1]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Email1']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsEmail2_<?php echo $lang['code']; ?>"><?php echo $contactus_email; ?> 2</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsEmail2_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Email2]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Email2']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsSkype1_<?php echo $lang['code']; ?>"><?php echo $contactus_skype; ?> 1</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsSkype1_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Skype1]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Skype1']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ContactsSkype2_<?php echo $lang['code']; ?>"><?php echo $contactus_skype; ?> 2</label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactsSkype2_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Contacts][Skype2]" value="<?php echo $module_data[$lang['code']]['Widgets']['Contacts']['Skype2']; ?>" />
            </div>
    	</td>
    </tr>
</table>
<script type="text/javascript"><!--
	$('#ContactUs_<?php echo $lang['code']; ?>').summernote({
		height: 300
	});
//--></script> 