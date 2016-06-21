<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-account" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
		<?php } ?>
		<?php if ($success) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $text_maintenance; ?></h3>
					</div>
					<div class="panel-body">
						<div class="col-sm-12 form-group">
							<div class="col-sm-2">
								<a href="<?php echo $update_orders; ?>" type="button" id="button-update-orders" class="btn btn-primary"><i class="fa fa-pencil"></i> <?php echo $button_update_orders; ?></a>
							</div>
							<label class="col-sm-10" style="padding-top:3px;"><?php echo $text_update_orders; ?></label>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $text_installed_modules; ?></h3>
					</div>
					<div class="panel-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left"><?php echo $column_module_name; ?></td>
									<td class="text-left"><?php echo $column_module_status; ?></td>
									<td class="text-left"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($oe_modules) { ?>
									<?php foreach ($oe_modules as $module) { ?>
										<tr>
											<td class="text-left"><?php echo $module['name']; ?></td>
											<td class="text-left"><?php echo $module['status']; ?></td>
											<td class="text-left">
												<?php foreach ($module['action'] as $module_action) { ?>
													[ <a href="<?php echo $module_action['href']; ?>"><?php echo $module_action['text']; ?></a> ]
												<?php } ?>
											</td>
										</tr>
									<?php } ?>
								<?php } else { ?>
									<tr>
										<td class="text-center" colspan="3"><?php echo $text_no_modules; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $text_oe_settings; ?></h3>
					</div>
					<div class="panel-body">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-order-entry" class="form-horizontal">
							<ul class="nav nav-tabs nav-justified">
								<li class="active"><a href="#tab-general-settings" data-toggle="tab"><?php echo $tab_general_settings; ?></a></li>
								<li><a href="#tab-customer-settings" data-toggle="tab"><?php echo $tab_customer_settings; ?></a></li>
								<li><a href="#tab-product-settings" data-toggle="tab"><?php echo $tab_product_settings; ?></a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab-general-settings">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-form-type"><span data-toggle="tooltip" title="<?php echo $help_form_type; ?>"><?php echo $entry_form_type; ?></span></label>
										<div class="col-sm-10">
											<select name="oe_form_type" id="input-form-type" class="form-control">
												<?php if ($oe_form_type == "tab") { ?>
													<option value="tab" selected="selected"><?php echo $text_tab_form; ?></option>
													<option value="one"><?php echo $text_one_form; ?></option>
												<?php } else { ?>
													<option value="tab"><?php echo $text_tab_form; ?></option>
													<option value="one" selected="selected"><?php echo $text_one_form; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab-customer-settings">
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-require-telephone"><?php echo $entry_require_telephone; ?></label>
										<div class="col-sm-10">
											<select name="oe_require_telephone" id="input-require-telephone" class="form-control">
												<?php if ($oe_require_telephone) { ?>
													<option value="0"><?php echo $text_not_required; ?></option>
													<option value="1" selected="selected"><?php echo $text_required; ?></option>
												<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_not_required; ?></option>
													<option value="1"><?php echo $text_required; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-require-email"><?php echo $entry_require_email; ?></label>
										<div class="col-sm-10">
											<select name="oe_require_email" id="input-require-email" class="form-control">
												<?php if ($oe_require_email) { ?>
													<option value="0"><?php echo $text_not_required; ?></option>
													<option value="1" selected="selected"><?php echo $text_required; ?></option>
												<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_not_required; ?></option>
													<option value="1"><?php echo $text_required; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-require-city"><?php echo $entry_require_city; ?></label>
										<div class="col-sm-10">
											<select name="oe_require_city" id="input-require-city" class="form-control">
												<?php if ($oe_require_city) { ?>
													<option value="0"><?php echo $text_not_required; ?></option>
													<option value="1" selected="selected"><?php echo $text_required; ?></option>
												<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_not_required; ?></option>
													<option value="1"><?php echo $text_required; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-require-zone"><?php echo $entry_require_zone; ?></label>
										<div class="col-sm-10">
											<select name="oe_require_zone" id="input-require-zone" class="form-control">
												<?php if ($oe_require_zone) { ?>
													<option value="0"><?php echo $text_not_required; ?></option>
													<option value="1" selected="selected"><?php echo $text_required; ?></option>
												<?php } else { ?>
													<option value="0" selected="selected"><?php echo $text_not_required; ?></option>
													<option value="1"><?php echo $text_required; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab-product-settings">
									<div class="form-group">
										<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_product_columns; ?>"><?php echo $entry_product_columns; ?></span></label>
										<div class="col-sm-10">
											<div class="checkbox">
												<label>
													<?php if (in_array('option', $oe_product_columns)) { ?>
														<input type="checkbox" name="oe_product_columns[]" value="option" checked="checked" />
													<?php } else { ?>
														<input type="checkbox" name="oe_product_columns[]" value="option" />
													<?php } ?>
													<?php echo $text_option; ?>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<?php if (in_array('price', $oe_product_columns)) { ?>
														<input type="checkbox" name="oe_product_columns[]" value="price" checked="checked" />
													<?php } else { ?>
														<input type="checkbox" name="oe_product_columns[]" value="price" />
													<?php } ?>
													<?php echo $text_price; ?>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<?php if (in_array('pricet', $oe_product_columns)) { ?>
														<input type="checkbox" name="oe_product_columns[]" value="pricet" checked="checked" />
													<?php } else { ?>
														<input type="checkbox" name="oe_product_columns[]" value="pricet" />
													<?php } ?>
													<?php echo $text_pricet; ?>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<?php if (in_array('total', $oe_product_columns)) { ?>
														<input type="checkbox" name="oe_product_columns[]" value="total" checked="checked" />
													<?php } else { ?>
														<input type="checkbox" name="oe_product_columns[]" value="total" />
													<?php } ?>
													<?php echo $text_total; ?>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<?php if (in_array('totalt', $oe_product_columns)) { ?>
														<input type="checkbox" name="oe_product_columns[]" value="totalt" checked="checked" />
													<?php } else { ?>
														<input type="checkbox" name="oe_product_columns[]" value="totalt" />
													<?php } ?>
													<?php echo $text_totalt; ?>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<?php if (in_array('notax', $oe_product_columns)) { ?>
														<input type="checkbox" name="oe_product_columns[]" value="notax" checked="checked" />
													<?php } else { ?>
														<input type="checkbox" name="oe_product_columns[]" value="notax" />
													<?php } ?>
													<?php echo $text_notax; ?>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>