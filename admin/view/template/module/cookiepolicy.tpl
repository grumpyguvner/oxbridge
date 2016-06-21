<?php
if(empty($cookiepolicy_text_colour)) $cookiepolicy_text_colour              	 ="FFFFFF";
if(empty($cookiepolicy_accept_text_colour)) $cookiepolicy_accept_text_colour     ="FFFFFF";
if(empty($cookiepolicy_accept_text_hover)) $cookiepolicy_accept_text_hover       ="FFFFFF";
if(empty($cookiepolicy_accept_button_colour)) $cookiepolicy_accept_button_colour ="2ABFF2";
if(empty($cookiepolicy_accept_button_hover)) $cookiepolicy_accept_button_hover   ="333333";
if(empty($cookiepolicy_background_colour)) $cookiepolicy_background_colour  	 ="333333";
if(empty($cookiepolicy_url)) $cookiepolicy_url ="/index.php?route=information/information&information_id=3";

echo $header; echo $column_left;
?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a onclick="$('#form-cookie').attr('action', '<?php echo $action; ?>&continue=1');$('#form-cookie').submit();" class="btn btn-default"><?php echo $button_apply; ?></a> 
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
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php }
        if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cookie" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="cookie-status"><?php echo $entry_status; ?></label>
                        <div class="col-sm-10">
                            <select name="cookiepolicy_status" id="cookie-status" class="form-control">
                                <?php if ($cookiepolicy_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                            <p class="help-block"><?php echo $theme_version; ?></p>
                        </div>
                    </div>
            		
                    <ul class="nav nav-tabs" role="tablist">
						<li class="active"><a href="#tab_settings" role="tab" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
                    	<li><a href="#tab_the1path" role="tab" data-toggle="tab"><?php echo $tab_the1path; ?></a></li>
                    </ul>
                    
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_settings">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="cookie-position"><?php echo $entry_position; ?></label>
                            <div class="col-sm-10">    
                                <select name="cookiepolicy_position" id="cookie-position" class="form-control">
                                    <?php switch ($cookiepolicy_position) { 
                                    case "1": ?>
                                        <option value="1" selected="selected"><?php echo $text_bottom; ?></option>
                                        <option value="2"><?php echo $text_top; ?></option>
                                        <option value="3"><?php echo $text_fullscreen; ?></option>
                                        <?php break;
                                    case "2": ?>
                                        <option value="1"><?php echo $text_bottom; ?></option>
                                        <option value="2" selected="selected"><?php echo $text_top; ?></option>
                                        <option value="3"><?php echo $text_fullscreen; ?></option>
                                        <?php break;
                                    case "3": ?>
                                        <option value="1"><?php echo $text_bottom; ?></option>
                                        <option value="2"><?php echo $text_top; ?></option>
                                        <option value="3" selected="selected"><?php echo $text_fullscreen; ?></option>
                                        <?php break;
                                    default: ?>
                                        <option value="1" selected="selected"><?php echo $text_bottom; ?></option>
                                        <option value="2"><?php echo $text_top; ?></option>
                                        <option value="3"><?php echo $text_fullscreen; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover">  
                            <tr>  
                                <td><label><?php echo $accept_button; ?></label></td>
                                <td><?php echo $colour_caption; ?>
                                    <input type="text" name="cookiepolicy_accept_text_colour" value="<?php echo $cookiepolicy_accept_text_colour; ?>" size="8" class="color {required:false,hash:true}"  /></td>
                                <td><?php echo $hover_colour_caption; ?>
                                    <input type="text" name="cookiepolicy_accept_text_hover" value="<?php echo $cookiepolicy_accept_text_hover; ?>" size="8" class="color {required:false,hash:true}" /></td>
                                <td><?php echo $background_caption; ?>
                                    <input type="text" name="cookiepolicy_accept_button_colour" value="<?php echo $cookiepolicy_accept_button_colour; ?>" size="8" class="color {required:false,hash:true}"  /></td>
                                <td><?php echo $background_hover_caption; ?> 
                                    <input type="text" name="cookiepolicy_accept_button_hover" value="<?php echo $cookiepolicy_accept_button_hover; ?>" size="8" class="color {required:false,hash:true}" /></td>
                                <td><?php echo $rounded_corners_caption; ?>
                                    <input type="checkbox" name="cookiepolicy_rounded_corners"<?php if ($cookiepolicy_rounded_corners) echo 'checked="checked"';?>> </td>
                            </tr>
                            <tr>
                                <td><label><?php echo $cookie_text; ?></label></td>
                                <td colspan="5">
                                    <?php echo $colour_caption; ?>
                                    <input type="text" name="cookiepolicy_text_colour" value="<?php echo $cookiepolicy_text_colour; ?>" size="8" class="color {required:false,hash:true}"  />
                                </td>
                            </tr>
                            <tr>
                                <td><label><?php echo $cookie_background; ?></label></td>
                                <td>
                                    <?php echo $background_caption; ?>
                                    <input type="text" name="cookiepolicy_background_colour" value="<?php echo $cookiepolicy_background_colour; ?>" size="8" class="color {required:false,hash:true}"  />
                                    <?php 
                                    $opacity = array(
                                        '0.1'               => '0.1',
                                        '0.2'               => '0.2',
                                        '0.3'               => '0.3',
                                        '0.4'               => '0.4',
                                        '0.5'               => '0.5',
                                        '0.6'               => '0.6',
                                        '0.7'               => '0.7',
                                        '0.8'               => '0.8',
                                        '0.9'               => '0.9',
                                        '1'                 => '1'
                                    );
                                    ?>
                                </td>
                                <td>
                                    <?php echo $opacity_caption; ?>
                                    <select name="cookiepolicy_opacity" id="cookie_opacity">
                                        <?php foreach ($opacity as $fv => $fc) { ?>
                                            <?php ($fv ==  $cookiepolicy_opacity) ? $currentop = 'selected' : $currentop=''; ?>
                                            <option value="<?php echo $fv; ?>" <?php echo $currentop; ?> ><?php echo $fc; ?></option>	
                                        <?php } ?>
                                    </select>
                                </td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td><label><?php echo $cookie_url_text; ?></label></td>
                                <td colspan="5">
                                    <?php echo $url_caption; ?>
                                    <input size="60" type="text" name="cookiepolicy_url" value="<?php echo $cookiepolicy_url; ?>" />
                                    <span class="customhelp"><?php echo $url_help; ?></span>
                                </td>
                            </tr>
                        </table>
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_the1path">
                        <div class="col-sm-6" style="text-align:center;"> 
                            <a href="http://the1path.com/support"><img src="https://dl.dropboxusercontent.com/u/62113108/The1Path/the1path-mod-tab-2.png" /></a>
                        </div>
                        <div class="col-sm-6" style="text-align:center;"> 
                        	<a href="http://the1path.com/opencart-themes-mods"><img src="https://dl.dropboxusercontent.com/u/62113108/The1Path/the1path-mod-tab-1.png" /></a>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>
<script type="text/javascript" src="view/javascript/jscolor/jscolor.js"></script> 