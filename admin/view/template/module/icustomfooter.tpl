<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

    <div class="page-header">
    	<div class="container-fluid">
    		<div class="pull-right">
                <a onclick="$('#form').submit();" class="btn btn-primary save-changes"><i class="fa fa-save"></i></a>
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
        <?php echo (empty($module_data['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNpc2Vuc2Vfc3VwcG9ydF0nKS50cmlnZ2VyKCdjbGljaycpIj5FbnRlciB5b3VyIGxpY2Vuc2UgY29kZTwvYT4NCiAgICA8L2Rpdj4=') : '' ?>
        
        <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        
        <?php if (!empty($this->session->data['success'])) { ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $this->session->data['success']; unset($this->session->data['success']); ?>
            </div>
        <?php } ?>
        
        <?php if (!empty($this->session->data['error'])) { ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $this->session->data['error']; unset($this->session->data['error']); ?>
            </div>
        <?php } ?>
        
        <div class="panel panel-default">
        	<div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;">Module settings</span></h3>
                <div class="storeSwitcherWidget">
                    <div class="form-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-pushpin"></span>&nbsp;<?php echo $store['name']; if($store['store_id'] == 0) echo " <strong>(".$text_default.")</strong>"; ?>&nbsp;<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach ($stores  as $st) { ?>
                                <li><a href="index.php?route=module/icustomfooter&store_id=<?php echo $st['store_id'];?>&token=<?php echo $token; ?>"><?php echo $st['name']; ?></a></li>
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
            </div>
        
            <div class="panel-body">
            	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                    <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
                    <input type="hidden" name="tab" value="<?php echo !empty($this->request->get['tab']) ? $this->request->get['tab'] : '0'; ?>" />
                    <input type="hidden" name="subtab" value="<?php echo !empty($this->request->get['subtab']) ? $this->request->get['subtab'] : '0'; ?>" />
            
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a href="#settings" role="tab" data-toggle="tab"><i class="fa fa-cog"></i>&nbsp;Settings</a></li>
                        <li><a href="#tab_columns" role="tab" data-toggle="tab"><i class="fa fa-columns"></i>&nbsp;Columns</a></li>
                        <li><a href="#social_buttons" role="tab" data-toggle="tab"><i class="fa fa-comment"></i>&nbsp;Social buttons</a></li>
                        <li><a href="#payment_icons" role="tab" data-toggle="tab"><i class="fa fa-usd"></i>&nbsp;Payment icons</a></li>
                        <li><a href="#isense_support" role="tab" data-toggle="tab"><i class="fa fa-ticket"></i>&nbsp;Support</a></li>
                    </ul>
            
                    <div class="tab-content">
                    
                            <div class="tab-pane active" id="settings">
                                <?php require_once(DIR_APPLICATION.'view/template/module/icustomfooter/settings_column_general.php'); ?>
                            </div>
                            
                            <div class="tab-pane" id="tab_columns">
                                <ul class="nav nav-tabs mainMenuTabs" role="tablist" id="mainTabs">
                                    <?php $index_1 = 0; foreach($languages as $lang) : ?>
                                        <li<?php echo $index_1 == 0 ? ' class="active"' : ''; ?>>
                                            <a href="#sub_tab_<?php echo $index_1; ?>" role="tab" data-toggle="tab"><img src="view/image/flags/<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" /></a>
                                        </li>
                                    <?php $index_1++; endforeach; ?>
                                </ul>
    
                                
                                <div class="tab-content">
                                	<?php $index_1 = 0; $index_3=0; foreach($languages as $lang) : ?>
                                    	<div class="tab-pane<?php echo $index_1 == 0 ? ' active' : ''; ?>" id="sub_tab_<?php echo $index_1; ?>">
                                        	<?php include(DIR_APPLICATION . 'view/template/module/icustomfooter/tablanguage_columns.php'); ?>
                                   		</div>
                                	<?php $index_1++; endforeach; ?>
                            	</div>	
                            </div>
                            
                            <div class="tab-pane" id="social_buttons">
                                <?php require_once(DIR_APPLICATION.'view/template/module/icustomfooter/settings_column_socialbuttons.php'); ?>
                            </div>
                            
                            <div class="tab-pane" id="payment_icons">
                                <?php require_once(DIR_APPLICATION.'view/template/module/icustomfooter/settings_column_paymenticons.php'); ?>
                            </div>
                        
                            <div class="tab-pane" id="isense_support">
                                <?php require_once(DIR_APPLICATION.'view/template/module/icustomfooter/tab_support.php'); ?>
                            </div>
                    </div>
            	</form>
                <form style="display: none;" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form_payment_icons">
                    <input type="file" id="PaymentIcons" class="PaymentIcons" data-browse-text-selector="" name="paymentIcon" style="display: none;" />
                    <input id="PaymentIconName" name="paymentIconName" type="hidden" value="" />
                    <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
                </form>
            </div>
		 </div>
    </div>
</div>
<script type="text/javascript">
	$('#mainTabs a:first').tab('show'); // Select first tab
	if (window.localStorage && window.localStorage['currentTab']) {
		$('.mainMenuTabs a[href="'+window.localStorage['currentTab']+'"]').tab('show');
	}
	if (window.localStorage && window.localStorage['currentSubTab']) {
		$('a[href="'+window.localStorage['currentSubTab']+'"]').tab('show');
	}
	$('.mainMenuTabs a[data-toggle="tab"]').click(function() {
		if (window.localStorage) {
			window.localStorage['currentTab'] = $(this).attr('href');
		}
	});
	$('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"], .review_tabs a[data-toggle="tab"])').click(function() {
		if (window.localStorage) {
			window.localStorage['currentSubTab'] = $(this).attr('href');
		}
	});
</script>
<?php echo $footer; ?>