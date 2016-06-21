<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <?php if ($apply_btn) { ?>
        <a onclick="$('#apply').val('1'); $('#form-showcase').submit();" class="btn btn-success" data-toggle="tooltip" title="<?php echo $button_apply; ?>" role="button"><i class="fa fa-check"></i> <span class="hidden-sm"> <?php echo $button_apply; ?></span></a>
        <?php } ?>
        <button type="submit" form="form-showcase" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <span class="hidden-sm"> <?php echo $button_save; ?></span></button>
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
        <?php if ($success) { ?>
        <div class="sc-apply text-success pull-right"><i class="fa fa-check"></i> <?php echo $success; ?></div>
        <?php } ?>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-showcase" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-4">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-4">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <hr />
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
            <div class="col-sm-4">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"> <span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="showcase[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($showcase[$language['language_id']]['title']) ? $showcase[$language['language_id']]['title'] : ''; ?>" class="form-control" />
              </div>
              <br />
              <?php } ?>
            </div>
          </div>
          <hr />
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_items; ?></label>
            <div class="col-sm-4">
              <div class="radio">
                <label>
                  <input type="radio" name="showcase[cat]" value="1" <?php echo isset($showcase['cat']) ? 'checked="checked"' : ''; ?> onchange="if($(this).prop('checked')) {$('#categories,#cat-settings').show();$('#brands').hide();}" />
                  <?php echo $entry_cat; ?> </label>
              </div>
              <div class="radio">
                <label>
                  <input type="radio" name="showcase[cat]" value="0" <?php echo empty($showcase['cat']) ? 'checked="checked"' : ''; ?> onchange="if($(this).prop('checked')) {$('#categories,#cat-settings').hide();$('#brands').show();}" />
                  <?php echo $entry_brands; ?> </label>
              </div>
            </div>
          </div>
          <hr />
          <div id="categories" <?php echo !empty($showcase['cat']) ? '' : 'style="display:none;"'; ?>>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_cat; ?></label>
              <div class="col-sm-4">
                <div class="radio">
                  <label>
                    <input type="radio" name="showcase[allcat]" value="1" <?php echo isset($showcase['allcat']) ? 'checked="checked"' : ''; ?> onchange="if($(this).prop('checked')) {$('#featured-categories').hide();$('#current').show();}" />
                    <?php echo $text_allcat; ?> </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="showcase[allcat]" value="0" <?php echo empty($showcase['allcat']) ? 'checked="checked"' : ''; ?> onchange="if($(this).prop('checked')) {$('#featured-categories').show();$('#current').hide();}" />
                    <?php echo $text_fcat; ?> </label>
                </div>
              </div>
            </div>
            <div id="featured-categories" <?php echo !empty($showcase['allcat']) ? 'style="display:none;"' : ''; ?>>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                  <input type="text" name="showcase[fcat]" value="" placeholder="<?php echo $text_fcat; ?>" id="input-fcat" class="form-control" />
                  <div id="showcase-fcat" class="well well-sm" style="height: 150px; overflow: auto; margin-bottom: 0;">
                    <?php foreach ($categories as $category) { ?>
                    <div id="showcase-fcat<?php echo $category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category['name']; ?>
                      <input type="hidden" name="showcase[fcat][]" value="<?php echo $category['category_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="brands" <?php echo !empty($showcase['cat']) ? 'style="display:none;"' : ''; ?>>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_brands; ?></label>
              <div class="col-sm-4">
                <div class="radio">
                  <label>
                    <input type="radio" name="showcase[allbrands]" value="1" <?php echo isset($showcase['allbrands']) ? 'checked="checked"' : ''; ?> onchange="if($(this).prop('checked')) {$('#featured-brands').hide();}" />
                    <?php echo $text_allbrands; ?> </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="showcase[allbrands]" value="0" <?php echo empty($showcase['allbrands']) ? 'checked="checked"' : ''; ?> onchange="if($(this).prop('checked')) {$('#featured-brands').show();}" />
                    <?php echo $text_fbrands; ?> </label>
                </div>
              </div>
            </div>
            <div id="featured-brands" <?php echo !empty($showcase['allbrands']) ? 'style="display:none;"' : ''; ?>>
              <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                  <input type="text" name="showcase[fbrand]" value="" placeholder="<?php echo $text_fbrands; ?>" id="input-fbrand" class="form-control" />
                  <div id="showcase-fbrand" class="well well-sm" style="height: 150px; overflow: auto; margin-bottom: 0;">
                    <?php foreach ($brands as $brand) { ?>
                    <div id="showcase-fbrand<?php echo $brand['brand_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $brand['name']; ?>
                      <input type="hidden" name="showcase[fbrand][]" value="<?php echo $brand['brand_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="cat-settings" class="form-group" <?php echo !empty($showcase['cat']) ? '' : 'style="display:none;"'; ?>>
            <div class="col-sm-10 col-sm-offset-2">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="showcase[subitems]" value="1" <?php echo isset($showcase['subitems']) ? 'checked="checked"' : ''; ?> />
                  <?php echo $entry_subitems; ?> </label>
              </div>
              <div class="checkbox" id="current" <?php echo !empty($showcase['allcat']) ? '' : 'style="display:none;"'; ?>>
                <label>
                  <input type="checkbox" name="showcase[current]" value="1" <?php echo isset($showcase['current']) ? 'checked="checked"' : ''; ?> />
                  <?php echo $text_current; ?> </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="showcase[hide_empty]" value="1" <?php echo isset($showcase['hide_empty']) ? 'checked="checked"' : ''; ?> />
                  <?php echo $text_empty; ?> </label>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="showcase[count_status]" value="1" <?php echo isset($showcase['count_status']) ? 'checked="checked"' : ''; ?> />
                  <?php echo $text_count; ?> </label>
              </div>
            </div>
          </div>
          <br />
          <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
              <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#items" data-toggle="tab">
                  <h4><?php echo $tab_items; ?></h4>
                  </a></li>
                <li><a href="#subitems" data-toggle="tab">
                  <h4><?php echo $tab_subitems; ?></h4>
                  </a></li>
              </ul>
            </div>
          </div>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="items">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[parent_image]" value="1" <?php echo isset($showcase['parent_image']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_width; ?></span>
                        <input type="text" name="showcase[parent_width]" value="<?php echo !empty($showcase['parent_width']) ? $showcase['parent_width'] : '200'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_height; ?></span>
                        <input type="text" name="showcase[parent_height]" value="<?php echo !empty($showcase['parent_height']) ? $showcase['parent_height'] : '200'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_desc; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[parent_desc]" value="1" <?php echo isset($showcase['parent_desc']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_desc_limit; ?></span>
                        <input type="text" name="showcase[parent_desc_limit]" value="<?php echo !empty($showcase['parent_desc_limit']) ? $showcase['parent_desc_limit'] : ''; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_btn_more; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[parent_btn_more]" value="1" <?php echo isset($showcase['parent_btn_more']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_btn_text; ?></span>
                        <input type="text" name="showcase[parent_btn_text]" value="<?php echo !empty($showcase['parent_btn_text']) ? $showcase['parent_btn_text'] : 'View More'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <br />
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <h3><?php echo $entry_carousel; ?></h3>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_parent; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_xs; ?></span>
                        <input type="text" name="showcase[parent_items_xs]" value="<?php echo !empty($showcase['parent_items_xs']) ? $showcase['parent_items_xs'] : '2'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_sm; ?></span>
                        <input type="text" name="showcase[parent_items_sm]" value="<?php echo !empty($showcase['parent_items_sm']) ? $showcase['parent_items_sm'] : '3'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_md; ?></span>
                        <input type="text" name="showcase[parent_items_md]" value="<?php echo !empty($showcase['parent_items_md']) ? $showcase['parent_items_md'] : '4'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_lg; ?></span>
                        <input type="text" name="showcase[parent_items_lg]" value="<?php echo !empty($showcase['parent_items_lg']) ? $showcase['parent_items_lg'] : '4'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_margin; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <input type="text" name="showcase[parent_margin]" value="<?php echo !empty($showcase['parent_margin']) ? $showcase['parent_margin'] : '20'; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[parent_mousewheel]" value="1" <?php echo isset($showcase['parent_mousewheel']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_mousewheel; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[parent_dots]" value="1" <?php echo isset($showcase['parent_dots']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_dots; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[parent_nav]" value="1" <?php echo isset($showcase['parent_nav']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_nav; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_prev_nav; ?></span>
                        <input type="text" name="showcase[parent_prev_nav]" value="<?php echo !empty($showcase['parent_prev_nav']) ? $showcase['parent_prev_nav'] : '<'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_next_nav; ?></span>
                        <input type="text" name="showcase[parent_next_nav]" value="<?php echo !empty($showcase['parent_next_nav']) ? $showcase['parent_next_nav'] : '>'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_nav_speed; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <input type="text" name="showcase[parent_nav_speed]" value="<?php echo !empty($showcase['parent_nav_speed']) ? $showcase['parent_nav_speed'] : '200'; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="subitems">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[child_image]" value="1" <?php echo isset($showcase['child_image']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_width; ?></span>
                        <input type="text" name="showcase[child_width]" value="<?php echo !empty($showcase['child_width']) ? $showcase['child_width'] : '200'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_height; ?></span>
                        <input type="text" name="showcase[child_height]" value="<?php echo !empty($showcase['child_height']) ? $showcase['child_height'] : '200'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_subitems_desc; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[child_desc]" value="1" <?php echo isset($showcase['child_desc']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_desc_limit; ?></span>
                        <input type="text" name="showcase[child_desc_limit]" value="<?php echo !empty($showcase['child_desc_limit']) ? $showcase['child_desc_limit'] : ''; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_parent_desc; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[description_status]" value="1" <?php echo isset($showcase['description_status']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_desc_limit; ?></span>
                        <input type="text" name="showcase[description_limit]" value="<?php echo !empty($showcase['description_limit']) ? $showcase['description_limit'] : ''; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_btn_more; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[child_btn_more]" value="1" <?php echo isset($showcase['child_btn_more']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_status; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_btn_text; ?></span>
                        <input type="text" name="showcase[child_btn_text]" value="<?php echo !empty($showcase['child_btn_text']) ? $showcase['child_btn_text'] : 'View More'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr />
              <br />
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <h3><?php echo $entry_carousel; ?></h3>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_child; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_xs; ?></span>
                        <input type="text" name="showcase[child_items_xs]" value="<?php echo !empty($showcase['child_items_xs']) ? $showcase['child_items_xs'] : '2'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_sm; ?></span>
                        <input type="text" name="showcase[child_items_sm]" value="<?php echo !empty($showcase['child_items_sm']) ? $showcase['child_items_sm'] : '3'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_md; ?></span>
                        <input type="text" name="showcase[child_items_md]" value="<?php echo !empty($showcase['child_items_md']) ? $showcase['child_items_md'] : '4'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $text_lg; ?></span>
                        <input type="text" name="showcase[child_items_lg]" value="<?php echo !empty($showcase['child_items_lg']) ? $showcase['child_items_lg'] : '4'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_margin; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <input type="text" name="showcase[child_margin]" value="<?php echo !empty($showcase['child_margin']) ? $showcase['child_margin'] : '20'; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[child_mousewheel]" value="1" <?php echo isset($showcase['child_mousewheel']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_mousewheel; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[child_dots]" value="1" <?php echo isset($showcase['child_dots']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_dots; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="showcase[child_nav]" value="1" <?php echo isset($showcase['child_nav']) ? 'checked="checked"' : ''; ?> />
                      <?php echo $entry_nav; ?> </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_nav_text; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_prev_nav; ?></span>
                        <input type="text" name="showcase[child_prev_nav]" value="<?php echo !empty($showcase['child_prev_nav']) ? $showcase['child_prev_nav'] : '<'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="input-group"> <span class="input-group-addon"><?php echo $entry_next_nav; ?></span>
                        <input type="text" name="showcase[child_next_nav]" value="<?php echo !empty($showcase['child_next_nav']) ? $showcase['child_next_nav'] : '>'; ?>" class="form-control text-center" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_nav_speed; ?></label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-md-3 col-sm-6">
                      <input type="text" name="showcase[child_nav_speed]" value="<?php echo !empty($showcase['child_nav_speed']) ? $showcase['child_nav_speed'] : '200'; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="apply" id="apply" value="0" />
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('.sc-apply').delay(5000).fadeOut(300);
$('input[name=\'showcase[fcat]\']').autocomplete({
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  select: function(item) {
    $('input[name=\'showcase[fcat]\']').val('');
    
    $('#showcase-fcat' + item['value']).remove();
    
    $('#showcase-fcat').append('<div id="showcase-fcat' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="showcase[fcat][]" value="' + item['value'] + '" /></div>');  
  }
});
  
$('#showcase-fcat').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

$('input[name=\'showcase[fbrand]\']').autocomplete({
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['manufacturer_id']
          }
        }));
      }
    });
  },
  select: function(item) {
    $('input[name=\'showcase[fbrand]\']').val('');
    
    $('#showcase-fbrand' + item['value']).remove();
    
    $('#showcase-fbrand').append('<div id="showcase-fbrand' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="showcase[fbrand][]" value="' + item['value'] + '" /></div>');  
  }
});
  
$('#showcase-fbrand').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});
//--></script> 
</div>
<?php echo $footer; ?>