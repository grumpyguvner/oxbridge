<!--
#################################################################
## Open Cart Module:  CONTACT US SUPPORT DEPARTAMENTS          ##
##-------------------------------------------------------------##
## Copyright © 2015 MB "Programanija" All rights reserved.     ##
## http://www.opencartextensions.eu						       ##
## http://www.extensionsmarket.com 						       ##
##-------------------------------------------------------------##
## Permission is hereby granted, when purchased, to  use this  ##
## mod on one domain. This mod may not be reproduced, copied,  ##
## redistributed, published and/or sold.				       ##
##-------------------------------------------------------------##
## Violation of these rules will cause loss of future mod      ##
## updates and account deletion				      			   ##
#################################################################
-->
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-departament" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-departament" class="form-horizontal">
          
           <table id="departament_group" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left required"><?php echo $entry_group; ?></td>
                <td class="text-right"><span data-toggle="tooltip" title="<?php echo $help_master_email; ?>"><?php echo $entry_master_email; ?></span></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
              </tr>
            </thead>
            <tbody>
            	<tr>
                	<td class="text-left">
                    <?php foreach ($languages as $language) { ?>
                    <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="departament_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($departament_group_description[$language['language_id']]) ? $departament_group_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_group; ?>" class="form-control" />
                    </div>
                    <?php if (isset($error_group[$language['language_id']])) { ?>
                    <div class="text-danger"><?php echo $error_group[$language['language_id']]; ?></div>
                    <?php } ?>
                    <?php } ?>
                    </td>
                   	<td class="text-right">
                    
                    
                   <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="departament_group_description[<?php echo $language['language_id']; ?>][email]" value="<?php echo isset($departament_group_description[$language['language_id']]) ? $departament_group_description[$language['language_id']]['email'] : ''; ?>" placeholder="<?php echo $entry_email; ?>" class="form-control" />
                  </div>
                  
                  <?php } ?>
                    
                    
                   
                    <td class="text-right"><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>
                    
                </tr>
                </tbody>
                </table>
          
          
          
     
          <table id="departament" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left required"><?php echo $entry_name ?></td>
                <td class="text-right"><?php echo $entry_email; ?></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
                <td class="text-right"></td>
              </tr>
            </thead>
            <tbody>
              <?php $departament_row = 0; ?>
              <?php foreach ($departaments as $departament) { ?>
              <tr id="departament-row<?php echo $departament_row; ?>">
                <td class="text-left"><input type="hidden" name="departament[<?php echo $departament_row; ?>][departament_id]" value="<?php echo $departament['departament_id']; ?>" />
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="departament[<?php echo $departament_row; ?>][departament_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($departament['departament_description'][$language['language_id']]) ? $departament['departament_description'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_departament[$departament_row][$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_departament[$departament_row][$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?></td>
            
                  
                  <td class="text-left">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="departament[<?php echo $departament_row; ?>][departament_email][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($departament['departament_email'][$language['language_id']]) ? $departament['departament_email'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_email ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_email[$departament_row][$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_email[$departament_row][$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?></td>
                  
                  
                  
                  
                  
                <td class="text-right"><input type="text" name="departament[<?php echo $departament_row; ?>][sort_order]" value="<?php echo $departament['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>
                <td class="text-left"><button type="button" onclick="$('#departament-row<?php echo $departament_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $departament_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td class="text-left"><a onclick="addFilterRow();" data-toggle="tooltip" title="<?php echo $button_departament_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a></td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
var departament_row = <?php echo $departament_row; ?>;

function addFilterRow() {
	html  = '<tr id="departament-row' + departament_row + '">';	
    html += '  <td class="text-left"><input type="hidden" name="departament[' + departament_row + '][departament_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '  <div class="input-group">';
	html += '    <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="departament[' + departament_row + '][departament_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_name ?>" class="form-control" />';
    html += '  </div>';
	<?php } ?>
	html += '  </td>';
    
    
    html += '  <td class="text-left">';
	<?php foreach ($languages as $language) { ?>
	html += '  <div class="input-group">';
	html += '    <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="departament[' + departament_row + '][departament_email][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_email ?>" class="form-control" />';
    html += '  </div>';
	<?php } ?>
	html += '  </td>';
    
    
    
	html += '  <td class="text-right"><input type="text" name="departament[' + departament_row + '][sort_order]" value="" value="" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#departament-row' + departament_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#departament tbody').append(html);
	
	departament_row++;
}
//--></script></div>
<?php echo $footer; ?> 