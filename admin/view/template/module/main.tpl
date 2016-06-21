<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
		  <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-about" data-toggle="tab"><?php echo $tab_about; ?></a></li>
          </ul>
		  <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
				<div class="col-sm-10">
				  <select name="main_image_status" id="input-status" class="form-control">
					<option value="1"<?php echo $main_image_status ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
					<option value="0"<?php echo $main_image_status ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
				  </select>
				</div>
			  </div>
			</div>
			<div class="tab-pane" id="tab-about">
			  <div class="col-sm-9">
				<h2><?php echo $text_support; ?></h2>
				<?php echo $text_need_support; ?><br /><br />
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-mail-name"><?php echo $entry_mail_name; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="mail_name" value="" placeholder="<?php echo $entry_mail_name ;?>" id="input-mail-name" class="form-control" />
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-mail-email"><?php echo $entry_mail_email; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="mail_email" value="" placeholder="<?php echo $entry_mail_email; ?>" id="input-mail-email" class="form-control" />
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-mail-order-id"><?php echo $entry_mail_order_id; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="mail_order_id" value="" placeholder="<?php echo $entry_mail_order_id; ?>" id="input-mail-order-id" class="form-control" />
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-mail-message"><?php echo $entry_mail_message; ?></label>
				  <div class="col-sm-10">
					<textarea name="mail_message" rows="5" placeholder="Describe your issues. Provide your store admin and FTP login credentials if you require technical support." id="input-mail-message" class="form-control"></textarea>
				  </div>
				</div>
				<a class="btn btn-primary" id="button-mail"><?php echo $button_mail; ?></a>
				<a class="btn btn-success" href="http://www.opencart.com/index.php?route=extension/extension/info&amp;extension_id=8871" target="_blank" rel="nofollow"><?php echo $button_review; ?></a>
				<a class="btn btn-success" href="http://www.marketinsg.com/main-image" target="_blank"><?php echo $button_purchase; ?></a>
			  </div>
			  <div class="col-sm-3">
				<h2><?php echo $text_follow; ?></h2>
			    <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FEquotix&amp;width=292&amp;height=558&amp;show_faces=true&amp;colorscheme=light&amp;stream=true&amp;show_border=false&amp;header=false&amp;appId=391573267589280" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:558px;" allowTransparency="true"></iframe>
			  </div>
			</div>
		  </div>
		</form>
      </div>
    </div>
	<div style="color:#222222;text-align:center;"><?php echo $heading_title; ?> v1.2.2 by <a href="http://www.marketinsg.com" target="_blank">MarketInSG</a></div>
  </div>
</div>
<script type="text/javascript"><!--//
$('#button-mail').on('click', function() {
	$.ajax({
		url: 'index.php?route=module/main/mail&token=<?php echo $token; ?>',
		type: 'post',
		data: $('input[name=\'mail_name\'], input[name=\'mail_email\'], input[name=\'mail_order_id\'], textarea[name=\'mail_message\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-mail').after('<i class="fa fa-spinner"></i>');
		},
		success: function(json) {
			$('.fa-spinner, .text-danger').remove();
			
			if (json['error']) {
				if (json['error']['warning']) {
					alert(json['error']['warning']);
				}
				
				if (json['error']['name']) {
					$('input[name=\'mail_name\']').after('<div class="text-danger">' + json['error']['name'] + '</span>');
				}
				
				if (json['error']['email']) {
					$('input[name=\'mail_email\']').after('<div class="text-danger">' + json['error']['email'] + '</span>');
				}
				
				if (json['error']['order_id']) {
					$('input[name=\'mail_order_id\']').after('<div class="text-danger">' + json['error']['order_id'] + '</span>');
				}
				
				if (json['error']['message']) {
					$('textarea[name=\'mail_message\']').after('<div class="text-danger">' + json['error']['message'] + '</span>');
				}
			} else {
				alert(json['success']);
				
				$('input[name=\'mail_name\']').val('');
				$('input[name=\'mail_email\']').val('');
				$('input[name=\'mail_order_id\']').val('');
				$('textarea[name=\'mail_message\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});
//--></script>
<?php echo $footer; ?>