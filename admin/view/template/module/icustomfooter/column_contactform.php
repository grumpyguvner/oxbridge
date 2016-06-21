<table class="table">
	<tr>
        <td class="col-xs-2">
            <label for="ContactFormShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
                <select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][Show]" id="ContactFormShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['ContactForm']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['ContactForm']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ColumnPositionContactform_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionContactform_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][contactform]" value="<?php echo $module_data[$lang['code']]['Positions']['contactform']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormUseCaptcha_<?php echo $lang['code']; ?>"><?php echo $contactform_captchaspamprotection; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
                <select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][UseCaptcha]" id="ContactFormUseCaptcha_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['ContactForm']['UseCaptcha'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['ContactForm']['UseCaptcha'] == 'false') ? 'selected=selected' : '';?>><?php echo $no?></option>
                </select>
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['Title']; ?>" />
        	</div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormEmail_<?php echo $lang['code']; ?>"><?php echo $contactform_sendemailsto; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormEmail_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][Email]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['Email']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormEmailSubject_<?php echo $lang['code']; ?>"><?php echo $contactform_emailsubject; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormEmailSubject_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][EmailSubject]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['EmailSubject']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelName_<?php echo $lang['code']; ?>"><?php echo $contactform_nameboxlabel; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">    
            	<input type="text" id="ContactFormLabelName_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelName]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelName']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelEmail_<?php echo $lang['code']; ?>"><?php echo $contactform_emailboxlabel; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">    
            	<input type="text" id="ContactFormLabelEmail_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelEmail]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelEmail']; ?>" />
        	</div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelMessage_<?php echo $lang['code']; ?>"><?php echo $contactform_messageboxlabel; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormLabelMessage_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelMessage]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelMessage']; ?>" />
        	</div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormMaxMessageLength_<?php echo $lang['code']; ?>"><?php echo $contactform_message_max_length; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormMaxMessageLength_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][MaxMessageLength]" value="<?php echo !empty($module_data[$lang['code']]['Widgets']['ContactForm']['MaxMessageLength']) ? $module_data[$lang['code']]['Widgets']['ContactForm']['MaxMessageLength'] : 1000; ?>" />
        	</div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelCaptcha_<?php echo $lang['code']; ?>"><?php echo $contactform_captchaboxlabel; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
           		<input type="text" id="ContactFormLabelCaptcha_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelCaptcha]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelCaptcha']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelSend_<?php echo $lang['code']; ?>"><?php echo $contactform_sendbuttonlabel; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormLabelSend_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelSend]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelSend']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelSuccess_<?php echo $lang['code']; ?>"><?php echo $contactform_successfulsentmessage; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormLabelSuccess_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelSuccess]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelSuccess']; ?>" />
        	</div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelRequired_<?php echo $lang['code']; ?>"><?php echo $contactform_requiredfieldmessage; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormLabelRequired_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelRequired]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelRequired']; ?>" />
        	</div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelNotValid_<?php echo $lang['code']; ?>"><?php echo $contactform_notvalidmessage; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormLabelNotValid_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelNotValid]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelNotValid']; ?>" />
            </div>
        </td>
	</tr>
    <tr>
        <td class="col-xs-2">
            <label for="ContactFormLabelInvalidCaptcha_<?php echo $lang['code']; ?>"><?php echo $contactform_notvalidcaptcha; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="ContactFormLabelInvalidCaptcha_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][ContactForm][LabelInvalidCaptcha]" value="<?php echo $module_data[$lang['code']]['Widgets']['ContactForm']['LabelInvalidCaptcha']; ?>" />
            </div>
        </td>
	</tr>
</table>