<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="AbandonedCarts">
 <script type="text/javascript">
	NProgress.configure({
		showSpinner: false,
		ease: 'ease',
		speed: 500,
		trickleRate: 0.2,
		trickleSpeed: 200 
	});
 </script>
 <div class="page-header">
    <div class="container-fluid">
      <h1><i class="fa fa-shopping-cart"></i>&nbsp;<?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
	<?php echo (empty($moduleData['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNpc2Vuc2Vfc3VwcG9ydF0nKS50cmlnZ2VyKCdjbGljaycpIj5FbnRlciB5b3VyIGxpY2Vuc2UgY29kZTwvYT4NCiAgICA8L2Rpdj4=') : '' ?>
    <?php if ($error_warning) { ?>
    	<div class="alert alert-danger autoSlideUp"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
     	 <button type="button" class="close" data-dismiss="alert">&times;</button>
    	</div>
    <?php } ?>
    <?php if ($success) { ?>
        <div class="alert alert-success autoSlideUp"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        	<button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <script>$('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600);</script>
    <?php } ?>
    <div id="messageResult" style="display:none;"><div class="alert alert-success"><i class="fa fa-info"></i> The message was sent successfully!</div></div>
      <div class="panel panel-default">
            <div class="panel-heading">
                <div class="storeSwitcherWidget">
                    <div class="form-group" style="padding-top:0px;padding-bottom:0px;">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;&nbsp;<?php echo $store['name']; if($store['store_id'] == 0) echo " <strong>(".$text_default.")</strong>"; ?>&nbsp;<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach ($stores  as $st) { ?>
                                <li><a href="index.php?route=module/<?php echo $moduleName; ?>&store_id=<?php echo $st['store_id'];?>&token=<?php echo $token; ?>"><?php echo $st['name']; ?></a></li>
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
                <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;">Module settings</span></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                    <input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>">
                    <div class="tabbable">
                        <div class="tab-navigation form-inline">
                              <ul class="nav nav-tabs mainMenuTabs">
                                <li><a href="#controlpanel" data-toggle="tab"><i class="fa fa-power-off"></i>&nbsp;Control Panel</a></li>
                                <li><a href="#abandonedCarts" data-toggle="tab" class="active"><i class="fa fa-list-alt"></i>&nbsp;Abandoned Carts</a></li>
                                <li><a href="#mail" data-toggle="tab"><i class="fa fa-envelope-o"></i>&nbsp;Mail Template</a></li>
                                <li><a href="#analytics" data-toggle="tab"><i class="fa fa-bar-chart-o"></i>&nbsp;Statistics</a></li>
                                <li class="dropdown">
                                  <a href="#"  data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-gift"></i>&nbsp;Coupons<b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="#givenCoupons" data-toggle="tab"/><i class="fa fa-tags"></i>&nbsp;Given Coupons</a></li>
                                    <li><a href="#usedCoupons" data-toggle="tab"/><i class="fa fa-check-square-o"></i>&nbsp;Used Coupons</a></li>
                                  </ul>
                                </li>
                                <li><a href="#isense_support" data-toggle="tab"><i class="fa fa-external-link"></i>&nbsp;Support</a></li>        
                              </ul>
                            <div class="tab-buttons">
                                <button type="submit" class="btn btn-success save-changes"><i class="fa fa-check"></i>&nbsp;Save Changes</button>
                                <a onclick="location = '<?php echo $cancel; ?>'" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;<?php echo $button_cancel?></a>
                            </div> 
                      </div><!-- /.tab-navigation --> 
                      <div class="tab-content">
                      	<?php
                        if (!function_exists('modification_vqmod')) {
                        	function modification_vqmod($file) {
                        		if (class_exists('VQMod')) {
                       				return VQMod::modCheck(modification($file), $file);
                        		} else {
                        			return modification($file);
                       			}
                        	}
                        }
						?>
                        <div id="controlpanel" class="tab-pane active">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleName.'/tab_panel.php'); ?>                        
                        </div> 
                        <div id="abandonedCarts" class="tab-pane">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleName.'/tab_abandonedcarts.php'); ?>                        
                        </div>
                        <div id="mail" class="tab-pane">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleName.'/tab_mail.php'); ?>                        
                        </div>  
                        <div id="analytics" class="tab-pane">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleName.'/tab_analytics.php'); ?>                        
                        </div> 
                        <div id="givenCoupons" class="tab-pane"></div>
                        <div id="usedCoupons" class="tab-pane"></div>           
                        <div id="isense_support" class="tab-pane">
                          <?php require_once modification_vqmod(DIR_APPLICATION.'view/template/module/'.$moduleName.'/tab_support.php'); ?>                        
                        </div>
                      </div><!-- /.tab-content -->
                    </div><!-- /.tabbable -->
                </form>
            </div> 
        </div>
    </div>
 </div>
<script>
$('#mainTabs a:first').tab('show'); // Select first tab
$('.mail-list').children().last().children('a').click();
if (window.localStorage && window.localStorage['currentTab']) {
	$('.mainMenuTabs a[href="'+window.localStorage['currentTab']+'"]').tab('show');
}
if (window.localStorage && window.localStorage['currentSubTab']) {
	$('a[href="'+window.localStorage['currentSubTab']+'"]').tab('show');
}
$('.fadeInOnLoad').css('visibility','visible');
$('.mainMenuTabs a[data-toggle="tab"]').click(function() {
	if (window.localStorage) {
		window.localStorage['currentTab'] = $(this).attr('href');
	}
});
$('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"], .mailtemplate_tabs a[data-toggle="tab"])').click(function() {
	if (window.localStorage) {
		window.localStorage['currentSubTab'] = $(this).attr('href');
	}
});

$(document).ready(refreshData());
  function refreshData(){
      $.ajax({
         url: "index.php?route=module/<?php echo $moduleName; ?>/givenCoupons&token=<?php echo $token; ?>",
         type: 'get',
         dataType: 'html',
         success: function(data) { 
          $('#givenCoupons').html(data);
         }
      });
      $.ajax({
         url: "index.php?route=module/<?php echo $moduleName; ?>/usedCoupons&token=<?php echo $token; ?>",
         type: 'get',
         dataType: 'html',
         success: function(data) { 
          $('#usedCoupons').html(data);
         }
      });
    }
</script> 
<?php echo $footer; ?>