<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="button" id="button-save" class="btn btn-primary"><i class="fa fa-check-circle"></i> <?php echo $button_save; ?></button>
				<a onclick="cancel();" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<style>
		#grey_screen {
			position:absolute;
			left:0;
			top:0;
			background:#000;
			z-index:998;
		}
	</style>
	<div id="grey_screen"></div>
	<div id="please_wait" style="display:none;position:fixed;top:50%;left:50%;width:300px;height:50px;margin-left:-150px;margin-top:-25px;padding-top:13px;border:1px solid #000;background-color:#FFF;border-radius:5px;font-size:14px;font-weight:bold;color:red;text-align:center;z-index:9999;"><?php echo $text_please_wait; ?></div>
	<div class="container-fluid">
		<div class="row" style="margin-bottom:13px;">
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_order_detail; ?></h3>
						<h3 id="edit-customer-info" class="panel-title" style="float:right;cursor:pointer;"><i class="fa fa-pencil"></i> </h3>
					</div>
					<div class="panel-body">
						<table class="table">
							<tbody>
								<tr>
									<td><b><?php echo $text_order_id; ?></b></td>
									<td>
										<?php if ($order_id) { ?>
											<?php echo $order_id; ?>
										<?php } else { ?>
											<?php echo $new_order; ?>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td><b><?php echo $text_customer_group; ?></b></td>
									<td id="customer-group"><?php echo $customer_group; ?></b></td>
								</tr>
								<tr>
									<td><b><?php echo $text_customer; ?></b></td>
									<td id="customer-name"><?php echo $firstname; ?> <?php echo $lastname; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_email; ?></b></td>
									<td id="customer-email"><?php echo $email; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_telephone; ?></b></td>
									<td id="customer-telephone"><?php echo $telephone; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_fax; ?></b></td>
									<td id="customer-fax"><?php echo $fax; ?></td>
								</tr>
								<tr id="new-customer" style="display:none;">
									<td class="text-right"><input type="checkbox" name="save_customer" value="1" /><br /><input type="checkbox" name="notify_customer" value="1" /></td>
									<td><b><?php echo $text_save_customer; ?></b><br /><b><?php echo $text_notify_customer; ?></b></td>
								</tr>
								<?php if ($order_id) { ?>
									<tr>
										<td><b><?php echo $text_store; ?></b></td>
										<td>
											<?php echo $store_name; ?>
											<select name="store_id" style="display:none;">
												<option value="<?php echo $store_id; ?>" selected="selected"></option>
											</select>
										</td>
									</tr>
									<tr>
										<td><b><?php echo $text_currency; ?></b></td>
										<td>
											<?php echo $currency_info; ?>
											<select name="currency" style="display:none;">
												<option value="<?php echo $currency_code; ?>" selected="selected"></option>
											</select>
										</td>
									</tr>
								<?php } else { ?>
									<tr>
										<td><b><?php echo $entry_store; ?></b></td>
										<td>
											<select name="store_id" id="input-store" class="form-control">
												<?php foreach ($stores as $store) { ?>
													<?php if ($store['store_id'] == $store_id) { ?>
														<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td><b><?php echo $entry_currency; ?></b></td>
										<td>
											<select name="currency" id="input-currency" class="form-control">
												<?php foreach ($currencies as $currency) { ?>
													<?php if ($currency['code'] == $currency_code) { ?>
														<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_payment_address; ?></h3>
						<h3 id="edit-customer-addr" class="panel-title" style="float:right;cursor:pointer;"><i class="fa fa-pencil"></i> </h3>
					</div>
					<div class="panel-body">
						<table class="table">
							<tbody>
								<?php if ($customer_id) { ?>
									<tr id="payment-address">
								<?php } else { ?>
									<tr id="payment-address" style="display:none;">
								<?php } ?>
									<td><b><?php echo $entry_address; ?></b></td>
									<td>
										<select name="payment_address" id="input-payment-address" class="form-control">
											<option value="0" selected="selected"><?php echo $text_none; ?></option>
											<?php foreach ($addresses as $address) { ?>
												<?php if ($address['city'] != '') { ?>
													<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
												<?php } else { ?>
													<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td><b><?php echo $text_company; ?></b></td>
									<td id="pa-company"><?php echo $payment_company; ?></b></td>
								</tr>
								<tr>
									<td><b><?php echo $text_name; ?></b></td>
									<td id="pa-name"><?php echo $payment_firstname; ?> <?php echo $payment_lastname; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_address_1; ?></b></td>
									<td id="pa-address-1"><?php echo $payment_address_1; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_address_2; ?></b></td>
									<td id="pa-address-2"><?php echo $payment_address_2; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_address_3; ?></b></td>
									<td id="pa-address-3">
										<?php if ($payment_city) { ?>
											<?php echo $payment_city; ?>, 
										<?php } ?>
										<?php if ($payment_zone && $payment_zone != "--- Please Select ---") { ?>
											<?php echo $payment_zone; ?>, 
										<?php } ?>
										<?php if ($payment_postcode) { ?>
											<?php echo $payment_postcode; ?>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td><b><?php echo $text_country; ?></b></td>
									<td id="pa-country"><?php echo $payment_country; ?></td>
								</tr>
								<tr>
									<td class="text-right"><input type="checkbox" name="shipping_same_payment" value="1" checked="checked" /></td>
									<td><b><?php echo $text_shipping_same_payment; ?></b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-user"></i> <?php echo $text_shipping_address; ?></h3>
						<h3 id="edit-customer-saddr" class="panel-title" style="display:none;float:right;cursor:pointer;"><i class="fa fa-pencil"></i> </h3>
					</div>
					<div class="panel-body">
						<table class="table">
							<tbody>
								<tr id="shipping-address" style="display:none;">
									<td><b><?php echo $entry_address; ?></b></td>
									<td>
										<select name="shipping_address" id="input-shipping-address" class="form-control">
											<option value="0" selected="selected"><?php echo $text_none; ?></option>
											<?php foreach ($addresses as $address) { ?>
												<?php if ($address['city'] != '') { ?>
													<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['city'] . ', ' . $address['country']; ?></option>
												<?php } else { ?>
													<option value="<?php echo $address['address_id']; ?>"><?php echo $address['firstname'] . ' ' . $address['lastname'] . ', ' . $address['address_1'] . ', ' . $address['country']; ?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td><b><?php echo $text_company; ?></b></td>
									<td id="sa-company"><?php echo $shipping_company; ?></b></td>
								</tr>
								<tr>
									<td><b><?php echo $text_name; ?></b></td>
									<td id="sa-name"><?php echo $shipping_firstname; ?> <?php echo $shipping_lastname; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_address_1; ?></b></td>
									<td id="sa-address-1"><?php echo $shipping_address_1; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_address_2; ?></b></td>
									<td id="sa-address-2"><?php echo $shipping_address_2; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $text_address_3; ?></b></td>
									<td id="sa-address-3">
										<?php if ($shipping_city) { ?>
											<?php echo $shipping_city; ?>, 
										<?php } ?>
										<?php if ($shipping_zone && $shipping_zone != "--- Please Select ---") { ?>
											<?php echo $shipping_zone; ?>, 
										<?php } ?>
										<?php if ($shipping_postcode) { ?>
											<?php echo $shipping_postcode; ?>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td><b><?php echo $text_country; ?></b></td>
									<td id="sa-country"><?php echo $shipping_country; ?></td>
								</tr>
								<tr id="new-address" style="display:none;">
									<td class="text-right"><input type="checkbox" name="save_address" value="1" /></td>
									<td><b><?php echo $text_save_address; ?></b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Begin Popups //-->
		<!-- Customer Information Popup //-->
		<div id="customer-information" style="display:none;position:fixed;top:0;left:50%;width:500px;min-height:516px;margin-left:-250px;background-color:#F7F7F7;border:1px solid #000;border-radius:5px;z-index:99999;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_order_detail; ?></h3>
					<h3 id="close-customer-info" class="panel-title" style="float:right;cursor:pointer;">X</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="input-customer"><?php echo $entry_customer; ?></label>
								<div class="col-sm-8">
									<input type="text" name="customer" value="<?php echo $customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
									<input type="hidden" name="ci_customer_id" value="<?php echo $customer_id; ?>" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-4 control-label" for="input-customer-group"><?php echo $entry_customer_group; ?></label>
								<div class="col-sm-8">
									<select name="customer_group" id="input-customer-group" class="form-control">
										<?php foreach ($customer_groups as $customer_group) { ?>
											<?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
												<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-4 control-label" for="input-firstname"><?php echo $entry_firstname; ?></label>
								<div class="col-sm-8">
									<input type="text" name="firstname" id="input-firstname" value="<?php echo $firstname; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-4 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
								<div class="col-sm-8">
									<input type="text" name="lastname" id="input-lastname" value="<?php echo $lastname; ?>" class="form-control" />
								</div>
							</div>
							<?php if ($oe_require_email) { ?>
								<div class="form-group required">
							<?php } else { ?>
								<div class="form-group">
							<?php } ?>
								<label class="col-sm-4 control-label" for="input-email"><?php echo $entry_email; ?></label>
								<div class="col-sm-8">
									<input type="text" name="email" id="input-email" value="<?php echo $email; ?>" class="form-control" />
								</div>
							</div>
							<?php if ($oe_require_telephone) { ?>
								<div class="form-group required">
							<?php } else { ?>
								<div class="form-group">
							<?php } ?>
								<label class="col-sm-4 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
								<div class="col-sm-8">
									<input type="text" name="telephone" id="input-telephone" value="<?php echo $telephone; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label" for="input-fax"><?php echo $entry_fax; ?></label>
								<div class="col-sm-8">
									<input type="text" name="fax" id="input-fax" value="<?php echo $fax; ?>" class="form-control" />
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="text-center" style="margin-bottom:13px;">
					<button type="button" id="button-customer-info" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-close"></i> <?php echo $button_save; ?></button>
					<button type="button" id="close-customer-info1" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
				</div>
			</div>
		</div>

		<!-- Customer Payment Address Popup //-->
		<div id="customer-address" style="display:none;position:fixed;top:0;left:50%;width:600px;min-height:716px;margin-left:-300px;background-color:#F7F7F7;border:1px solid #000;border-radius:5px;z-index:99999;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_payment_address; ?></h3>
					<h3 id="close-customer-addr" class="panel-title" style="float:right;cursor:pointer;">X</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="input-payment-company"><?php echo $entry_company; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_company" id="input-payment-company" value="<?php echo $payment_company; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-payment-firstname"><?php echo $entry_firstname; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_firstname" id="input-payment-firstname" value="<?php echo $payment_firstname; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-payment-lastname"><?php echo $entry_lastname; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_lastname" id="input-payment-lastname" value="<?php echo $payment_lastname; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-payment-address-1"><?php echo $entry_address_1; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_address_1" id="input-payment-address-1" value="<?php echo $payment_address_1; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="input-payment-address-2"><?php echo $entry_address_2; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_address_2" id="input-payment-address-2" value="<?php echo $payment_address_2; ?>" class="form-control" />
								</div>
							</div>
							<?php if ($oe_require_city) { ?>
								<div class="form-group required">
							<?php } else { ?>
								<div class="form-group">
							<?php } ?>
								<label class="col-sm-3 control-label" for="input-payment-city"><?php echo $entry_city; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_city" id="input-payment-city" value="<?php echo $payment_city; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="input-payment-postcode"><?php echo $entry_postcode; ?></label>
								<div class="col-sm-9">
									<input type="text" name="pa_postcode" id="input-payment-postcode" value="<?php echo $payment_postcode; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-payment-country"><?php echo $entry_country; ?></label>
								<div class="col-sm-9">
									<select name="pa_country_id" id="input-payment-country" class="form-control">
										<?php foreach ($countries as $country) { ?>
											<?php if ($country['country_id'] == $payment_country_id) { ?>
												<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php if ($oe_require_zone) { ?>
								<div class="form-group required">
							<?php } else { ?>
								<div class="form-group">
							<?php } ?>
								<label class="col-sm-3 control-label" for="input-payment-zone"><?php echo $entry_zone; ?></label>
								<div class="col-sm-9">
									<select name="pa_zone_id" id="input-payment-zone" class="form-control">
									</select>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="text-center" style="margin-bottom:13px;">
					<button type="button" id="button-save-customer-addr" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-close"></i> <?php echo $button_save; ?></button>
					<button type="button" id="close-customer-addr1" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
				</div>
			</div>
		</div>

		<!-- Customer Shipping Address Popup //-->
		<div id="customer-saddress" style="display:none;position:fixed;top:0;left:50%;width:600px;min-height:716px;margin-left:-300px;background-color:#F7F7F7;border:1px solid #000;border-radius:5px;z-index:99999;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_shipping_address; ?></h3>
					<h3 id="close-customer-saddr" class="panel-title" style="float:right;cursor:pointer;">X</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
						<fieldset>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="input-shipping-company"><?php echo $entry_company; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_company" id="input-shipping-company" value="<?php echo $shipping_company; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-shipping-firstname"><?php echo $entry_firstname; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_firstname" id="input-shipping-firstname" value="<?php echo $shipping_firstname; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-shipping-lastname"><?php echo $entry_lastname; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_lastname" id="input-shipping-lastname" value="<?php echo $shipping_lastname; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-shipping-address-1"><?php echo $entry_address_1; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_address_1" id="input-shipping-address-1" value="<?php echo $shipping_address_1; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="input-shipping-address-2"><?php echo $entry_address_2; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_address_2" id="input-shipping-address-2" value="<?php echo $shipping_address_2; ?>" class="form-control" />
								</div>
							</div>
							<?php if ($oe_require_city) { ?>
								<div class="form-group required">
							<?php } else { ?>
								<div class="form-group">
							<?php } ?>
								<label class="col-sm-3 control-label" for="input-shipping-city"><?php echo $entry_city; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_city" id="input-shipping-city" value="<?php echo $shipping_city; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="input-shipping-postcode"><?php echo $entry_postcode; ?></label>
								<div class="col-sm-9">
									<input type="text" name="sa_postcode" id="input-shipping-postcode" value="<?php echo $shipping_postcode; ?>" class="form-control" />
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-3 control-label" for="input-shipping-country"><?php echo $entry_country; ?></label>
								<div class="col-sm-9">
									<select name="sa_country_id" id="input-shipping-country" class="form-control">
										<?php foreach ($countries as $country) { ?>
											<?php if ($country['country_id'] == $payment_country_id) { ?>
												<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php if ($oe_require_zone) { ?>
								<div class="form-group required">
							<?php } else { ?>
								<div class="form-group">
							<?php } ?>
								<label class="col-sm-3 control-label" for="input-shipping-zone"><?php echo $entry_zone; ?></label>
								<div class="col-sm-9">
									<select name="sa_zone_id" id="input-shipping-zone" class="form-control">
									</select>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
				<div class="text-center" style="margin-bottom:13px;">
					<button type="button" id="button-save-customer-saddr" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-close"></i> <?php echo $button_save; ?></button>
					<button type="button" id="close-customer-saddr1" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
				</div>
			</div>
		</div>

		<!-- Add product to order popup //-->
		<div id="add-product" style="display:none;position:fixed;top:0;left:50%;width:800px;min-height:280px;margin-left:-400px;background-color:#F7F7F7;border:1px solid #000;border-radius:5px;z-index:99999;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_add_product; ?></h3>
					<h3 id="close-add-product" class="panel-title" style="float:right;cursor:pointer;">X</h3>
				</div>
				<div class="panel-body">
					<form>
						<div id="tab-product">
							<div class="table table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<td><?php echo $entry_product; ?></td>
											<td colspan="3"><input type="text" name="product" value="" id="input-product" placeholder="<?php echo $help_product_autocomplete; ?>" class="form-control" /><input type="hidden" name="product_id" value="" /></td>
										</tr>
										<tr>
											<td><?php echo $entry_custom_price; ?></td>
											<td>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="custom_price" value="1" />
													</label>
												</div>
											</td>
											<td><?php echo $entry_price; ?></td>
											<td><input type="text" name="price" value="" id="input-price" class="form-control" disabled="disabled" /></td>
										</tr>
										<tr>
											<td><?php echo $entry_notax; ?></td>
											<td>
												<div class="checkbox">
													<label>
														<input type="checkbox" name="notax" value="1" />
													</label>
												</div>
											</td>
											<td><?php echo $entry_quantity; ?></td>
											<td><input type="text" name="quantity" value="1" id="input-quantity" class="form-control" /></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</form>
				</div>
				<div class="text-center" style="margin-bottom:13px;">
					<button type="button" id="button-product-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_product_add; ?></button>
					<button type="button" id="close-add-product1" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
				</div>
			</div>
		</div>

		<!-- Option box popup //-->
		<div id="option-box" style="display:none;position:fixed;top:0;left:50%;width:500px;min-height:200px;margin-left:-250px;background-color:#F7F7F7;border:1px solid #000;border-radius:5px;z-index:99999;overflow:auto;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $entry_option; ?></h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
						<div id="option"></div>
					</form>
				</div>
				<div class="text-center" style="margin-bottom:13px;">
					<button type="button" id="button-save-option" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_save; ?></button>
					<button type="button" id="button-close-option" class="btn btn-default"><i class="fa fa-reply"></i></button>
				</div>
			</div>
		</div>

		<!-- Add voucher to order popup //-->
		<div id="add-voucher" style="display:none;position:fixed;top:0;left:50%;width:500px;min-height:516px;margin-left:-250px;background-color:#F7F7F7;border:1px solid #000;border-radius:5px;z-index:99999;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_add_voucher; ?></h3>
					<h3 id="close-add-voucher" class="panel-title" style="float:right;cursor:pointer;">X</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal">
						<div id="tab-voucher">
							<fieldset>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-to-name"><?php echo $entry_to_name; ?></label>
									<div class="col-sm-10">
										<input type="text" name="to_name" value="" id="input-to-name" class="form-control" />
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-to-email"><?php echo $entry_to_email; ?></label>
									<div class="col-sm-10">
										<input type="text" name="to_email" value="" id="input-to-email" class="form-control" />
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-from-name"><?php echo $entry_from_name; ?></label>
									<div class="col-sm-10">
										<input type="text" name="from_name" value="" id="input-from-name" class="form-control" />
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-from-email"><?php echo $entry_from_email; ?></label>
									<div class="col-sm-10">
										<input type="text" name="from_email" value="" id="input-from-email" class="form-control" />
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-theme"><?php echo $entry_theme; ?></label>
									<div class="col-sm-10">
										<select name="voucher_theme_id" id="input-theme" class="form-control">
											<?php foreach ($voucher_themes as $voucher_theme) { ?>
												<option value="<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
									<div class="col-sm-10">
										<textarea name="message" rows="5" id="input-message" class="form-control"></textarea>
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-amount"><?php echo $entry_amount; ?></label>
									<div class="col-sm-10">
										<input type="text" name="amount" value="<?php echo $voucher_min; ?>" id="input-amount" class="form-control" />
									</div>
								</div>
							</fieldset>
						</div>
					</form>
				</div>
				<div class="text-center" style="margin-bottom:13px;">
					<button type="button" id="button-voucher-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_voucher_add; ?></button>
					<button type="button" id="close-add-voucher1" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
				</div>
			</div>
		</div>
		<!-- End Popups //-->

		<div id="tab-customer" style="display:none;">
			<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
			<input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" />
			<input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
			<input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
			<input type="hidden" name="email" value="<?php echo $email; ?>" />
			<input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
			<input type="hidden" name="fax" value="<?php echo $fax; ?>" />
			<button id="button-customer"></button>
		</div>
		<div id="tab-payment" style="display:none;">
			<input type="hidden" name="payment_address" value="" />
			<input type="hidden" name="firstname" value="<?php echo $payment_firstname; ?>" />
			<input type="hidden" name="lastname" value="<?php echo $payment_lastname; ?>" />
			<input type="hidden" name="company" value="<?php echo $payment_company; ?>" />
			<input type="hidden" name="address_1" value="<?php echo $payment_address_1; ?>" />
			<input type="hidden" name="address_2" value="<?php echo $payment_address_2; ?>" />
			<input type="hidden" name="city" value="<?php echo $payment_city; ?>" />
			<input type="hidden" name="postcode" value="<?php echo $payment_postcode; ?>" />
			<input type="hidden" name="country_id" value="<?php echo $payment_country_id; ?>" />
			<input type="hidden" name="zone_id" value="<?php echo $payment_zone_id; ?>" />
			<button id="button-payment-address"></button>
		</div>
		<div id="tab-shipping" style="display:none;">
			<input type="hidden" name="shipping_address" value="" />
			<input type="hidden" name="firstname" value="<?php echo $shipping_firstname; ?>" />
			<input type="hidden" name="lastname" value="<?php echo $shipping_lastname; ?>" />
			<input type="hidden" name="company" value="<?php echo $shipping_company; ?>" />
			<input type="hidden" name="address_1" value="<?php echo $shipping_address_1; ?>" />
			<input type="hidden" name="address_2" value="<?php echo $shipping_address_2; ?>" />
			<input type="hidden" name="city" value="<?php echo $shipping_city; ?>" />
			<input type="hidden" name="postcode" value="<?php echo $shipping_postcode; ?>" />
			<input type="hidden" name="country_id" value="<?php echo $shipping_country_id; ?>" />
			<input type="hidden" name="zone_id" value="<?php echo $shipping_zone_id; ?>" />
			<button id="button-shipping-address"></button>
		</div>
		<div class="row" id="tab-cart" style="margin-bottom:13px;">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-shopping-cart"></i> <?php echo $text_products; ?></h3>
					</div>
					<div class="panel-body">
						<form class="form-horizontal">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<?php $columns = 4; ?>
											<td class="text-left"><?php echo $column_product; ?></td>
											<?php if ($product_column_option) { ?>
												<td class="text-left"><?php echo $column_option; ?></td>
												<?php $columns++; ?>
											<?php } ?>
											<td class="text-left"><?php echo $column_model; ?></td>
											<td class="text-right"><?php echo $column_quantity; ?></td>
											<?php if ($product_column_price) { ?>
												<td class="text-right"><?php echo $column_price; ?></td>
												<?php $columns++; ?>
											<?php } ?>
											<?php if ($product_column_total) { ?>
												<td class="text-right"><?php echo $column_total; ?></td>
												<?php $columns++; ?>
											<?php } ?>
											<?php if ($product_column_notax) { ?>
												<td class="text-center" style="width:10px;"><?php echo $column_notax; ?></td>
												<?php $columns++; ?>
											<?php } ?>
											<?php if ($product_column_pricet) { ?>
												<td class="text-right"><?php echo $column_price_t; ?></td>
												<?php $columns++; ?>
											<?php } ?>
											<?php if ($product_column_totalt) { ?>
												<td class="text-right"><?php echo $column_total_t; ?></td>
												<?php $columns++; ?>
											<?php } ?>
											<td class="text-center"><?php echo $column_action; ?></td>
										</tr>
									</thead>
									<tbody id="cart">
										<?php if ($order_products || $order_vouchers) { ?>
											<?php $product_row = 0; ?>
											<?php foreach ($order_products as $order_product) { ?>
												<tr>
													<td class="text-left">
														<input id="name-<?php echo $product_row; ?>" type="text" name="product[<?php echo $product_row; ?>][name]" value="<?php echo $order_product['name']; ?>" class="form-control" />
														<input id="product-<?php echo $product_row; ?>" type="hidden" name="product[<?php echo $product_row; ?>][product_id]" value="<?php echo $order_product['product_id']; ?>" />
													</td>
													<?php if ($product_column_option) { ?>
														<td class="text-left">
															<?php foreach ($order_product['option'] as $option) { ?>
																- <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
																<?php if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') { ?>
																	<input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['product_option_value_id']; ?>" />
																<?php } ?>
																<?php if ($option['type'] == 'checkbox') { ?>
																	<input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option['product_option_value_id']; ?>" />
																<?php } ?>
																<?php if ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') { ?>
																	<input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" />
																<?php } ?>
															<?php } ?>
														</td>
													<?php } ?>
													<td class="text-left">
														<input id="model-<?php echo $product_row; ?>" type="text" name="product[<?php echo $product_row; ?>][model]" value="<?php echo $order_product['model']; ?>" class="form-control" />
													</td>
													<td class="text-right">
														<input id="quantity-<?php echo $product_row; ?>" style="text-align:right;" type="text" name="product[<?php echo $product_row; ?>][quantity]" value="<?php echo $order_product['quantity']; ?>" class="form-control" />
													</td>
													<?php if ($product_column_price) { ?>
														<td class="text-right">
															<input id="price-<?php echo $product_row; ?>" style="text-align:right;" type="text" name="product[<?php echo $product_row; ?>][price]" value="<?php echo $order_product['price']; ?>" class="form-control" />
														</td>
													<?php } else { ?>
														<input id="price-<?php echo $product_row; ?>" type="hidden" name="product[<?php echo $product_row; ?>][price]" value="<?php echo $order_product['price']; ?>" />
													<?php } ?>
													<?php if ($product_column_total) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<?php if ($product_column_notax) { ?>
														<td class="text-center">
															<?php if ($order_product['notax']) { ?>
																<input id="notax-<?php echo $product_row; ?>" type="checkbox" name="product[<?php echo $product_row; ?>][notax]" value="1" checked="checked" />
															<?php } else { ?>
																<input id="notax-<?php echo $product_row; ?>" type="checkbox" name="product[<?php echo $product_row; ?>][notax]" value="1" />
															<?php } ?>
														</td>
													<?php } else { ?>
														<input id="notax-<?php echo $product_row; ?>" type="hidden" name="product[<?php echo $product_row; ?>][notax]" value="<?php echo $order_product['notax']; ?>" />
													<?php } ?>
													<?php if ($product_column_pricet) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<?php if ($product_column_totalt) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<td class="text-center"></td>
												</tr>
												<?php $product_row++; ?>
											<?php } ?>
											<?php $voucher_row = 0; ?>
											<?php foreach ($order_vouchers as $order_voucher) { ?>
												<tr>
													<td class="text-left">
														<?php echo $order_voucher['description']; ?>
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][voucher_id]" value="<?php echo $order_voucher['voucher_id']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][description]" value="<?php echo $order_voucher['description']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][code]" value="<?php echo $order_voucher['code']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][from_name]" value="<?php echo $order_voucher['from_name']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][from_email]" value="<?php echo $order_voucher['from_email']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][to_name]" value="<?php echo $order_voucher['to_name']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][to_email]" value="<?php echo $order_voucher['to_email']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][voucher_theme_id]" value="<?php echo $order_voucher['voucher_theme_id']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][message]" value="<?php echo $order_voucher['message']; ?>" />
														<input type="hidden" name="voucher[<?php echo $voucher_row; ?>][amount]" value="<?php echo $order_voucher['amount']; ?>" />
													</td>
													<?php if ($product_column_option) { ?>
														<td class="text-left"></td>
													<?php } ?>
													<td class="text-left"></td>
													<td class="text-right">1</td>
													<?php if ($product_column_price) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<?php if ($product_column_total) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<?php if ($product_column_notax) { ?>
														<td class="text-center"></td>
													<?php } ?>
													<?php if ($product_column_pricet) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<?php if ($product_column_totalt) { ?>
														<td class="text-right"></td>
													<?php } ?>
													<td class="text-center"></td>
												</tr>
												<?php $voucher_row++; ?>
											<?php } ?>
										<?php } else { ?>
											<tr>
												<td class="text-center" colspan="<?php echo $columns; ?>"><?php echo $text_no_results; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
								<div class="row">
									<div class="col-sm-6 text-left">&nbsp;</div>
									<div class="col-sm-6 text-right">
										<button style="margin-bottom:13px;" type="button" id="button-add-product" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_product_add; ?></button>
										<button style="margin-bottom:13px;" type="button" id="button-add-voucher" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_voucher_add; ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="tab-total">
			<form class="form-horizontal">
				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-cog"></i> <?php echo $text_order_options; ?></h3>
							</div>
							<div class="panel-body">
								<input type="hidden" name="store_credit" value="<?php echo $store_credit; ?>" />
								<fieldset>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-coupon"><?php echo $entry_coupon; ?></label>
										<div class="col-sm-8">
											<input type="text" name="coupon" value="<?php echo $coupon; ?>" id="input-coupon" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-voucher"><?php echo $entry_voucher; ?></label>
										<div class="col-sm-8">
											<input type="text" name="voucher" value="<?php echo $voucher; ?>" id="input-voucher" data-loading-text="<?php echo $text_loading; ?>" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-reward"><?php echo $entry_reward; ?></label>
										<div class="col-sm-8">
											<input type="text" name="reward" value="<?php echo $reward; ?>" id="input-reward" data-loading-text="<?php echo $text_loading; ?>" class="form-control" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-affiliate"><?php echo $entry_affiliate; ?></label>
										<div class="col-sm-8">
											<input type="text" name="affiliate" value="<?php echo $affiliate; ?>" id="input-affiliate" class="form-control" />
											<input type="hidden" name="affiliate_id" value="<?php echo $affiliate_id; ?>" />
										</div>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-info-circle"></i> <?php echo $text_order_options2; ?></h3>
							</div>
							<div class="panel-body">
								<fieldset>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
										<div class="col-sm-8">
											<select name="order_status_id" id="input-order-status" class="form-control">
												<?php foreach ($order_statuses as $order_status) { ?>
													<?php if ($order_status['order_status_id'] == $order_status_id) { ?>
														<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
											<input type="hidden" name="temp_order_id" value="" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
										<div class="col-sm-8">
											<textarea name="comment" rows="5" id="input-comment" class="form-control"><?php echo $comment; ?></textarea>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-3 control-label" for="input-shipping-method"><?php echo $entry_shipping_method; ?></label>
										<div class="col-sm-8">
											<select name="shipping_method" id="input-shipping-method" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php if ($shipping_code) { ?>
													<option value="<?php echo $shipping_code; ?>" selected="selected"><?php echo $shipping_method; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div id="custom-shipping" class="form-group" style="display:none;">
										<label class="col-sm-3 control-label" for="input-custom-shipping-title"><?php echo $entry_custom_shipping_title; ?></label>
										<div class="col-sm-7">
											<input type="text" name="custom_shipping_title" id="input-custom-shipping-title" value="" class="form-control" />
										</div>
										<br /><br /><br />
										<label class="col-sm-3 control-label" for="input-custom-shipping-cost"><?php echo $entry_custom_shipping_cost; ?></label>
										<div class="col-sm-7">
											<input type="text" name="custom_shipping_cost" id="input-custom-shipping-cost" value="" class="form-control" />
										</div>
										<div class="col-sm-1" style="margin-top:8px;">
											<button type="button" id="button-custom-shipping-apply" title="<?php echo $button_custom_shipping_apply; ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
										</div>
									</div>
									<div class="form-group required">
										<label class="col-sm-3 control-label" for="input-payment-method"><?php echo $entry_payment_method; ?></label>
										<div class="col-sm-7">
											<input type="hidden" name="order_balance" value="<?php echo $order_balance; ?>" />
											<select name="payment_method" id="input-payment-method" class="form-control">
												<option value=""><?php echo $text_select; ?></option>
												<?php if ($payment_code) { ?>
													<option value="<?php echo $payment_code; ?>" selected="selected"><?php echo $payment_method; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-credit-card"></i> <?php echo $text_order_totals; ?></h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody id="total">
											<tr>
												<td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 text-left">&nbsp;</div>
					<div class="col-sm-6 text-right">
						<button style="display:none;" type="button" id="button-refresh" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-warning"><i class="fa fa-refresh"></i></button>
						<button type="button" id="button-save1" class="btn btn-primary"><i class="fa fa-check-circle"></i> <?php echo $button_save; ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript"><!--

		// Currency
		<?php if (version_compare(VERSION, '2.0.2.9', '>')) { ?>
			$('select[name=\'currency\']').on('change', function() {
				$.ajax({
					url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/currency&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
					type: 'post',
					data: 'currency=' + $('select[name=\'currency\'] option:selected').val(),
					dataType: 'json',
					beforeSend: function() {
						$('select[name=\'currency\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
					},
					complete: function() {
						$('.fa-spin').remove();
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							// Highlight any found errors
							$('select[name=\'currency\']').parent().parent().parent().addClass('has-error');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			});
			$('select[name=\'currency\']').trigger('change');
		<?php } ?>

		// Order Entry added functions

		// Startup operations
		function orderStartup() {
			$('#please_wait').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
			setTimeout(function() {
				setCustomer();
			}, 2000);
		}
		if ($('input[name=\'order_id\']').val() > 0) {
			orderStartup();
		}

		// Verify email doesn't already exist when creating a new order
		function checkEmail() {
			$.ajax({
				url: 'index.php?route=sale/order_entry/checkEmail&token=<?php echo $token; ?>&email=' + encodeURIComponent($('input[name=\'email\']').val()),
				type: 'GET',
				dataType: 'json',
				success: function(json) {
					if (json == 'exists') {
						$('input[name=\'email\']').parent().addClass('has-error');
						alert('<?php echo $text_email_exists; ?>');
					} else {
						$('#close-customer-info').trigger('click');
						setCustomerInfo();
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Set customer information
		function setCustomerInfo() {
			$('input[name=\'email\']').parent().removeClass('has-error');
			$('#tab-customer input[name=\'customer_id\']').val($('input[name=\'ci_customer_id\']').val());
			$('#tab-customer select[name=\'customer_group_id\']').val($('input[name=\'customer_group\']').val());
			$('#tab-customer input[name=\'firstname\']').val($('input[name=\'firstname\']').val());
			$('#tab-customer input[name=\'lastname\']').val($('input[name=\'lastname\']').val());
			$('#tab-customer input[name=\'email\']').val($('input[name=\'email\']').val());
			$('#tab-customer input[name=\'telephone\']').val($('input[name=\'telephone\']').val());
			$('#tab-customer input[name=\'fax\']').val($('input[name=\'fax\']').val());
			$('#customer-group').html($('#input-customer-group').children('option:selected').text());
			$('#customer-name').html($('input[name=\'firstname\']').val() + ' ' + $('input[name=\'lastname\']').val());
			$('#customer-email').html($('input[name=\'email\']').val());
			$('#customer-telephone').html($('input[name=\'telephone\']').val());
			$('#customer-fax').html($('input[name=\'fax\']').val());
			if ($('#tab-customer input[name=\'customer_id\']').val() == 0) {
				$('#new-customer').show();
			} else {
				$('#new-customer').hide();
				$('input[name=\'save_customer\']').attr('checked', false);
				$('input[name=\'notify_customer\']').attr('checked', false);
			}
			setCustomer();
		}
		function setCustomer() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/customer&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#tab-customer input[type=\'text\'], #tab-customer input[type=\'hidden\'], #tab-customer input[type=\'radio\']:checked, #tab-customer input[type=\'checkbox\']:checked, #tab-customer select, #tab-customer textarea'),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						if (json['error']['warning']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						for (i in json['error']) {
							var element = $('#input-' + i.replace('_', '-'));
							if (element.parent().hasClass('input-group')) {
								$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
							} else {
								$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
							}
						}
						$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				if ($('input[name=\'order_id\']').val() > 0) {
					if ($('input[name=\'store_credit\']').val() > 0) {
						$.ajax({
							url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order_entry/setStoreCredit&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
							type: 'POST',
							dataType: 'json',
							data: 'store_credit=' + $('input[name=\'store_credit\']').val(),
							crossDomain: true,
							success: function(json) {
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							}
						});
					}
					cartAdd();
					setPaymentAddress();
				}
			});
		}

		// Set payment address
		function setPaymentAddress() {
			$('#tab-payment input[name=\'payment_address\']').val($('select[name=\'payment_address\']').val());
			$('#tab-payment input[name=\'firstname\']').val($('input[name=\'pa_firstname\']').val());
			$('#tab-payment input[name=\'lastname\']').val($('input[name=\'pa_lastname\']').val());
			$('#tab-payment input[name=\'company\']').val($('input[name=\'pa_company\']').val());
			$('#tab-payment input[name=\'address_1\']').val($('input[name=\'pa_address_1\']').val());
			$('#tab-payment input[name=\'address_2\']').val($('input[name=\'pa_address_2\']').val());
			$('#tab-payment input[name=\'city\']').val($('input[name=\'pa_city\']').val());
			$('#tab-payment input[name=\'postcode\']').val($('input[name=\'pa_postcode\']').val());
			$('#tab-payment input[name=\'country_id\']').val($('select[name=\'pa_country_id\']').val());
			$('#tab-payment input[name=\'zone_id\']').val($('select[name=\'pa_zone_id\']').val());
			var pa_address_3 = '';
			if ($('input[name=\'pa_city\']').val().trim() != '') {
				pa_address_3 += $('input[name=\'pa_city\']').val();
				if ($('#input-payment-zone').val() > 0) {
					pa_address_3 += ', ' + $('#input-payment-zone').children('option:selected').text();
				}
				pa_address_3 += ', ' + $('input[name=\'pa_postcode\']').val();
			} else {
				if ($('#input-payment-zone').val() > 0) {
					pa_address_3 += $('#input-payment-zone').children('option:selected').text();
				}
				pa_address_3 += ', ' + $('input[name=\'pa_postcode\']').val();
			}
			$('#pa-company').html($('input[name=\'pa_company\']').val());
			$('#pa-name').html($('input[name=\'pa_firstname\']').val() + ' ' + $('input[name=\'pa_lastname\']').val());
			$('#pa-address-1').html($('input[name=\'pa_address_1\']').val());
			$('#pa-address-2').html($('input[name=\'pa_address_2\']').val());
			$('#pa-address-3').html(pa_address_3);
			$('#pa-country').html($('#input-payment-country').children('option:selected').text());
			$('#button-payment-address').trigger('click');
		}

		// Set shipping address using payment address
		function setShippingAddress1() {
			$('#tab-shipping input[name=\'shipping_address\']').val($('select[name=\'payment_address\']').val());
			$('#tab-shipping input[name=\'firstname\']').val($('input[name=\'pa_firstname\']').val());
			$('#tab-shipping input[name=\'lastname\']').val($('input[name=\'pa_lastname\']').val());
			$('#tab-shipping input[name=\'company\']').val($('input[name=\'pa_company\']').val());
			$('#tab-shipping input[name=\'address_1\']').val($('input[name=\'pa_address_1\']').val());
			$('#tab-shipping input[name=\'address_2\']').val($('input[name=\'pa_address_2\']').val());
			$('#tab-shipping input[name=\'city\']').val($('input[name=\'pa_city\']').val());
			$('#tab-shipping input[name=\'postcode\']').val($('input[name=\'pa_postcode\']').val());
			$('#tab-shipping input[name=\'country_id\']').val($('select[name=\'pa_country_id\']').val());
			$('#tab-shipping input[name=\'zone_id\']').val($('select[name=\'pa_zone_id\']').val());
			$('#input-shipping-firstname').val($('input[name=\'pa_firstname\']').val());
			$('#input-shipping-lastname').val($('input[name=\'pa_lastname\']').val());
			$('#input-shipping-company').val($('input[name=\'pa_company\']').val());
			$('#input-shipping-address-1').val($('input[name=\'pa_address_1\']').val());
			$('#input-shipping-address-2').val($('input[name=\'pa_address_2\']').val());
			$('#input-shipping-city').val($('input[name=\'pa_city\']').val());
			$('#input-shipping-postcode').val($('input[name=\'pa_postcode\']').val());
			$('#input-shipping-country').val($('select[name=\'pa_country_id\']').val());
			$('#input-shipping-zone').val($('select[name=\'pa_zone_id\']').val());
			var sa_address_3 = '';
			if ($('input[name=\'pa_city\']').val().trim() != '') {
				sa_address_3 += $('input[name=\'pa_city\']').val();
				if ($('#input-payment-zone').val() > 0) {
					sa_address_3 += ', ' + $('#input-payment-zone').children('option:selected').text();
				}
				sa_address_3 += ', ' + $('input[name=\'pa_postcode\']').val();
			} else {
				if ($('#input-payment-zone').val() > 0) {
					sa_address_3 += $('#input-payment-zone').children('option:selected').text();
				}
				sa_address_3 += ', ' + $('input[name=\'pa_postcode\']').val();
			}
			$('#sa-company').html($('input[name=\'pa_company\']').val());
			$('#sa-name').html($('input[name=\'pa_firstname\']').val() + ' ' + $('input[name=\'pa_lastname\']').val());
			$('#sa-address-1').html($('input[name=\'pa_address_1\']').val());
			$('#sa-address-2').html($('input[name=\'pa_address_2\']').val());
			$('#sa-address-3').html(sa_address_3);
			$('#sa-country').html($('#input-payment-country').children('option:selected').text());
			$('#button-shipping-address').trigger('click');
		}

		// Set shipping address using the shipping address
		function setShippingAddress2() {
			$('#tab-shipping input[name=\'shipping_address\']').val($('select[name=\'shipping_address\']').val());
			$('#tab-shipping input[name=\'firstname\']').val($('input[name=\'sa_firstname\']').val());
			$('#tab-shipping input[name=\'lastname\']').val($('input[name=\'sa_lastname\']').val());
			$('#tab-shipping input[name=\'company\']').val($('input[name=\'sa_company\']').val());
			$('#tab-shipping input[name=\'address_1\']').val($('input[name=\'sa_address_1\']').val());
			$('#tab-shipping input[name=\'address_2\']').val($('input[name=\'sa_address_2\']').val());
			$('#tab-shipping input[name=\'city\']').val($('input[name=\'sa_city\']').val());
			$('#tab-shipping input[name=\'postcode\']').val($('input[name=\'sa_postcode\']').val());
			$('#tab-shipping input[name=\'country_id\']').val($('select[name=\'sa_country_id\']').val());
			$('#tab-shipping input[name=\'zone_id\']').val($('select[name=\'sa_zone_id\']').val());
			$('#input-shipping-firstname').val($('input[name=\'sa_firstname\']').val());
			$('#input-shipping-lastname').val($('input[name=\'sa_lastname\']').val());
			$('#input-shipping-company').val($('input[name=\'sa_company\']').val());
			$('#input-shipping-address-1').val($('input[name=\'sa_address_1\']').val());
			$('#input-shipping-address-2').val($('input[name=\'sa_address_2\']').val());
			$('#input-shipping-city').val($('input[name=\'sa_city\']').val());
			$('#input-shipping-postcode').val($('input[name=\'sa_postcode\']').val());
			$('#input-shipping-country').val($('select[name=\'sa_country_id\']').val());
			$('#input-shipping-zone').val($('select[name=\'sa_zone_id\']').val());
			var sa_address_3 = '';
			if ($('input[name=\'sa_city\']').val().trim() != '') {
				sa_address_3 += $('input[name=\'sa_city\']').val();
				if ($('#input-shipping-zone').val() > 0) {
					sa_address_3 += ', ' + $('#input-shipping-zone').children('option:selected').text();
				}
				sa_address_3 += ', ' + $('input[name=\'sa_postcode\']').val();
			} else {
				if ($('#input-shipping-zone').val() > 0) {
					sa_address_3 += $('#input-shipping-zone').children('option:selected').text();
				}
				sa_address_3 += ', ' + $('input[name=\'sa_postcode\']').val();
			}
			$('#sa-company').html($('input[name=\'sa_company\']').val());
			$('#sa-name').html($('input[name=\'sa_firstname\']').val() + ' ' + $('input[name=\'sa_lastname\']').val());
			$('#sa-address-1').html($('input[name=\'sa_address_1\']').val());
			$('#sa-address-2').html($('input[name=\'sa_address_2\']').val());
			$('#sa-address-3').html(sa_address_3);
			$('#sa-country').html($('#input-shipping-country').children('option:selected').text());
			$('#button-shipping-address').trigger('click');
		}

		// Add products to cart when editing orders
		function cartAdd() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/cart/add&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#cart input[name^=\'product\'][type=\'text\'], #cart input[name^=\'product\'][type=\'hidden\'], #cart input[name^=\'product\'][type=\'radio\']:checked, #cart input[name^=\'product\'][type=\'checkbox\']:checked, #cart select[name^=\'product\'], #cart textarea[name^=\'product\']'),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error'] && json['error']['warning']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Add vouchers to cart when editing orders
		function voucherAdd() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/voucher/add&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#cart input[name^=\'voucher\'][type=\'text\'], #cart input[name^=\'voucher\'][type=\'hidden\'], #cart input[name^=\'voucher\'][type=\'radio\']:checked, #cart input[name^=\'voucher\'][type=\'checkbox\']:checked, #cart select[name^=\'voucher\'], #cart textarea[name^=\'voucher\']'),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error'] && json['error']['warning']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Payment methods
		function getPaymentMethods() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/payment/methods&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					} else {
						html = '<option value=""><?php echo $text_select; ?></option>';
						if (json['payment_methods']) {
							for (i in json['payment_methods']) {
								if (json['payment_methods'][i]['code'] == $('select[name=\'payment_method\'] option:selected').val()) {
									html += '<option value="' + json['payment_methods'][i]['code'] + '" selected="selected">' + json['payment_methods'][i]['title'] + '</option>';
								} else {
									html += '<option value="' + json['payment_methods'][i]['code'] + '">' + json['payment_methods'][i]['title'] + '</option>';
								}
							}
						}
						$('select[name=\'payment_method\']').html(html);
						if ($('input[name=\'order_id\']').val() > 0) {
							$('#input-payment-method').trigger('change');
						} else {
							getShippingMethods();
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Get Shipping Methods
		function getShippingMethods() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/shipping/methods&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				dataType: 'json',
				success: function(json) {
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					} else {
						html = '<option value=""><?php echo $text_select; ?></option>';
						if (json['shipping_methods']) {
							for (i in json['shipping_methods']) {
								html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';
								if (!json['shipping_methods'][i]['error']) {
									for (j in json['shipping_methods'][i]['quote']) {
										if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name=\'shipping_method\'] option:selected').val()) {
											html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
										} else {
											html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
										}
									}
								} else {
									html += '<option value="" style="color: #F00;" disabled="disabled">' + json['shipping_methods'][i]['error'] + '</option>';
								}
								html += '</optgroup>';
							}
						}
						$('select[name=\'shipping_method\']').html(html);
						if (($('input[name=\'order_id\']').val() > 0 && json['shipping_methods']) || $('select[name=\'shipping_method\']').val() != '') {
							$('#input-shipping-method').trigger('change');
						} else {
							$('#button-refresh').trigger('click');
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Check for valid customer and address before allowing product to be added to order
		function customerValidate() {
			if ($('#customer-information input[name=\'firstname\']').val().trim() == '') {
				return false;
			}
			if ($('#customer-information input[name=\'lastname\']').val().trim() == '') {
				return false;
			}
			<?php if ($oe_require_email) { ?>
				if ($('#customer-information input[name=\'email\']').val().trim() == '') {
					return false;
				}
			<?php } ?>
			<?php if ($oe_require_telephone) { ?>
				if ($('#customer-information input[name=\'telephone\']').val().trim() == '') {
					return false;
				}
			<?php } ?>
			if ($('#customer-address input[name=\'pa_firstname\']').val().trim() == '') {
				return false;
			}
			if ($('#customer-address input[name=\'pa_lastname\']').val().trim() == '') {
				return false;
			}
			if ($('#customer-address input[name=\'pa_address_1\']').val().trim() == '') {
				return false;
			}
			<?php if ($oe_require_city) { ?>
				if ($('#customer-address input[name=\'pa_city\']').val().trim() == '') {
					return false;
				}
			<?php } ?>
			if ($('#customer-address select[name=\'pa_country_id\']').val() < 1) {
				return false;
			}
			<?php if ($oe_require_zone) { ?>
				if ($('#customer-address select[name=\'pa_zone_id\']').val() < 1) {
					return false;
				}
			<?php } ?>
			if ($('#customer-saddress input[name=\'sa_firstname\']').val().trim() == '') {
				return false;
			}
			if ($('#customer-saddress input[name=\'sa_lastname\']').val().trim() == '') {
				return false;
			}
			if ($('#customer-saddress input[name=\'sa_address_1\']').val().trim() == '') {
				return false;
			}
			<?php if ($oe_require_city) { ?>
				if ($('#customer-saddress input[name=\'sa_city\']').val().trim() == '') {
					return false;
				}
			<?php } ?>
			if ($('#customer-saddress select[name=\'sa_country_id\']').val() < 1) {
				return false;
			}
			<?php if ($oe_require_zone) { ?>
				if ($('#customer-saddress select[name=\'sa_zone_id\']').val() < 1) {
					return false;
				}
			<?php } ?>
			return true;
		}

		// Cancel order creation
		function cancel() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order/clearcart&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				dataType: 'json',
				complete: function() {
					var str = '<?php echo $cancel; ?>';
					var href_loc = str.replace('&amp;', '&');
					location.href = href_loc;
				}
			});
		}

		// End Order Entry functions


		// Add or edit customer information
		$('#edit-customer-info').on('click', function() {
			$('#customer-information').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
		});
		$('#close-customer-info1').on('click', function() {
			$('#close-customer-info').trigger('click');
		});
		$('#close-customer-info').on('click', function() {
			$('#customer-information').hide();
			$('#grey_screen').hide();
			$('body').css({'overflow':'auto'});
		});
		$('#button-customer-info').on('click', function() {
			if ($('input[name=\'customer_id\']').val() == 0) {
				checkEmail();
			} else {
				$('#close-customer-info').trigger('click');
				setCustomerInfo();
			}
		});

		// Add - Edit Customer Payment Address
		$('#edit-customer-addr').on('click', function() {
			$('#customer-address').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
		});
		$('#close-customer-addr1').on('click', function() {
			$('#close-customer-addr').trigger('click');
		});
		$('#close-customer-addr').on('click', function() {
			$('#customer-address').hide();
			$('#grey_screen').hide();
			$('body').css({'overflow':'auto'});
		});
		$('#button-save-customer-addr').on('click', function() {
			$('#close-customer-addr').trigger('click');
			setPaymentAddress();
		});
		$('input[name=\'shipping_same_payment\']').on('click', function() {
			var shipping_same = $(this).prop('checked');
			if (shipping_same) {
				$('#edit-customer-saddr').hide();
				$('#shipping-address').hide();
				if ($('input[name=\'customer_id\']').val() > 0) {
					$('select[name=\'shipping_address\']').val($('select[name=\'payment_address\']').val());
				}
				$('#grey_screen').hide();
				$('body').css({'overflow':'auto'});
				setShippingAddress1();
			} else {
				$('#edit-customer-saddr').show();
				if ($('input[name=\'customer_id\']').val() > 0) {
					$('#shipping-address').show();
					$('#customer-saddress').hide();
					$('#grey_screen').hide();
					$('body').css({'overflow':'auto'});
					$('select[name=\'shipping_address\']').val('0');
				} else {
					$('#shipping-address').hide();
					$('#customer-saddress').show();
					$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
					$('#grey_screen').show();
					$('body').css({'overflow':'hidden'});
				}
			}
		});

		// Add - Edit Customer Shipping Address
		$('#edit-customer-saddr').on('click', function() {
			$('#customer-saddress').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
		});
		$('#close-customer-saddr1').on('click', function() {
			$('#close-customer-saddr').trigger('click');
		});
		$('#close-customer-saddr').on('click', function() {
			$('#customer-saddress').hide();
			$('#grey_screen').hide();
			$('body').css({'overflow':'auto'});
		});
		$('#button-save-customer-saddr').on('click', function() {
			$('#close-customer-saddr').trigger('click');
			$('select[name=\'shipping_address\']').val('0');
			setShippingAddress2();
			if ($('input[name=\'customer_id\']').val() > 0) {
				$('#new-address').show();
			} else {
				$('#new-address').hide();
			}
		});

		// Set Payment Address Country and Zone
		var payment_zone_id = '<?php echo $payment_zone_id; ?>';
		$('select[name=\'pa_country_id\']').on('change', function() {
			var same_shipping = $('input[name=\'shipping_same_payment\']').prop('checked');
			$.ajax({
				url: 'index.php?route=sale/order/country&token=<?php echo $token; ?>&country_id=' + this.value,
				dataType: 'json',
				success: function(json) {
					if (json['postcode_required'] == '1') {
						$('input[name=\'pa_postcode\']').parent().parent().addClass('required');
					} else {
						$('input[name=\'pa_postcode\']').parent().parent().removeClass('required');
					}
					html = '<option value=""><?php echo $text_select; ?></option>';
					if (json['zone'] && json['zone'] != '') {
						for (i = 0; i < json['zone'].length; i++) {
							html += '<option value="' + json['zone'][i]['zone_id'] + '"';
							if (json['zone'][i]['zone_id'] == payment_zone_id) {
								html += ' selected="selected"';
							}
							html += '>' + json['zone'][i]['name'] + '</option>';
						}
					} else {
						html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
					}
					$('select[name=\'pa_zone_id\']').html(html);
					var same_shipping = $('input[name=\'shipping_same_payment\']').prop('checked');
					if (same_shipping) {
						$('select[name=\'sa_zone_id\']').html(html);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		$('select[name=\'pa_country_id\']').trigger('change');

		// Set Shipping Address Country and Zone
		var shipping_zone_id = '<?php echo $shipping_zone_id; ?>';
		$('select[name=\'sa_country_id\']').on('change', function() {
			$.ajax({
				url: 'index.php?route=sale/order/country&token=<?php echo $token; ?>&country_id=' + this.value,
				dataType: 'json',
				success: function(json) {
					if (json['postcode_required'] == '1') {
						$('input[name=\'sa_postcode\']').parent().parent().addClass('required');
					} else {
						$('input[name=\'sa_postcode\']').parent().parent().removeClass('required');
					}
					html = '<option value=""><?php echo $text_select; ?></option>';
					if (json['zone'] && json['zone'] != '') {
						for (i = 0; i < json['zone'].length; i++) {
							html += '<option value="' + json['zone'][i]['zone_id'] + '"';
							if (json['zone'][i]['zone_id'] == shipping_zone_id) {
								html += ' selected="selected"';
							}
							html += '>' + json['zone'][i]['name'] + '</option>';
						}
					} else {
						html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
					}
					$('select[name=\'sa_zone_id\']').html(html);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});
		$('select[name=\'sa_country_id\']').trigger('change');

		// Payment Address change
		$('select[name=\'payment_address\']').on('change', function() {
			var same_shipping = $('input[name=\'shipping_same_payment\']').prop('checked');
			$.ajax({
				url: 'index.php?route=sale/customer/address&token=<?php echo $token; ?>&address_id=' + this.value,
				dataType: 'json',
				beforeSend: function(json) {
					$('#please_wait').show();
					$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
					$('#grey_screen').show();
					$('body').css({'overflow':'hidden'});
				},
				success: function(json) {
					$('input[name=\'pa_firstname\']').val(json['firstname']);
					$('input[name=\'pa_lastname\']').val(json['lastname']);
					$('input[name=\'pa_company\']').val(json['company']);
					$('input[name=\'pa_address_1\']').val(json['address_1']);
					$('input[name=\'pa_address_2\']').val(json['address_2']);
					$('input[name=\'pa_city\']').val(json['city']);
					$('input[name=\'pa_postcode\']').val(json['postcode']);
					$('select[name=\'pa_country_id\']').val(json['country_id']);
					payment_zone_id = json['zone_id'];
					$('select[name=\'pa_country_id\']').trigger('change');
					if (same_shipping) {
						$('select[name=\'shipping_address\']').val($('select[name=\'payment_address\']').val());
						$('input[name=\'sa_firstname\']').val(json['firstname']);
						$('input[name=\'sa_lastname\']').val(json['lastname']);
						$('input[name=\'sa_company\']').val(json['company']);
						$('input[name=\'sa_address_1\']').val(json['address_1']);
						$('input[name=\'sa_address_2\']').val(json['address_2']);
						$('input[name=\'sa_city\']').val(json['city']);
						$('input[name=\'sa_postcode\']').val(json['postcode']);
						$('select[name=\'sa_country_id\']').val(json['country_id']);
						shipping_zone_id = json['zone_id'];
						$('select[name=\'sa_country_id\']').trigger('change');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				setTimeout(function() {
					setPaymentAddress();
				}, 2000);
			});
		});

		$('input[name=\'custom_price\']').on('click', function() {
			var checked = $(this).prop('checked');
			if (checked) {
				$('#input-price').removeAttr('disabled');
			} else {
				$('#input-price').attr('disabled', 'disabled');
			}
		});

		// Update payment address
		$('#button-payment-address').on('click', function() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/payment/address&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#tab-payment input[type=\'text\'], #tab-payment input[type=\'hidden\'], #tab-payment input[type=\'radio\']:checked, #tab-payment input[type=\'checkbox\']:checked, #tab-payment select, #tab-payment textarea'),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						if (json['error']['warning']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						for (i in json['error']) {
							var element = $('#input-payment-' + i.replace('_', '-'));
							if ($(element).parent().hasClass('input-group')) {
								$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
							} else {
								$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
							}
						}
						$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				var same_shipping = $('input[name=\'shipping_same_payment\']').prop('checked');
				if (same_shipping) {
					setShippingAddress1();
				} else {
					setShippingAddress2();
				}
			});
		});

		// Shipping Address change
		$('select[name=\'shipping_address\']').on('change', function() {
			$.ajax({
				url: 'index.php?route=sale/customer/address&token=<?php echo $token; ?>&address_id=' + this.value,
				dataType: 'json',
				beforeSend: function() {
					$('#please_wait').show();
					$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
					$('#grey_screen').show();
					$('body').css({'overflow':'hidden'});
				},
				success: function(json) {
					$('#tab-shipping input[name=\'firstname\']').val(json['firstname']);
					$('#tab-shipping input[name=\'lastname\']').val(json['lastname']);
					$('#tab-shipping input[name=\'company\']').val(json['company']);
					$('#tab-shipping input[name=\'address_1\']').val(json['address_1']);
					$('#tab-shipping input[name=\'address_2\']').val(json['address_2']);
					$('#tab-shipping input[name=\'city\']').val(json['city']);
					$('#tab-shipping input[name=\'postcode\']').val(json['postcode']);
					$('#tab-shipping input[name=\'country_id\']').val(json['country_id']);
					$('#tab-shipping input[name=\'zone_id\']').val(json['zone_id']);
					$('input[name=\'sa_firstname\']').val(json['firstname']);
					$('input[name=\'sa_lastname\']').val(json['lastname']);
					$('input[name=\'sa_company\']').val(json['company']);
					$('input[name=\'sa_address_1\']').val(json['address_1']);
					$('input[name=\'sa_address_2\']').val(json['address_2']);
					$('input[name=\'sa_city\']').val(json['city']);
					$('input[name=\'sa_postcode\']').val(json['postcode']);
					$('select[name=\'sa_country_id\']').val(json['country_id']);
					shipping_zone_id = json['zone_id'];
					$('select[name=\'sa_country_id\']').trigger('change');
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				setTimeout(function() {
					setShippingAddress2();
				}, 2000);
			});
		});

		// Update shipping address
		$('#button-shipping-address').on('click', function() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/shipping/address&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#tab-shipping input[type=\'text\'], #tab-shipping input[type=\'hidden\'], #tab-shipping input[type=\'radio\']:checked, #tab-shipping input[type=\'checkbox\']:checked, #tab-shipping select, #tab-shipping textarea'),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						if (json['error']['warning']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						for (i in json['error']) {
							var element = $('#input-shipping-' + i.replace('_', '-'));
							if ($(element).parent().hasClass('input-group')) {
								$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
							} else {
								$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
							}
						}
						$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				getPaymentMethods();
			});
		});

		$('#button-custom-shipping-apply').on('click', function() {
			$('#please_wait').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order_entry/applyCustomShipping&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'POST',
				dataType: 'json',
				data: 'title=' + encodeURIComponent($('input[name=\'custom_shipping_title\']').val()) + '&cost=' + $('input[name=\'custom_shipping_cost\']').val(),
				success: function(json) {
					html = '<option value=""><?php echo $text_select; ?></option>';
					if (json['shipping_methods']) {
						for (i in json['shipping_methods']) {
							html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';
							if (!json['shipping_methods'][i]['error']) {
								for (j in json['shipping_methods'][i]['quote']) {
									if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name=\'shipping_method\'] option:selected').val()) {
										html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
									} else {
										html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
									}
								}
							} else {
								html += '<option value="" style="color: #F00;" disabled="disabled">' + json['shipping_methods'][i]['error'] + '</option>';
							}
							html += '</optgroup>';
						}
					}
					$('select[name=\'shipping_method\']').html(html);
					$.ajax({
						url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/shipping/method&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
						type: 'post',
						data: 'shipping_method=' + $('select[name=\'shipping_method\'] option:selected').val(),
						dataType: 'json',
						crossDomain: true,
						beforeSend: function() {
							$('#input-shipping-method').attr('disabled', 'disabled');
						},
						complete: function() {
							$('#input-shipping-method').removeAttr('disabled');
						},
						success: function(json) {
							$('.alert, .text-danger').remove();
							$('.form-group').removeClass('has-error');
							if (json['error']) {
								$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								$('select[name=\'shipping_method\']').parent().parent().addClass('has-error');
							}
							if (json['success']) {
								$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
								$('#button-refresh').trigger('click');
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		// Add product popup functions
		$('#close-add-product1').on('click', function() {
			$('#close-add-product').trigger('click');
		});
		$('#close-add-product').on('click', function() {
			$('#add-product').hide();
			$('#grey_screen').hide();
			$('body').css({'overflow':'auto'});
		});
		$('#button-add-product').on('click', function() {
			if (customerValidate()) {
				$('#add-product').show();
				$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
				$('#grey_screen').show();
				$('body').css({'overflow':'hidden'});
			} else {
				alert('<?php echo $text_customer_error; ?>');
				return false;
			}
		});

		// Add voucher popup functions
		$('#close-add-voucher1').on('click', function() {
			$('#close-add-voucher').trigger('click');
		});
		$('#close-add-voucher').on('click', function() {
			$('#add-voucher').hide();
			$('#grey_screen').hide();
			$('body').css({'overflow':'auto'});
		});
		$('#button-add-voucher').on('click', function() {
			$('#add-voucher').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
		});

		// Product update functions
		var typingTimer;
		var doneTypingInterval = 900;
		$('#tab-cart').delegate('.btn-default', 'click', function() {
			var prow = $(this).val();
			var post_data = 'key=' + $('#quantity-' + prow).attr('rel');
			post_data += '&product_id=' + $('#product-' + prow).val();
			post_data += '&name=' + encodeURIComponent($('#name-' + prow).val());
			post_data += '&model=' + encodeURIComponent($('#model-' + prow).val());
			post_data += '&price=' + $('#price-' + prow).val();
			post_data += '&quantity=' + $('#quantity-' + prow).val();
			var notax = 0;
			if ($('#notax-' + prow).is(':checked')) {
				notax = 1;
			}
			post_data += '&notax=' + notax;
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/cart/edit&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				dataType: 'json',
				data: post_data,
				crossDomain: true,
				success: function(json) {
					$('.alert-danger, .text-danger').remove();
					if (json['error']) {
						if (json['error']['warning']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				var same_shipping = $('input[name=\'shipping_same_payment\']').prop('checked');
				if (same_shipping) {
					setShippingAddress1();
				} else {
					setShippingAddress2();
				}
			});
		});

		// Add all products to the cart using the api
		$('#button-refresh').on('click', function() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/cart/products&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				dataType: 'json',
				crossDomain: true,
				success: function(json) {
					$('.alert-danger, .text-danger').remove();
					if (json['error']) {
						if (json['error']['warning']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						if (json['error']['stock']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['stock'] + '</div>');
						}
						if (json['error']['minimum']) {
							for (i in json['error']['minimum']) {
								$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['minimum'][i] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
						}
					}
					var shipping = false;
					html = '';
					var p_columns = 4;
					<?php if ($product_column_option) { ?>
						p_columns++;
					<?php } ?>
					<?php if ($product_column_price) { ?>
						p_columns++;
					<?php } ?>
					<?php if ($product_column_total) { ?>
						p_columns++;
					<?php } ?>
					<?php if ($product_column_pricet) { ?>
						p_columns++;
					<?php } ?>
					<?php if ($product_column_totalt) { ?>
						p_columns++;
					<?php } ?>
					if (json['products'].length) {
						for (i = 0; i < json['products'].length; i++) {
							product = json['products'][i];
							html += '<tr>';
							html += '  <td class="text-left"><input id="name-' + i + '" type="text" name="product[' + i + '][name]" value="' + product['name'] + '" class="form-control" />' + (!product['stock'] ? '<span class="text-danger">***</span>' : '');
							html += '  <input id="product-' + i + '" type="hidden" name="product[' + i + '][product_id]" value="' + product['product_id'] + '" />';
							html += '  </td>';
							<?php if ($product_column_option) { ?>
								html += '  <td class="text-left">';
								if (product['option']) {
									for (j = 0; j < product['option'].length; j++) {
										option = product['option'][j];
										html += '  - <small>' + option['name'] + ': ' + option['value'] + '</small><br />';
										if (option['type'] == 'select' || option['type'] == 'radio' || option['type'] == 'image') {
											html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + ']" value="' + option['product_option_value_id'] + '" />';
										}
										if (option['type'] == 'checkbox') {
											html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + '][]" value="' + option['product_option_value_id'] + '" />';
										}
										if (option['type'] == 'text' || option['type'] == 'textarea' || option['type'] == 'file' || option['type'] == 'date' || option['type'] == 'datetime' || option['type'] == 'time') {
											html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" />';
										}
									}
								}
								html += '</td>';
							<?php } ?>
							html += '  <td class="text-left"><input id="model-' + i + '" type="text" name="product[' + i + '][model]" value="' + product['model'] + '" class="form-control" /></td>';
							html += '  <td class="text-right"><input id="quantity-' + i + '" rel="' + product['key'] + '" style="text-align:right;" type="text" name="product[' + i + '][quantity]" value="' + product['quantity'] + '" class="form-control" /></td>';
							<?php if ($product_column_price) { ?>
								html += '  <td class="text-right"><input id="price-' + i + '" style="text-align:right;" type="text" name="product[' + i + '][price]" value="' + product['price'] + '" class="form-control" /></td>';
							<?php } else { ?>
								html += '  <input id="price-' + i + '" type="hidden" name="product[' + i + '][price]" value="' + product['price'] + '" />';
							<?php } ?>
							<?php if ($product_column_total) { ?>
								html += '  <td class="text-right">' + product['total'] + '</td>';
							<?php } ?>
							<?php if ($product_column_notax) { ?>
								html += '  <td class="text-center">';
								if (product['notax'] == 1) {
									html += '    <input id="notax-' + i + '" type="checkbox" name="product[' + i + '][notax]" value="1" checked="checked" />';
								} else {
									html += '    <input id="notax-' + i + '" type="checkbox" name="product[' + i + '][notax]" value="1" />';
								}
								html += '  </td>';
							<?php } else { ?>
								html += '  <input id="notax-' + i + '" type="hidden" name="product[' + i + '][notax]" value="' + product['notax'] + '" />';
							<?php } ?>
							<?php if ($product_column_pricet) { ?>
								html += '  <td class="text-right">' + product['price_t'] + '</td>';
							<?php } ?>
							<?php if ($product_column_totalt) { ?>
								html += '  <td class="text-right">' + product['total_t'] + '</td>';
							<?php } ?>
							html += '  <td class="text-center" style="width:100px;"><button style="margin-right:5px;" type="button" value="' + i + '" data-toggle="tooltip" title="<?php echo $button_update; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-refresh"></i></button><button type="button" value="' + i + '" data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
							html += '</tr>';
							if (product['shipping'] != 0) {
								shipping = true;
							}
						}
					}
					if (!shipping) {
						$('select[name=\'shipping_method\'] option').removeAttr('selected');
						$('select[name=\'shipping_method\']').prop('disabled', true);
					} else {
						$('select[name=\'shipping_method\']').prop('disabled', false);
					}
					if (json['vouchers'].length) {
						for (i in json['vouchers']) {
							voucher = json['vouchers'][i];
							html += '<tr>';
							html += '  <td class="text-left">' + voucher['description'];
							html += '    <input type="hidden" name="voucher[' + i + '][code]" value="' + voucher['code'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][description]" value="' + voucher['description'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][from_name]" value="' + voucher['from_name'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][from_email]" value="' + voucher['from_email'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][to_name]" value="' + voucher['to_name'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][to_email]" value="' + voucher['to_email'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][voucher_theme_id]" value="' + voucher['voucher_theme_id'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][message]" value="' + voucher['message'] + '" />';
							html += '    <input type="hidden" name="voucher[' + i + '][amount]" value="' + voucher['amount'] + '" />';
							html += '  </td>';
							<?php if ($product_column_option) { ?>
								html += '  <td class="text-left"></td>';
							<?php } ?>
							html += '  <td class="text-left"></td>';
							html += '  <td class="text-right">1</td>';
							<?php if ($product_column_price) { ?>
								html += '  <td class="text-right">' + voucher['amount'] + '</td>';
							<?php } ?>
							<?php if ($product_column_total) { ?>
								html += '  <td class="text-center"></td>';
							<?php } ?>
							<?php if ($product_column_notax) { ?>
								html += '  <td class="text-center"></td>';
							<?php } ?>
							<?php if ($product_column_pricet) { ?>
								html += '  <td class="text-right">' + voucher['amount'] + '</td>';
							<?php } ?>
							<?php if ($product_column_totalt) { ?>
								html += '  <td class="text-right">' + voucher['amount'] + '</td>';
							<?php } ?>
							html += '  <td class="text-center" style="width: 3px;"><button type="button" value="' + voucher['code'] + '" data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
							html += '</tr>';
						}
					}
					if (!json['products'].length && !json['vouchers'].length) {
						html += '<tr>';
						html += '  <td colspan="' + p_columns + '" class="text-center"><?php echo $text_no_results; ?></td>';
						html += '</tr>';
					}
					$('#cart').html(html);
					// Totals
					html = '';
					if (json['totals'].length) {
						for (i in json['totals']) {
							total = json['totals'][i];
							html += '<tr>';
							html += '  <td class="text-right" colspan="4"><b>' + total['title'] + ':</b></td>';
							html += '  <td class="text-right">' + total['text'] + '</td>';
							html += '</tr>';
						}
					}
					if (!json['totals'].length) {
						html += '<tr>';
						html += '  <td colspan="5" class="text-center"><?php echo $text_no_results; ?></td>';
						html += '</tr>';
					}
					$('#total').html(html);
					$('input[name=\'order_balance\']').val(json['balance']);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				$('#please_wait').hide()
				$('#grey_screen').hide();
				$('body').css({'overflow':'auto'});
			});
		});

		// Customer autocomplete
		$('input[name=\'customer\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							customer_id: '0',
							customer_group_id: '<?php echo $customer_group_id; ?>',
							name: '<?php echo $text_none; ?>',
							customer_group: '',
							firstname: '',
							lastname: '',
							email: '',
							telephone: '',
							fax: '',
							custom_field: [],
							address: []
						});
						response($.map(json, function(item) {
							return {
								category: item['customer_group'],
								label: item['name'],
								value: item['customer_id'],
								customer_group_id: item['customer_group_id'],
								firstname: item['firstname'],
								lastname: item['lastname'],
								email: item['email'],
								telephone: item['telephone'],
								fax: item['fax'],
								custom_field: item['custom_field'],
								address: item['address']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'customer\']').val(item['label']);
				$('input[name=\'ci_customer_id\']').val(item['value']);
				$('input[name=\'firstname\']').val(item['firstname']);
				$('input[name=\'lastname\']').val(item['lastname']);
				$('input[name=\'email\']').val(item['email']);
				$('input[name=\'telephone\']').val(item['telephone']);
				$('input[name=\'fax\']').val(item['fax']);
				if (item['value'] > 0) {
					$('#new-customer').hide();
					$('input[name=\'save_customer\']').attr('checked', false);
					$('input[name=\'notify_customer\']').attr('checked', false);
				} else {
					$('#new-customer').show();
				}
				$('#tab-customer input[name=\'customer_id\']').val(item['value']);
				$('#tab-customer select[name=\'customer_group_id\']').val(item['customer_group_id']);
				$('#tab-customer input[name=\'firstname\']').val(item['firstname']);
				$('#tab-customer input[name=\'lastname\']').val(item['lastname']);
				$('#tab-customer input[name=\'email\']').val(item['email']);
				$('#tab-customer input[name=\'telephone\']').val(item['telephone']);
				$('#tab-customer input[name=\'fax\']').val(item['fax']);
				var addresses = 0;
				html = '<option value="0"><?php echo $text_none; ?></option>';
				for (i in  item['address']) {
					addresses++;
					if (item['address'][i]['city'] != '') {
						html += '<option value="' + item['address'][i]['address_id'] + '">' + item['address'][i]['firstname'] + ' ' + item['address'][i]['lastname'] + ', ' + item['address'][i]['address_1'] + ', ' + item['address'][i]['city'] + ', ' + item['address'][i]['country'] + '</option>';
					} else {
						html += '<option value="' + item['address'][i]['address_id'] + '">' + item['address'][i]['firstname'] + ' ' + item['address'][i]['lastname'] + ', ' + item['address'][i]['address_1'] + ', ' + item['address'][i]['country'] + '</option>';
					}
				}
				if (addresses) {
					$('select[name=\'payment_address\']').html(html);
					$('select[name=\'shipping_address\']').html(html);
					$('#payment-address').show();
					var same_shipping = $('input[name=\'shipping_same_payment\']').attr('checked');
					if (same_shipping) {
						$('#shipping-address').hide();
					} else {
						$('#shipping-address').show();
					}
				}
			}
		});

		// Product autocomplete
		$('#tab-product input[name=\'product\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=sale/order_entry/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['product_id'],
								model: item['model'],
								option: item['option'],
								price: item['price']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('#tab-product input[name=\'product\']').val(item['label']);
				$('#tab-product input[name=\'product_id\']').val(item['value']);
				if (item['option'] != '') {
					html  = '<fieldset>';
					for (i = 0; i < item['option'].length; i++) {
						option = item['option'][i];
						if (option['type'] == 'select') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10">';
							html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
							html += '      <option value=""><?php echo $text_select; ?></option>';
							for (j = 0; j < option['product_option_value'].length; j++) {
								option_value = option['product_option_value'][j];
								html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
								if (option_value['price']) {
									html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
								}
								html += '</option>';
							}
							html += '    </select>';
							html += '  </div>';
							html += '</div>';
						}
						if (option['type'] == 'radio') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10">';
							html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
							html += '      <option value=""><?php echo $text_select; ?></option>';
							for (j = 0; j < option['product_option_value'].length; j++) {
								option_value = option['product_option_value'][j];
								html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
								if (option_value['price']) {
									html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
								}
								html += '</option>';
							}
							html += '    </select>';
							html += '  </div>';
							html += '</div>';
						}
						if (option['type'] == 'checkbox') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10">';
							html += '    <div id="input-option' + option['product_option_id'] + '">';
							for (j = 0; j < option['product_option_value'].length; j++) {
								option_value = option['product_option_value'][j];
								html += '<div class="checkbox">';
								html += '  <label><input type="checkbox" name="option[' + option['product_option_id'] + '][]" value="' + option_value['product_option_value_id'] + '" /> ' + option_value['name'];
								if (option_value['price']) {
									html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
								}
								html += '  </label>';
								html += '</div>';
							}
							html += '    </div>';
							html += '  </div>';
							html += '</div>';
						}
						if (option['type'] == 'image') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10">';
							html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
							html += '      <option value=""><?php echo $text_select; ?></option>';
							for (j = 0; j < option['product_option_value'].length; j++) {
								option_value = option['product_option_value'][j];
								html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];
								if (option_value['price']) {
									html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
								}
								html += '</option>';
							}
							html += '    </select>';
							html += '  </div>';
							html += '</div>';
						}
						if (option['type'] == 'text') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" class="form-control" /></div>';
							html += '</div>';
						}
						if (option['type'] == 'textarea') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10"><textarea name="option[' + option['product_option_id'] + ']" rows="5" id="input-option' + option['product_option_id'] + '" class="form-control">' + option['value'] + '</textarea></div>';
							html += '</div>';
						}
						if (option['type'] == 'file') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label">' + option['name'] + '</label>';
							html += '  <div class="col-sm-10">';
							html += '    <button type="button" id="button-upload' + option['product_option_id'] + '" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>';
							html += '    <input type="hidden" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" />';
							html += '  </div>';
							html += '</div>';
						}
						if (option['type'] == 'date') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-3"><div class="input-group date"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
							html += '</div>';
						}
						if (option['type'] == 'datetime') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-3"><div class="input-group datetime"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
							html += '</div>';
						}
						if (option['type'] == 'time') {
							html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
							html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
							html += '  <div class="col-sm-3"><div class="input-group time"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
							html += '</div>';
						}
					}
					html += '</fieldset>';
					$('#add-product').hide();
					$('#option-box').show();
					$('#option').html(html);
					$('.date').datetimepicker({
						pickTime: false
					});
					$('.datetime').datetimepicker({
						pickDate: true,
						pickTime: true
					});
					$('.time').datetimepicker({
						pickDate: false
					});
				} else {
					$('#option-box').hide();
					$('#option').html('');
				}
			}
		});
		$('#button-save-option').on('click', function() {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');
			$('#option-box').hide();
			$('#add-product').show();
		});
		$('#button-close-option').on('click', function() {
			$('.alert, .text-danger').remove();
			$('.form-gorup').removeClass('has-error');
			$('#option-box').hide();
			$('#add-product').show();
		});
		// Add a product to order
		$('#button-product-add').on('click', function() {
			if ($('#tab-product input[name=\'product_id\']').val() > 0) {
				$.ajax({
					url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/cart/add&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
					type: 'post',
					data: $('#tab-product input[name=\'product_id\'], #tab-product input[name=\'quantity\'], #tab-product input[name=\'price\'], #tab-product input[name=\'notax\'][type=\'checkbox\']:checked, #tab-product input[name=\'custom_price\'][type=\'checkbox\']:checked, #option input[name^=\'option\'][type=\'text\'], #option input[name^=\'option\'][type=\'hidden\'], #option input[name^=\'option\'][type=\'radio\']:checked, #option input[name^=\'option\'][type=\'checkbox\']:checked, #option select[name^=\'option\'], #option textarea[name^=\'option\']'),
					dataType: 'json',
					crossDomain: true,
					beforeSend: function() {
						$('#button-product-add').button('loading');
					},
					complete: function() {
						$('#button-product-add').button('reset');
						$('#please_wait').show();
						$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
						$('#grey_screen').show();
						$('body').css({'overflow':'hidden'});
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
						if (json['error']) {
							if (json['error']['warning']) {
								$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							}
							if (json['error']['option']) {
								for (i in json['error']['option']) {
									var element = $('#input-option' + i.replace('_', '-'));
									if (element.parent().hasClass('input-group')) {
										$(element).parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
									} else {
										$(element).after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
									}
									$('#tab-product').prepend('<div class="text-danger">' + json['error']['option'][i] + '</div>');
								}
								$('#add-product').hide();
								$('#option-box').show();
							}
							if (json['error']['store']) {
								$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['store'] + '</div>');
							}
						} else {
							$('#option-box').hide();
							$('#close-add-product').trigger('click');
							$('input[name=\'product_id\']').val('');
							$('input[name=\'product\']').val('');
							$('input[name=\'quantity\']').val('1');
							$('input[name=\'price\']').val('');
							$('input[name=\'notax\']').attr('checked', false);
							$('input[name=\'custom_price\']').attr('checked', false);
							$('input[name=\'price\']').attr('disabled', 'disabled');
							$('#option').html('');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				}).done(function() {
					if ($('input[name=\'order_id\']').val() > 0) {
						setPaymentAddress();
					} else {
						var shipping_same = $('input[name=\'shipping_same_payment\']').prop('checked');
						if (shipping_same) {
							setShippingAddress1();
						} else {
							setShippingAddress2();
						}
					}
				});
			} else {
				alert('<?php echo $text_product_error; ?>');
				return false;
			}
		});
		// Add a voucher to order
		$('#button-voucher-add').on('click', function() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/voucher/add&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#tab-voucher input[type=\'text\'], #tab-voucher input[type=\'hidden\'], #tab-voucher input[type=\'radio\']:checked, #tab-voucher input[type=\'checkbox\']:checked, #tab-voucher select, #tab-voucher textarea'),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('#button-voucher-add').button('loading');
				},
				complete: function() {
					$('#button-voucher-add').button('reset');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						if (json['error']['warning']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						for (i in json['error']) {
							var element = $('#input-' + i.replace('_', '-'));
							if (element.parent().hasClass('input-group')) {
								$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
							} else {
								$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
							}
						}
						$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
					} else {
						$('#button-refresh').trigger('click');
						$('input[name=\'from_name\']').attr('value', '');
						$('input[name=\'from_email\']').attr('value', '');
						$('input[name=\'to_name\']').attr('value', '');
						$('input[name=\'to_email\']').attr('value', '');
						$('textarea[name=\'message\']').attr('value', '');
						$('input[name=\'amount\']').attr('value', '<?php echo addslashes($voucher_min); ?>');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		// Remove product from order
		$('#cart').delegate('.btn-danger', 'click', function() {
			var node = this;
			var key = $('#quantity-' + $(this).val()).attr('rel');
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/cart/remove&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: 'key=' + encodeURIComponent(key),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					} else {
						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		});

		// Refresh products, vouchers, and totals
		$('#cart').delegate('.btn-primary', 'click', function() {
			var node = this;
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/cart/add&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: $('#cart input[name^=\'product\'][type=\'text\'], #cart input[name^=\'product\'][type=\'hidden\'], #cart input[name^=\'product\'][type=\'radio\']:checked, #cart input[name^=\'product\'][type=\'checkbox\']:checked, #cart select[name^=\'product\'], #cart textarea[name^=\'product\']'),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error'] && json['error']['warning']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
					if (json['success']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				$('#button-refresh').trigger('click');
			});
		});
		$('#button-cart').on('click', function() {
			$('a[href=\'#tab-payment\']').tab('show');
		});

		// Set shipping method
		$('#input-shipping-method').on('change', function() {
			if ($('select[name=\'shipping_method\']').val() != '') {
				$('#please_wait').show();
				$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
				$('#grey_screen').show();
				$('body').css({'overflow':'hidden'});
				if ($('select[name=\'shipping_method\']').val() == 'oe_custom.oe_custom') {
					$.ajax({
						url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order_entry/getCustomShipping&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
						type: 'get',
						dataType: 'json',
						crossDomain: true,
						success: function(json) {
							$('#input-custom-shipping-title').val(json['title']);
							$('#input-custom-shipping-cost').val(json['cost']);
							$('#custom-shipping').show();
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				} else {
					$('#custom-shipping').hide();
					$('#input-custom-shipping-title').val('');
					$('#input-custom-shipping-cost').val('');
					$.ajax({
						url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order_entry/removeCustomShipping&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
						dataType: 'json',
						crossDomain: true,
						success: function(json) {
							html = '<option value=""><?php echo $text_select; ?></option>';
							if (json['shipping_methods']) {
								for (i in json['shipping_methods']) {
									html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';
									if (!json['shipping_methods'][i]['error']) {
										for (j in json['shipping_methods'][i]['quote']) {
											if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name=\'shipping_method\'] option:selected').val()) {
												html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
											} else {
												html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
											}
										}
									} else {
										html += '<option value="" style="color: #F00;" disabled="disabled">' + json['shipping_methods'][i]['error'] + '</option>';
									}
									html += '</optgroup>';
								}
							}
							$('select[name=\'shipping_method\']').html(html);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
				$.ajax({
					url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/shipping/method&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
					type: 'post',
					data: 'shipping_method=' + $('select[name=\'shipping_method\'] option:selected').val(),
					dataType: 'json',
					crossDomain: true,
					beforeSend: function() {
						$('#input-shipping-method').attr('disabled', 'disabled');
					},
					complete: function() {
						$('#input-shipping-method').removeAttr('disabled');
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						$('.form-group').removeClass('has-error');
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('select[name=\'shipping_method\']').parent().parent().addClass('has-error');
						}
						if (json['success']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('#button-refresh').trigger('click');
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			} else {
				$('#button-refresh').trigger('click');
			}
		});

		// Set payment method
		$('#input-payment-method').on('change', function() {
			$('#please_wait').show();
			$('#grey_screen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
			$('#grey_screen').show();
			$('body').css({'overflow':'hidden'});
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/payment/method&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: 'payment_method=' + $('select[name=\'payment_method\'] option:selected').val(),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('#input-payment-method').attr('disabled', 'disabled');
				},
				complete: function() {
					$('#input-payment-method').removeAttr('disabled');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('select[name=\'payment_method\']').parent().parent().addClass('has-error');
					}
					if (json['success']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			}).done(function() {
				if ($('input[name=\'order_id\']').val() > 0) {
					getShippingMethods();
				} else {
					$('#button-refresh').trigger('click');
				}
			});
		});

		// Coupon
		$('#input-coupon').on('keydown', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode != 9) {
				clearTimeout(typingTimer);
				if ($('#input-coupon').val) {
					typingTimer = setTimeout(processCoupon, doneTypingInterval);
				}
			}
		});
		function processCoupon() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/coupon&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: 'coupon=' + $('input[name=\'coupon\']').val(),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('#input-coupon').attr('disabled', 'disabled');
				},
				complete: function() {
					$('#input-coupon').removeAttr('disabled');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('input[name=\'coupon\']').parent().parent().addClass('has-error');
					}
					if (json['success']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Use voucher on order
		$('#input-voucher').on('keydown', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode != 9) {
				clearTimeout(typingTimer);
				if ($('#input-voucher').val) {
					typingTimer = setTimeout(processVoucher, doneTypingInterval);
				}
			}
		});
		function processVoucher() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/voucher&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: 'voucher=' + $('input[name=\'voucher\']').val(),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('#input-voucher').attr('disabled', 'disabled');
				},
				complete: function() {
					$('#input-voucher').removeAttr('disabled');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('input[name=\'voucher\']').parent().parent().addClass('has-error');
					}
					if (json['success']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Use reward points on order
		$('#input-reward').on('keydown', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode != 9) {
				clearTimeout(typingTimer);
				if ($('#input-reward').val) {
					typingTimer = setTimeout(processReward, doneTypingInterval);
				}
			}
		});
		function processReward() {
			$.ajax({
				url: 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/reward&store_id=' + $('select[name=\'store_id\'] option:selected').val(),
				type: 'post',
				data: 'reward=' + $('input[name=\'reward\']').val(),
				dataType: 'json',
				crossDomain: true,
				beforeSend: function() {
					$('#input-reward').attr('disabled', 'disabled');
				},
				complete: function() {
					$('#input-reward').removeAttr('disabled');
				},
				success: function(json) {
					$('.alert, .text-danger').remove();
					$('.form-group').removeClass('has-error');
					if (json['error']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('input[name=\'reward\']').parent().parent().addClass('has-error');
					}
					if (json['success']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('#button-refresh').trigger('click');
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}

		// Affiliate
		$('input[name=\'affiliate\']').autocomplete({
			'source': function(request, response) {
				$.ajax({
					url: 'index.php?route=marketing/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
					dataType: 'json',
					success: function(json) {
						json.unshift({
							affiliate_id: 0,
							name: '<?php echo $text_none; ?>'
						});
						response($.map(json, function(item) {
							return {
								label: item['name'],
								value: item['affiliate_id']
							}
						}));
					}
				});
			},
			'select': function(item) {
				$('input[name=\'affiliate\']').val(item['label']);
				$('input[name=\'affiliate_id\']').val(item['value']);
			}
		});

		// Save order
		$('#button-save1').on('click', function() {
			$('#button-save').trigger('click');
		});
		$('#button-save').on('click', function() {
			if (customerValidate()) {
				var order_id = $('input[name=\'order_id\']').val();
				if (order_id == 0) {
					var url = 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order/add&store_id=' + $('select[name=\'store_id\'] option:selected').val();
				} else {
					var url = 'index.php?route=sale/order/api&token=<?php echo $token; ?>&api=api/order/edit&store_id=' + $('select[name=\'store_id\'] option:selected').val() + '&order_id=' + order_id;
				}
				$.ajax({
					url: url,
					type: 'post',
					data: $('#tab-total select[name=\'payment_method\'] option:selected,  #tab-total select[name=\'shipping_method\'] option:selected,  #tab-total input[type=\'checkbox\']:checked, #tab-total select[name=\'order_status_id\'], #tab-total select, #tab-total textarea[name=\'comment\'], #tab-total input[name=\'affiliate_id\'], #new-customer input[type=\'checkbox\']:checked, #new-address input[type=\'checkbox\']:checked'),
					dataType: 'json',
					crossDomain: true,
					beforeSend: function() {
						$('#button-save').button('loading');
					},
					complete: function() {
						$('#button-save').button('reset');
					},
					success: function(json) {
						$('.alert, .text-danger').remove();
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						}
						if (json['success']) {
							location.href = 'index.php?route=sale/order&token=<?php echo $token; ?>';
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				});
			} else {
				alert('<?php echo $text_order_error; ?>');
				return false;
			}
		});
		$('#content').delegate('button[id^=\'button-upload\'], button[id^=\'button-custom-field\'], button[id^=\'button-payment-custom-field\'], button[id^=\'button-shipping-custom-field\']', 'click', function() {
			var node = this;
			$('#form-upload').remove();
			$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
			$('#form-upload input[name=\'file\']').trigger('click');
			if (typeof timer != 'undefined') {
				clearInterval(timer);
			}
			timer = setInterval(function() {
				if ($('#form-upload input[name=\'file\']').val() != '') {
					clearInterval(timer);
					$.ajax({
						url: 'index.php?route=tool/upload/upload&token=<?php echo $token; ?>',
						type: 'post',
						dataType: 'json',
						data: new FormData($('#form-upload')[0]),
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function() {
							$(node).button('loading');
						},
						complete: function() {
							$(node).button('reset');
						},
						success: function(json) {
							$(node).parent().find('.text-danger').remove();
							if (json['error']) {
								$(node).parent().find('input[type=\'hidden\']').after('<div class="text-danger">' + json['error'] + '</div>');
							}
							if (json['success']) {
								alert(json['success']);
							}
							if (json['code']) {
								$(node).parent().find('input[type=\'hidden\']').attr('value', json['code']);
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
			}, 500);
		});
		$('.date').datetimepicker({
			pickTime: false
		});
		$('.datetime').datetimepicker({
			pickDate: true,
			pickTime: true
		});
		$('.time').datetimepicker({
			pickDate: false
		});
		$(document).ready(function() {
			if ($('input[name=\'customer_id\']').val() > 0) {
				$('#add-customer').hide();
			}
		});
	//--></script>
	<script type="text/javascript">
		// Sort the custom fields
		$('#tab-customer .form-group[data-sort]').detach().each(function() {
			if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-customer .form-group').length) {
				$('#tab-customer .form-group').eq($(this).attr('data-sort')).before(this);
			}
			if ($(this).attr('data-sort') > $('#tab-customer .form-group').length) {
				$('#tab-customer .form-group:last').after(this);
			}
			if ($(this).attr('data-sort') < -$('#tab-customer .form-group').length) {
				$('#tab-customer .form-group:first').before(this);
			}
		});
		// Sort the custom fields
		$('#tab-payment .form-group[data-sort]').detach().each(function() {
			if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-payment .form-group').length) {
				$('#tab-payment .form-group').eq($(this).attr('data-sort')).before(this);
			}
			if ($(this).attr('data-sort') > $('#tab-payment .form-group').length) {
				$('#tab-payment .form-group:last').after(this);
			}
			if ($(this).attr('data-sort') < -$('#tab-payment .form-group').length) {
				$('#tab-payment .form-group:first').before(this);
			}
		});
		$('#tab-shipping .form-group[data-sort]').detach().each(function() {
			if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-shipping .form-group').length) {
				$('#tab-shipping .form-group').eq($(this).attr('data-sort')).before(this);
			}
			if ($(this).attr('data-sort') > $('#tab-shipping .form-group').length) {
				$('#tab-shipping .form-group:last').after(this);
			}
			if ($(this).attr('data-sort') < -$('#tab-shipping .form-group').length) {
				$('#tab-shipping .form-group:first').before(this);
			}
		});
	</script>
</div>
<?php echo $footer; ?>