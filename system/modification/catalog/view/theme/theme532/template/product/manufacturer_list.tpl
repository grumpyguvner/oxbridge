<?php echo $header; ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
	<?php if ($column_left && $column_right) { ?>
	<?php $class = 'col-sm-6'; ?>
	<?php } elseif ($column_left || $column_right) { ?>
	<?php $class = 'col-sm-9'; ?>
	<?php } else { ?>
	<?php $class = 'col-sm-12'; ?>
	<?php } ?>
	<div id="content" class="<?php echo $class; ?>">
		<ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li> <a href="<?php echo $breadcrumb['href']; ?>"> <?php echo $breadcrumb['text']; ?> </a> </li>
			<?php } ?>
		</ul>
		<?php echo $content_top; ?>
	  <h1><?php echo $heading_title; ?></h1>
	  <?php if ($categories) { ?>
	  <p><strong><?php echo $text_index; ?></strong>
		<?php foreach ($categories as $category) { ?>
		&nbsp;&nbsp;&nbsp;<a href="index.php?route=product/manufacturer#<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
		<?php } ?>
	  </p>
	  <?php foreach ($categories as $category) { ?>
		<div class="manufacturer-list">
		<div class="manufacturer-heading">
			<span id="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></span>
		</div>
	  <?php if ($category['manufacturer']) { ?>
	  <?php foreach (array_chunk($category['manufacturer'], 4) as $manufacturers) { ?>
	  <div class="manufacturer-content">
		<div class="row">
			<?php foreach ($manufacturers as $manufacturer) { ?>
			

                <div class="col-sm-3">
                    <?php if (($manufacturer_extended_show_image) && isset($manufacturer['image'])) { ?>
					    <img src="<?php echo $manufacturer['image']; ?>" class="img-responsive img-thumbnail manufacturer-logo pull-left" style="margin-right:10px;"/>
				    <?php } ?>
                    <h4><a href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a></h4>
                    <?php if (($manufacturer_extended_show_description) && isset($manufacturer['description'])) { ?>
                        <div class="manufacturer-description"><?php echo $manufacturer['description']; ?></div>
                    <?php } ?>
                </div>

                
			<?php } ?>
		</div>
	  </div>
	  <?php } ?>
	  <?php } ?>
	  </div>
	  <?php } ?>
	  <?php } else { ?>
	  <p><?php echo $text_empty; ?></p>
	  <div class="buttons clearfix">
		<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
	  </div>
	  <?php } ?>
	  <?php echo $content_bottom; ?></div>
	<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>