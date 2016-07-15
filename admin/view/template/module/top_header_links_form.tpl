<!--
#################################################################
## Open Cart Module:  ULTIMATE TOP HEADER MENU LINKS MANAGER   ##
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
        <button type="submit" form="form-header" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-header" class="form-horizontal">
          
           <table id="header_group" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left required"><?php echo $entry_group; ?></td>
                <td class="text-right"><?php echo $entry_link; ?></td>
                <td class="text-left"><?php echo $entry_store; ?></td>    
                <td class="text-right"><?php echo $entry_columns; ?></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
              </tr>
            </thead>
            <tbody>
            	<tr>
                	<td class="text-left">
                    <?php foreach ($languages as $language) { ?>
                    <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="header_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($header_group_description[$language['language_id']]) ? $header_group_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_group; ?>" class="form-control" />
                    </div>
                    <?php if (isset($error_group[$language['language_id']])) { ?>
                    <div class="text-danger"><?php echo $error_group[$language['language_id']]; ?></div>
                    <?php } ?>
                    <?php } ?>
                    </td>
                   	<td class="text-right">
                    
                    
                   <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="header_group[<?php echo $language['language_id']; ?>][link]" value="<?php echo isset($header_group[$language['language_id']]) ? $header_group[$language['language_id']]['link'] : ''; ?>" placeholder="<?php echo $entry_link; ?>" class="form-control" />
                  </div>
                  
                  <?php } ?>
                    
                    <td>
                    
                    <div class="form-group">
          
                    <div class="col-sm-10">
                      <div class="well well-sm" style="height: 150px; overflow: auto; width: 200px;">
                        <div class="checkbox">
                          <label>
                            <?php if (in_array(0, $link_store)) { ?>
                            <input type="checkbox" name="link_store[]" value="0" checked="checked" />
                            <?php echo $text_default; ?>
                            <?php } else { ?>
                            <input type="checkbox" name="link_store[]" value="0" />
                            <?php echo $text_default; ?>
                            <?php } ?>
                          </label>
                        </div>
                        <?php foreach ($stores as $store) { ?>
                        <div class="checkbox">
                          <label>
                            <?php if (in_array($store['store_id'], $link_store)) { ?>
                            <input type="checkbox" name="link_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                            <?php echo $store['name']; ?>
                            <?php } else { ?>
                            <input type="checkbox" name="link_store[]" value="<?php echo $store['store_id']; ?>" />
                            <?php echo $store['name']; ?>
                            <?php } ?>
                          </label>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                    </td>

                    
                    
                    
                    
                    
                    <td class="text-right"><input type="text" name="columns" value="<?php echo $columns; ?>" placeholder="<?php echo $entry_columns; ?>" id="input-columns" class="form-control" /></td>
                    
                    </td>
                    <td class="text-right"><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>
                    
                </tr>
                </tbody>
                </table>
          
          
          
     
          <table id="header" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left required"><?php echo $entry_name ?></td>
                <td class="text-right"><?php echo $entry_link; ?></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
                <td class="text-right"></td>
              </tr>
            </thead>
            <tbody>
              <?php $header_row = 0; ?>
              <?php foreach ($headers as $header) { ?>
              <tr id="header-row<?php echo $header_row; ?>">
                <td class="text-left"><input type="hidden" name="header[<?php echo $header_row; ?>][header_id]" value="<?php echo $header['header_id']; ?>" />
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="header[<?php echo $header_row; ?>][header_description][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($header['header_description'][$language['language_id']]) ? $header['header_description'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_header[$header_row][$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_header[$header_row][$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?></td>
            
                  
                  <td class="text-left">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="header[<?php echo $header_row; ?>][header_link][<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($header['header_link'][$language['language_id']]) ? $header['header_link'][$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_link ?>" class="form-control" />
                  </div>
                  <?php if (isset($error_link[$header_row][$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_link[$header_row][$language['language_id']]; ?></div>
                  <?php } ?>
                  <?php } ?></td>
                  
                  
                  
                  
                  
                <td class="text-right"><input type="text" name="header[<?php echo $header_row; ?>][sort_order]" value="<?php echo $header['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>
                <td class="text-left"><button type="button" onclick="$('#header-row<?php echo $header_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $header_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2"></td>
                <td class="text-left"><a onclick="addFilterRow();" data-toggle="tooltip" title="<?php echo $button_header_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></a></td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
var header_row = <?php echo $header_row; ?>;

function addFilterRow() {
	html  = '<tr id="header-row' + header_row + '">';	
    html += '  <td class="text-left"><input type="hidden" name="header[' + header_row + '][header_id]" value="" />';
	<?php foreach ($languages as $language) { ?>
	html += '  <div class="input-group">';
	html += '    <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="header[' + header_row + '][header_description][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_name ?>" class="form-control" />';
    html += '  </div>';
	<?php } ?>
	html += '  </td>';
    
    
    html += '  <td class="text-left">';
	<?php foreach ($languages as $language) { ?>
	html += '  <div class="input-group">';
	html += '    <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span><input type="text" name="header[' + header_row + '][header_link][<?php echo $language['language_id']; ?>][name]" value="" placeholder="<?php echo $entry_link ?>" class="form-control" />';
    html += '  </div>';
	<?php } ?>
	html += '  </td>';
    
    
    
	html += '  <td class="text-right"><input type="text" name="header[' + header_row + '][sort_order]" value="" value="" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#header-row' + header_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#header tbody').append(html);
	
	header_row++;
}
//--></script></div>
<?php echo $footer; ?> 