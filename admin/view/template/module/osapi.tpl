<?php
/*
  osapi.tpl

  OneSaas Connect API 2.0.0.11 for OpenCart v2.0
  http://www.onesaas.com

  Copyright (c) 2012 OneSaas
  		  
*/
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title.' (v.'.$os_version.')'; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-osapi" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-info"><?php echo $entry_info; ?></label>
			<div class="col-sm-10">		
			<p>Please copy the following Configuration Key into <a href="http://www.onesaas.com" title="OneSaas">OneSaas</a> configuration to get connected</p>
			</div>
		</div>
		<div class="form-group">	
		<label class="col-sm-2 control-label" for="input-key"><?php echo $entry_key; ?></label>		
			<div class="col-sm-10">	
			<textarea cols="183" rows="4" onclick="this.focus();this.select()" readonly><?php echo $configkey ?></textarea>
			</div>
		</div>	
		</div>
	    </form>	
	  </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
