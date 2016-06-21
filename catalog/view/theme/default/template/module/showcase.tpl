<?php if ($title) { ?>
<div class="sc-heading">
    <h3><?php echo $title; ?></h3>
</div>
<?php } ?>

<div class="row">
    <?php foreach ($items as $item) { ?>
    <div class="product-layout col-lg-4 col-md-4 col-sm-4 col-xs-12" >
        <div class="product-thumb" data-equal-group="3">
            <div class="image">
                <a href="<?php echo $item['href']; ?>">
                    <img alt="<?php echo $item['name']; ?>"
                         title="<?php echo $item['name']; ?>"
                         class="img-responsive"
                         src="<?php echo $item['thumb']; ?>"/></a>
            </div>
            <div class="caption">

                <div class="name">
                    <a href="<?php echo $item['href']; ?>"><?php echo $item['name']; ?></a>
                </div>
                <div class=""><?php echo $item['parent_desc']; ?></div>

                <?php if ($parent_btn_more) { ?>
                <div class="sc-btn"> <a class="btn" href="<?php echo $item['href']; ?>" role="button"><?php echo $parent_btn_text; ?></a> </div>
                <?php } ?>



            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php } ?>
</div>
