<?php 
    $mailtemplate_name = $moduleName.'[MailTemplate]['.$mailtemplate['id'].']';
    $mailtemplate_data = (isset($moduleData['MailTemplate'][$mailtemplate['id']])) ? $moduleData['MailTemplate'][$mailtemplate['id']] : array();
?>
<div id="mailtemplate_<?php echo $mailtemplate['id']; ?>" class="tab-pane templates" style="width:99%;overflow:hidden;">
	<div class="row removable">
	  <div class="col-md-3">
        <h5><strong><span class="required">* </span>Template <?php echo $mailtemplate['id']; ?> status:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the selected mail template configuration.</span>
      </div>
      <div class="col-md-3">
        <select id="Checker" name="<?php echo $mailtemplate_name; ?>[Enabled]" class="form-control">
              <option value="yes" <?php echo (!empty($mailtemplate_data['Enabled']) && $mailtemplate_data['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
              <option value="no"  <?php echo (empty($mailtemplate_data['Enabled']) || $mailtemplate_data['Enabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
        </select>
      </div>
    </div>
    <div class="row removable">
      <br />
      <div class="col-md-3">
        <h5><strong>&nbsp;Template <?php echo $mailtemplate['id']; ?> name:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Set the name of the template which will show up on the left column.</span>
      </div>
      <div class="col-md-3">
		<input type="text" class="form-control" name="<?php echo $mailtemplate_name; ?>[Name]" value="<?php if (isset($mailtemplate_data['Name'])) echo $mailtemplate_data['Name']; else echo 'Template '.$mailtemplate['id'] ; ?>" />
      </div>
    </div>
    <div class="row removable">
      <br />
      <div class="col-md-3">
        <h5><strong>Message delay:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Define after how many days to send the email.<br /><br />
        <strong>NOTE: </strong>If you set the delay to 0, the email will be sent immediately after you run the cron job and if the conditions are met.</span>
      </div>
      <div class="col-md-3">
      	<div class="input-group">
		 <input type="text" class="form-control" name="<?php echo $mailtemplate_name; ?>[Delay]" value="<?php if (isset($mailtemplate_data['Delay'])) echo $mailtemplate_data['Delay']; else echo '3'; ?>" />
         <span class="input-group-addon">days</span>
        </div>
      </div>
    </div>
    <div class="row">
      <br />
      <div class="col-md-3">
        <h5><strong>Type of discount:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;If you choose the option 'No discount', you will have to remove the following codes from the mail template: {discount_code}, {discount_value}, {total_amount} and {date_end}.</span>
      </div>
      <div class="col-md-3">
        <select name="<?php echo $mailtemplate_name; ?>[DiscountType]" class="discountTypeSelect form-control"> 
            <option value="P" <?php if(!empty($mailtemplate_data['DiscountType']) && $mailtemplate_data['DiscountType'] == "P") echo "selected"; ?>>Percentage</option>
            <option value="F" <?php if(!empty($mailtemplate_data['DiscountType']) && $mailtemplate_data['DiscountType'] == "F") echo "selected"; ?>>Fixed amount</option>
            <option value="N" <?php if(empty($mailtemplate_data['DiscountType']) || $mailtemplate_data['DiscountType'] == "N") echo "selected"; ?>>No discount</option>
        </select>
      </div>
    </div>
    <br />
    <div class="discountSettings">
        <div class="row">
          <div class="col-md-3">
            <h5><strong><span class="required">* </span>Discount:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enter the discount percent or value.</span>
          </div>
          <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" name="<?php echo $mailtemplate_name; ?>[Discount]" value="<?php if(!empty($mailtemplate_data['Discount'])) echo $mailtemplate_data['Discount']; else echo '10'; ?>">
                <span class="input-group-addon">
                   <span style="display:none;" id="currencyAddon"><?php echo $currency; ?></span><span style="display:none;" id="percentageAddon">%</span>
               </span>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-3">
            <h5><strong><span class="required">* </span>Total amount:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;The total amount that must reached before the coupon is valid.</span>
          </div>
          <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" name="<?php echo $mailtemplate_name; ?>[TotalAmount]" value="<?php if(!empty($mailtemplate_data['TotalAmount'])) echo $mailtemplate_data['TotalAmount']; else echo '20'; ?>">
                <span class="input-group-addon"><?php echo $currency ?></span>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-3">
            <h5><strong><span class="required">* </span>Discount validity:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Define how many days the discount code will be active after sending the reminder.</span>
          </div>
          <div class="col-md-3">
            <div class="input-group">
                <input type="text" class="form-control" value="<?php if(!empty($mailtemplate_data['DiscountValidity'])) echo (int)$mailtemplate_data['DiscountValidity']; else echo 7; ?>" name="<?php echo $mailtemplate_name; ?>[DiscountValidity]">
                <span class="input-group-addon">days</span>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-3">
            <h5><strong><span class="required">* </span>Apply the discount for:</strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose the products that the discount will apply to:</span>
          </div>
          <div class="col-md-3">
            <select class="form-control" name="<?php echo $mailtemplate_name; ?>[DiscountApply]" > 
                <option value="all_products" <?php if(!empty($mailtemplate_data['DiscountApply']) && $mailtemplate_data['DiscountApply'] == "all_products") echo "selected"; ?>>All products in the store</option>
                <option value="cart_products" <?php if(!empty($mailtemplate_data['DiscountApply']) && $mailtemplate_data['DiscountApply'] == "cart_products") echo "selected"; ?>>Products in the cart</option>
            </select>
          </div>
        </div>
    </div>
    <br />
	<div class="row">
      <div class="col-md-3">
        <h5><strong>Product image dimensions:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Define the width the height of the product images.</span>
      </div>
      <div class="col-md-3">
        <div class="input-group">
           <span class="input-group-addon">Width:&nbsp;</span> <input class="form-control" id="appendedInput" type="text" name="<?php echo $mailtemplate_name; ?>[ProductWidth]" value="<?php echo (isset($mailtemplate_data['ProductWidth'])) ? $mailtemplate_data['ProductWidth'] : '60' ?>">
          <span class="input-group-addon">px</span>
        </div>
        <br />
        <div class="input-group">
            <span class="input-group-addon">Height:</span> <input class="form-control" id="appendedInput" type="text" name="<?php echo $mailtemplate_name; ?>[ProductHeight]" value="<?php echo (isset($mailtemplate_data['ProductHeight'])) ? $mailtemplate_data['ProductHeight'] : '60' ?>">
          <span class="input-group-addon">px</span>
        </div>
      </div>
    </div>
    <hr />
	<div class="row">
      <div class="col-md-3">
        <h5><strong>Message to the customer:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Use can the following shortcodes: <br /><br />
            {firstname} - First name<br />
            {lastname} - Last name<br />
            {cart_content} - Cart content<br />
            {discount_code} - Discount code<br />
            {discount_value} - Discount code<br />
            {total_amount} - Total amount<br />
            {date_end} - End date of coupon validity<br/>
            {unsubscribe_link} - Link for unsubscribe</span></span>
      </div>
      <div class="col-md-9">
        <ul class="nav nav-tabs mailtemplate_tabs">
            <?php $i=0; foreach ($languages as $language) { ?>
                <li <?php if ($i==0) echo 'class="active"'; ?>><a href="#tab-<?php echo $mailtemplate['id']; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>"/> <?php echo $language['name']; ?></a></li>
            <?php $i++; }?>
        </ul>	
        <div class="tab-content">
			<?php $i=0; foreach ($languages as $language) { ?>
            	<div id="tab-<?php echo $mailtemplate['id']; ?>-<?php echo $language['language_id']; ?>" language-id="<?php echo $language['language_id']; ?>" class="row-fluid tab-pane language <?php if ($i==0) echo 'active'; ?>">
                <div class="row">
                  <div class="col-md-7">
					<input placeholder="Mail subject" type="text" class="form-control" name="<?php echo $mailtemplate_name; ?>[Subject][<?php echo $language['language_id']; ?>]" value="<?php if(!empty($mailtemplate_data['Subject'][$language['language_id']])) echo $mailtemplate_data['Subject'][$language['language_id']]; else echo "Template Subject"; ?>" />
                  </div>
                </div>
                <br />
				<div class="row">
                  <div class="col-md-12">
					<textarea class="mailMessageText" id="message_<?php echo $mailtemplate['id']; ?>_<?php echo $language['language_id']; ?>" name="<?php echo $mailtemplate_name; ?>[Message][<?php echo $language['language_id']; ?>]">
						<?php if(!empty($mailtemplate_data['Message'][$language['language_id']])) echo $mailtemplate_data['Message'][$language['language_id']]; else echo '<table style="width:100%">
        <tbody>
            <tr>
                <td align="center">
                <table style="width:650px;margin:0 auto;border:1px solid #f0f0f0;padding:10px;line-height:1.8">
                    <tbody>
                        <tr>
                            <td>
                            <p>Hello <strong>{firstname} {lastname}</strong>,</p>
    
                            <p>We noticed that during you last visit to our store you placed the following products to you shopping cart and proceeded through checkout, but for some reason you did not complete the order:</p>
                            {cart_content}
    
                            <p>We do not know why you decided not to purchase this time, but we want to give you a special discount code - <strong>{discount_code}</strong> - which gives you <strong>{discount_value}% OFF</strong>. The code applies after you spent <strong>${total_amount}</strong>. This promotion is just for you and expires on <strong>{date_end}</strong>.</p>
    
                            <p>Kind Regards,</p>
    
                            <p>YourStore<br />
                            <a href="http://www.example.com" target="_blank">http://www.example.com</a></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
    
                <table style="width:650px;margin:0 auto;line-height:1.8">
                    <tbody>
                        <tr>
                            <td>
                            <div style="float:right;font-size:11px;">{unsubscribe_link}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </td>
            </tr>
        </tbody>
    </table>'; ?>
				    </textarea>
                  </div>
                </div>
        	</div>
        <?php $i++; } ?>
		</div>
      </div>
    </div>
	<div class="row removable">
	  <br />
      <div class="col-md-3">
        <h5><strong>Remove empty records</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;When the CRON job is executed, all empty records for the given delay in the template will be removed.<br /><br />
       </span>
      </div>
	  <div class="col-md-3">
        <select id="Checker" name="<?php echo $mailtemplate_name; ?>[RemoveEmptyRecords]" class="form-control">
              <option value="yes" <?php echo (!empty($mailtemplate_data['RemoveEmptyRecords']) && $mailtemplate_data['RemoveEmptyRecords'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
              <option value="no"  <?php echo (empty($mailtemplate_data['RemoveEmptyRecords']) || $mailtemplate_data['RemoveEmptyRecords']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
        </select>
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-md-3">
        <h5><strong><span class="required">* </span>Additional options</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Here you can find the additional options for the emails.</span>
      </div>
      <div class="col-md-6">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="<?php echo $mailtemplate_name; ?>[RemoveAfterSend]" value="yes" <?php echo !empty($mailtemplate_data['RemoveAfterSend']) ? 'checked="checked"' : ''; ?>/> Remove the abandoned cart record after the email is sent
            </label>
        </div>
      </div>
    </div>
    <?php if (isset($newAddition) && $newAddition==true) { ?>
    	<script type="text/javascript">
			<?php foreach ($languages as $language) { ?>
				$('#message_<?php echo $mailtemplate['id']; ?>_<?php echo $language['language_id']; ?>').summernote({
						height: 320
				});
			<?php } ?>
			selectorsForDiscount();
		</script>
    <?php } ?>
</div>