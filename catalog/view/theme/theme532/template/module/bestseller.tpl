<div class="box bestsellers">
    <div class="box-heading">
        <h3><?php echo $heading_title; ?></h3>
    </div>
    <div class="box-content">
        <?php  $f=0; foreach ($products as $product) { $f++ ?>
        <div class="product-layout col-sm-3 col-lg-3 col-md-3">
            <div class="product-thumb transition">

                <div class="image">
                    <a class="lazy" style="padding-bottom: <?php echo ($product['img-height']/$product['img-width']*100); ?>%" href="<?php echo $product['href']; ?>">
                        <img alt="<?php echo $product['name']; ?>"
                             title="<?php echo $product['name']; ?>"
                             class="img-responsive"
                             data-src="<?php echo $product['thumb']; ?>"
                             src="#"/></a>
                </div>
                <div class="caption">
                    
                    <div class="name">
                        <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    </div>
                    <div class="description"><?php echo $product['description']; ?></div>
<?php if ($product['rating']) { ?>
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <?php if ($product['rating'] < $i) { ?>
                        <span class="fa fa-stack"><i class="fa fa-star none-star fa-stack-2x"></i></span>
                        <?php } else { ?>
                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i>
                                    <i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
					<?php if ($product['price']) { ?>
                    <div class="price">
                        <?php if (!$product['special']) { ?>
                        <?php echo $product['price']; ?>
                        <?php } else { ?>
                        <span class="price-new"><?php echo $product['special']; ?></span> <span
                            class="price-old"><?php echo $product['price']; ?></span>
                        <?php } ?>
                        <?php if ($product['tax']) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="cart-button">
                        <button class="btn product-btn product-btn-add" type="button"
                                title="<?php echo $button_cart; ?>"
                                onclick="cart.add('<?php echo $product['product_id']; ?>');"><i
                                class="fa fa-shopping-cart"></i>
                        </button>
                    </div>



                </div>

                <div class="clear"></div>
            </div>
        </div>

        <?php } ?>

    </div>
</div>

