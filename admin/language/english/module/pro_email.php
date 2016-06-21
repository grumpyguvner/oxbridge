<?php
// Heading
$_['heading_title'] = '<img src="'. (defined('JPATH_MIJOSHOP_OC') ? 'admin/' : '') . 'view/pro_email/img/icon.png" alt="" style="vertical-align:bottom;padding-right:4px"/><b style="color:#156584;">Pro Email Template</b>';

// Text 
$_['text_module'] = 'Modules';
$_['text_image_manager'] = 'Image Manager';
$_['text_browse'] = 'Browse';
$_['text_clear'] = 'Clear';
$_['text_add_feed'] = 'New feed';
$_['text_success'] = 'Success: You have modified Pro Email Template!';
$_['text_info'] = 'This sitemap does not contains duplicates and integrates the hreflang tag if enabled in seo package options.';
$_['text_minute'] = 'Minute(s)';
$_['text_hour'] = 'Hour(s)';
$_['text_day'] = 'Day(s)';
$_['text_preview'] = 'Preview';
$_['text_repeat'] = 'Repeat';
$_['text_no-repeat'] = 'No repeat';
$_['text_no-repeat_center'] = 'No repeat - Centered';
$_['text_repeat-x'] = 'Repeat X';
$_['text_repeat-y'] = 'Repeat Y';
$_['text_store_select'] = 'Store:';
$_['text_warning_layout_zones'] = 'Depending the template in use some layout zones may not be implemented';

// Tabs
$_['text_tab_0'] = 'Main Layout';
$_['entry_layout'] = 'Template:<span class="help">Define a default layout for all emails, this setting can be overridden in email content section</span>';
$_['entry_color_scheme'] = 'Color scheme:<span class="help">Quick access to some color schemes, edit them in design tab</span>';
$_['entry_logo'] = 'Logo';

// Design
$_['text_tab_1'] = 'Design';
$_['text_save_scheme'] = 'Save color scheme';
$_['text_color_scheme_saved'] = 'Color scheme saved';
$_['text_page'] = 'Page';
$_['text_top'] = 'Top header';
$_['text_header'] = 'Header';
$_['text_body'] = 'Body';
$_['text_foot'] = 'Footer';
$_['text_bottom'] = 'Bottom footer';
$_['text_button'] = 'Button';
$_['text_link'] = 'link';
$_['entry_layout_width'] = 'Layout width:';
$_['entry_layout_width_i'] = 'Width of the main layout in pixels. For desktop only, small devices automatically get width to 100%';
$_['entry_color_text'] = 'Text color';
$_['entry_color_link'] = 'Link color';
$_['entry_color_btn'] = 'Button color';
$_['entry_color_btn_text'] = 'Button text color';
$_['text_global'] = 'Global';
$_['entry_color'] = 'Background color:';
$_['entry_background_image'] = 'Background image:';
$_['entry_repeat'] = 'Background repeat:';

// Content editor
$_['text_tab_2'] = 'Mail Content Editor';
$_['text_tab_content_0'] = 'Customer notification';
$_['text_tab_content_1'] = 'Order status update';
$_['text_tab_content_2'] = 'Admin notification';
$_['text_tab_content_3'] = 'Common content';
$_['text_tab_content_4'] = 'Custom email';
$_['entry_from'] = 'From:';
$_['entry_subject'] = 'Subject:<span class="help">Leave empty to use default value</span>';
$_['entry_content'] = 'Content:<span class="help">Leave empty to use default value</span>';
$_['entry_attachment'] = 'Attachment:';
$_['button_upload'] = 'Upload';
$_['text_loading'] = 'Loading...';
$_['placeholder_file'] = 'Attach a file to the mail';

$_['text_tab_3'] = 'Custom Blocks';

// config
$_['text_tab_4'] = 'Configuration';
$_['tab_config_1'] = 'Default values';
$_['tab_config_10'] = 'Advanced options';
$_['entry_reset_content'] = 'Restore email content';
$_['btn_reset_content'] = 'Restore default values for email content';
$_['info_msg_reset_content'] = 'Use this function to restore default values of all email content (subject and message).<br/><br/>If you traduced the language file, please also use this function to make appear your translations.';
$_['text_confirm_restore_content'] = 'Are you sure ? All actual texts for your emails will be overwritten.';


$_['text_btn_custom_binder'] = 'Bind info';

$_['text_tab_about'] = 'About';

// Content editor
$_['text_type_affiliate'] = 'Affiliate';
$_['text_type_customer'] = 'Customer';
$_['text_type_order'] = 'Order';
$_['text_type_admin'] = 'Admin notification';
$_['text_type_orderstatus'] = 'Order status';
$_['text_type_affiliate.approve'] = 'Affiliate approved';
$_['text_type_affiliate.forgotten'] = 'Affiliate forgot password';
$_['text_type_affiliate.register'] = 'Affiliate register';
$_['text_type_affiliate.transaction'] = 'Affiliate transaction';
$_['text_type_customer.approve'] = 'Customer approved';
$_['text_type_customer.credit'] = 'Customer credit';
$_['text_type_customer.forgotten'] = 'Customer forgot password';
$_['text_type_customer.register'] = 'Customer register';
$_['text_type_customer.reward'] = 'Customer reward';
$_['text_type_customer.voucher'] = 'Customer voucher';
$_['text_type_order.confirm'] = 'Order confirm';
$_['text_type_order.update'] = 'Order update';
$_['text_type_order.return'] = 'Order return';
$_['text_type_sale.contact'] = 'Sale mail';
$_['text_type_admin.order.confirm'] = 'Order confirm';
$_['text_type_admin.information.contact'] = 'Enquiry';
$_['text_type_admin.customer.register'] = 'Customer signup';
$_['text_type_admin.affiliate.register'] = 'Affiliate signup';
$_['text_type_common.top'] = 'Top header';
$_['text_type_common.header'] = 'Header';
$_['text_type_common.footer'] = 'Footer';
$_['text_type_common.bottom'] = 'Bottom footer';

// Entry
$_['entry_status'] = 'Status:';

// Info
$_['info_title_default']		= 'Help';
$_['info_msg_default']	= 'Help section for this topic not found';

$_['info_title_custom_mail']	= 'Bind pro email template to any emails';
$_['info_msg_custom_mail']	= '<p>The module provides easy way to attach your new beautiful email template to any mail that may come from custom modules.</p>
<ul>
  <li>Copy the file _extra_features/pro_email_template_custom_mail.xml into /vqmod/xml/</li>
  <li>Edit the file and follow the indications below</li>
</ul>
<p>In the file you will have various values to change:</p>
<ol>
  <li style="padding-bottom:10px">
    <code>&lt;file name=&quot;<b>catalog/model/module/custom_module.php</b>&quot;&gt;</code><br/>
    First you have to find in your custom module which file is sending the mail, to do that you can search in the module files which one contains the string <code>$mail->send();</code><br/>
    Once found, you will have to adapt the path to this file in the <file> tag
  </li>
  <li style="padding-bottom:10px">
    <code>&lt;search position=&quot;replace&quot; <b>index=&quot;1&quot;</b>&gt;&lt;![CDATA[<b>$mail-&gt;send();</b>]]&gt;&lt;/search&gt;</code><br/>
    Then if this file contain more than one $mail->send(), you will have to count which one you want to bind the template and put this value in <code>index=""</code><br/>
    For example if it is the second $mail->send() found in file just put <code>index="2"</code><br/>
    Also take care of <code>$mail->send();</code> because the $mail can be something else ($email->send(), $message->send(), etc), so you will have to adapt <code>$mail->send();</code> and <code>\'mail\' => $mail,</code>values accordingly.
  </li>
  <li style="padding-bottom:10px">
    <code>\'name\' =&gt; \'<b>Email for custom module</b>\'</code><br/>
    Find this sentence and change "Email for custom module" by the name you want, this is just for you, it will appear with this name in admin page<br/>
  </li>
  <li style="padding-bottom:10px">
    <code>\'<b>tag</b>\' => \'<b>value</b>\',</code><br/>
    You can also insert dynamic values that will be available as tags, find this sentence and and change \'value\' by some variable present in your code<br/>
    for example <code>\'customer_name\' => $customer_name,</code><br/>
    Then you can use {customer_name} in the template content to dynamically insert it.<br/>
    Duplicate this line to add as many tags as necessary.
  </li>
</ol>
<p>Once all that done, come back on this page and you will be able to change the content of the message.</p>';

$_['info_title_tags']	= 'Available tags';
$_['info_msg_tags']	= '
<div class="infotags">
<h5>Common tags</h5>
<p>
<span><b class="tag">{store_name}</b> Store name</span>
<span><b class="tag">{store_url}</b> Store URL</span>
<span><b class="tag">{store_email}</b> Store Email</span>
<span><b class="tag">{store_phone}</b> Store Phone</span><br/>
<span><b class="tag">[link=URL][/link]</b> Link (replace URL by url or tag)</span>
<span><b class="tag">[button=URL][/button]</b> Button (replace URL by url or tag)</span>
</p>
</div>';
$_['info_title_custom']	= 'Custom tags';
$_['info_msg_custom']	= '<div class="infotags">
<h5>Custom tags</h5>
<p>Use your own tags defined in the custom mail attacher.</p>
</div>';
$_['info_msg_tags_qosu']	= '
<div class="infotags">
<h5>Tracking (Quick order status updater)</h5>
<p>
<span><b class="tag">{tracking_no}</b> Tracking Number</span>
<span><b class="tag">{tracking_url}</b> Tracking URL</span>
<span><b class="tag">{tracking_link}</b> Tracking URL (clickable link)</span>
<span><b class="tag">[if_tracking][/if_tracking]</b> If tracking exists</span>
</p>
</div>';
$_['info_msg_tags_conditions']	= '
<div class="infotags">
<h5>Conditional blocks</h5>
<p>
To use a conditionnal block you have enclose your content in an opening tag <b class="tag">[if_condition]</b> and a closing tag with same name <b class="tag">[/if_condition]</b><br/>
All conditions also have their negative version : <b class="tag">[if_not_condition]</b>...<b class="tag">[/if_not_condition]</b>
</p>
</div>';
$_['info_msg_tags_status']	= '
<div class="infotags">
<h5>Status update</h5>
<p>
<span><b class="tag">{order_status}</b> Status name</span>
<span><b class="tag">{message}</b> Notify message</span>
</p>
</div>';
$_['info_msg_tags_order_cond']	= '
<div class="infotags">
<h5>Order conditions</h5>
<p>
<span><b class="tag">[if_message]</b> If message exists</span>
<span><b class="tag">[if_customer]</b> If is registered customer</span>
</p>
</div>';
$_['info_msg_customer.approve']	= '
<div class="infotags">
<h5>Customer</h5>
<p>
<span><b class="tag">{firstname}</b> First name</span>
<span><b class="tag">{account_url}</b> Account URL</span>
</p>
</div>';
$_['info_msg_customer.forgotten']	= '
<div class="infotags">
<h5>Customer</h5>
<p>
<span><b class="tag">{password}</b> Password</span>
<span><b class="tag">{account_url}</b> Account URL</span>
</p>
</div>';
$_['info_msg_customer.register']	= '
<div class="infotags">
<h5>Customer</h5>
<p>
<span><b class="tag">{email}</b> Email</span>
<span><b class="tag">{password}</b> Password</span>
<span><b class="tag">{account_url}</b> Account URL</span>
<span><b class="tag">[if_approval]</b> Approval is required</span>
<span><b class="tag">[if_not_approval]</b> Approval is not required</span>
</p>
</div>';
$_['info_msg_customer.credit']	= '
<div class="infotags">
<h5>Customer</h5>
<p>
<span><b class="tag">{firstname}</b> First name</span>
<span><b class="tag">{amount}</b> Credit amount</span>
<span><b class="tag">{total}</b> Total credit</span>
<span><b class="tag">{account_url}</b> Account URL</span>
</p>
</div>';
$_['info_msg_customer.reward']	= '
<div class="infotags">
<h5>Customer</h5>
<p>
<span><b class="tag">{firstname}</b> First name</span>
<span><b class="tag">{amount}</b> Reward points</span>
<span><b class="tag">{total}</b> Total reward points</span>
<span><b class="tag">{account_url}</b> Account URL</span>
</p>
</div>';
$_['info_msg_customer.voucher']	= '
<div class="infotags">
<h5>Customer</h5>
<p>
<span><b class="tag">{amount}</b> Voucher amount</span>
<span><b class="tag">{from}</b> Name of sender</span>
<span><b class="tag">{code}</b> Redemption code</span>
<span><b class="tag">{image}</b> Voucher predefined image</span>
<span><b class="tag">{message}</b> Sender message</span><br/>
<span><b class="tag">[if_image]</b> If predefined image exists</span>
<span><b class="tag">[if_message]</b> If sender left message</span>
</p>
</div>';
$_['info_msg_affiliate.approve']	= '
<div class="infotags">
<h5>Affiliate</h5>
<p>
<span><b class="tag">{firstname}</b> First name</span>
<span><b class="tag">{affiliate_url}</b> Affiliate account URL</span>
</p>
</div>';
$_['info_msg_affiliate.forgotten']	= '
<div class="infotags">
<h5>Affiliate</h5>
<p>
<span><b class="tag">{password}</b> Password</span>
<span><b class="tag">{affiliate_url}</b> Affiliate account URL</span>
</p>
</div>';
$_['info_msg_affiliate.register']	= '
<div class="infotags">
<h5>Affiliate</h5>
<p>
<span><b class="tag">{email}</b> Email</span>
<span><b class="tag">{password}</b> Password</span>
<span><b class="tag">{affiliate_url}</b> Affiliate account URL</span>
<span><b class="tag">[if_approval]</b> Approval is required</span>
<span><b class="tag">[if_not_approval]</b> Approval is not required</span>
</p>
</div>';
$_['info_msg_affiliate.transaction']	= '
<div class="infotags">
<h5>Affiliate</h5>
<p>
<span><b class="tag">{firstname}</b> First name</span>
<span><b class="tag">{amount}</b> Affiliate commission</span>
<span><b class="tag">{total}</b> Total commission amount</span>
<span><b class="tag">{affiliate_url}</b> Affiliate account URL</span>
</p>
</div>';
$_['info_msg_order.return']	= '
<div class="infotags">
<h5>Order return</h5>
<p>
<span><b class="tag">{return_id}</b> Return ID</span>
<span><b class="tag">{order_status}</b> Order status</span>
<span><b class="tag">{message}</b> Message</span>
<span><b class="tag">[if_message]</b> If message</span>
</p>
</div>';
$_['info_msg_sale.contact']	= '
<div class="infotags">
<h5>Marketing mail</h5>
<p>This mail is the one sent to customers from marketing > mail</p>
<p>
<span><b class="tag">{message}</b> Message</span>
</p>
</div>';
$_['info_msg_tags_order']	= '
<div class="infotags">
<h5>Invoice</h5>
<p>
<span><b class="tag">{invoice}</b> Full invoice</span>
</p>
<h5>Customer</h5>
<p>
<span><b class="tag">{customer_id}</b> Customer ID</span>
<span><b class="tag">{customer}</b> Full name</span>
<span><b class="tag">{firstname}</b> First name</span>
<span><b class="tag">{lastname}</b> Last name</span>
<span><b class="tag">{telephone}</b> Phone number</span>
<span><b class="tag">{email}</b> Email address</span>
</p>
<h5>Order</h5>
<p>
<span><b class="tag">{order_id}</b> Order ID</span>
<span><b class="tag">{invoice_no}</b> Invoice number</span>
<span><b class="tag">{invoice_prefix}</b> Invoice prefix</span>
<span><b class="tag">{order_url}</b> Order URL (in user account)</span>
<span><b class="tag">[if_comment]</b> Conditional block</span>
<span><b class="tag">{comment}</b> Comment</span>
<span><b class="tag">{total}</b> Total amount</span>
<span><b class="tag">{reward}</b> Reward</span>
<span><b class="tag">{commission}</b> Commission</span>
<span><b class="tag">{language_code}</b> Language code</span>
<span><b class="tag">{currency_code}</b> Currency code</span>
<span><b class="tag">{currency_value}</b> Currency value</span>
<span><b class="tag">{amazon_order_id}</b> Amazon order ID</span>
</p>
<h5>Payment</h5>
<p>
<span><b class="tag">{payment_firstname}</b> First name</span>
<span><b class="tag">{payment_lastname}</b> Last name</span>
<span><b class="tag">{payment_company}</b> Company</span>
<span><b class="tag">{payment_address_1}</b> Address 1</span>
<span><b class="tag">{payment_address_2}</b> Address 2</span>
<span><b class="tag">{payment_postcode}</b> Postcode</span>
<span><b class="tag">{payment_city}</b> City</span>
<span><b class="tag">{payment_zone}</b> Zone</span>
<span><b class="tag">{payment_country}</b> Country</span>
<span><b class="tag">{payment_method}</b> Method</span>
<br/><br/>
<span style="width:100%"><b class="tag">[if_payment:code]..[/if_payment:code]</b> Display on specific payment method, replace payment_code by your actual payment code (bank_transfer, pp_express, ...). You can find the payment code in the url of a payment when you edit it, like this: route=payment/bank_transfer</span>
</p>
<h5>Shipping</h5>
<p>
<span><b class="tag">{shipping_firstname}</b> First name</span>
<span><b class="tag">{shipping_lastname}</b> Last name</span>
<span><b class="tag">{shipping_company}</b> Company</span>
<span><b class="tag">{shipping_address_1}</b> Address 1</span>
<span><b class="tag">{shipping_address_2}</b> Address 2</span>
<span><b class="tag">{shipping_postcode}</b> Postcode</span>
<span><b class="tag">{shipping_city}</b> City</span>
<span><b class="tag">{shipping_zone}</b> Zone</span>
<span><b class="tag">{shipping_country}</b> Country</span>
<span><b class="tag">{shipping_method}</b> Method</span>
</p>
<h5>Misc</h5>
<p>
<span><b class="tag">{ip}</b> User IP</span>
<span><b class="tag">{user_agent}</b> User agent</span>
</p>
</div>';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify this module!';
$_['error_permission_demo'] = 'Demo mode, saving is not allowed';
?>