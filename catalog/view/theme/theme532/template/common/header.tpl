<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>"/>
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>"/>
    <?php } ?>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <?php } ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon"/>
    <?php } ?>
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>
    <?php $path="catalog/view/theme/theme532";?>
    <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>"
    media="<?php echo $style['media']; ?>"/>
    <?php } ?>
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
    <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"/>
	
    <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo $global_path ?>js/fancybox/jquery.fancybox.css" media="screen"/>
    <link href="<?php echo $global_path ?>stylesheet/owl-carousel.css" rel="stylesheet">
    <link href="<?php echo $global_path ?>stylesheet/photoswipe.css" rel="stylesheet">
    <link href="<?php echo $global_path ?>stylesheet/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $global_path ?>js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet">


    <link href="<?php echo $global_path ?>stylesheet/stylesheet.min.css" rel="stylesheet">
    <link href="<?php echo $global_path ?>stylesheet/stylesheet-mods.css" rel="stylesheet">
    <script src="<?php echo $global_path ?>js/common.min.js" type="text/javascript"></script>


    <!--[if lt IE 9]>
    <div style='clear:both;height:59px;padding:0 15px 0 15px;position:relative;z-index:10000;text-align:center;'>
        <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img
                src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0"
                height="42" width="820"
                alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
        </a>
    </div><![endif]-->
    <!--custom script-->
    <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>
    <script src="<?php echo $global_path ?>js/device.min.js" type="text/javascript"></script>
    <script src="<?php echo $global_path ?>js/jquery-scrolltofixed.min.js" type="text/javascript"></script>
    <?php echo $google_analytics; ?>
    <script>
        dataLayer = [];
    </script>
</head>
<body class="<?php echo $class; ?>">

<!-- Google Tag Manager -->
<!-- <?php echo $_SERVER['SERVER_NAME']; ?>-->
<?php $google_tagmanager_code = ($_SERVER['SERVER_NAME'] == 'www.oxbridgehomelearning.uk' || $_SERVER['SERVER_NAME'] == 'oxbridgehomelearning.uk') ? 'GTM-TBN25H' : 'GTM-MP6TDJ'; ?>
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $google_tagmanager_code; ?>"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $google_tagmanager_code; ?>');</script>
<!-- End Google Tag Manager -->

<p id="gl_path" class="hidden"><?php echo $global_path ?></p>
<!-- swipe menu -->
<div class="swipe">
    <div class="swipe-menu">
        <ul>

            <li>
                <a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>"><i class="fa fa-user"></i>
                    <span><?php echo $text_account; ?></span></a>
            </li>
            <?php if ($logged) { ?>
            <li>
                <a href="<?php echo $order; ?>"><i class="fa fa-file-text-o"></i><?php echo $text_order; ?></a>
            </li>
            <li>
                <a href="<?php echo $transaction; ?>"><i class="fa fa-exchange"></i><?php echo $text_transaction; ?></a>
            </li>
            <li>
                <a href="<?php echo $download; ?>"><i class="fa fa-download"></i><?php echo $text_download; ?></a>
            </li>
            <li>
                <a href="<?php echo $logout; ?>"><i class="fa fa-unlock"></i><?php echo $text_logout; ?></a>
            </li>
            <?php } else { ?>
            <li>
                <a href="<?php echo $register; ?>"><i class="fa fa-user"></i> <?php echo $text_register; ?></a>
            </li>
            <li>
                <a href="<?php echo $login; ?>"><i class="fa fa-lock"></i><?php echo $text_login; ?></a>
            </li>
            <?php } ?>
            <li>
                <a href="<?php echo $wishlist; ?>" id="wishlist-total2" title="<?php echo $text_wishlist; ?>"><i
                        class="fa fa-heart"></i> <span><?php echo $text_wishlist;?>(<?php echo $text_wishlist2?>)</span>
                </a>
            </li>
            <li>
                <a href="<?php echo $checkout; ?>" title="<?php echo $text_shopping_cart; ?>"><i
                        class="fa fa-shopping-cart"></i> <span><?php echo $text_shopping_cart; ?></span></a>
            </li>
            <!--
            <li>
                <a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><i class="fa fa-share"></i>
                    <span><?php echo $text_checkout; ?></span></a>
            </li>
            -->
        </ul>
        <?php if ($maintenance == 0){ ?>
        <ul class="foot">
            <?php if ($informations) { ?>
            <?php foreach ($informations as $information) { ?>
            <li>
                <a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a>
            </li>
            <?php } ?>
            <?php } ?>
        </ul>
        <?php } ?>
        <ul class="foot foot-1">
            <li>
                <a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a>
            </li>
            <li>
                <a href="<?php echo $return; ?>"><?php echo $text_return; ?></a>
            </li>
            <li>
                <a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a>
            </li>
        </ul>

        <ul class="foot foot-2">
            <li>
                <a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a>
            </li>
            <li>
                <a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a>
            </li>
            <li>
                <a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a>
            </li>
            <li>
                <a href="<?php echo $special; ?>"><?php echo $text_special; ?></a>
            </li>
        </ul>
        <ul class="foot foot-3">
            <li>
                <a href="<?php echo $order; ?>"><?php echo $text_order; ?></a>
            </li>
            <li>
                <a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a>
            </li>
        </ul>
    </div>
</div>
<div id="page">
    <div class="shadow"></div>
    <div class="toprow-1">
        <a class="swipe-control" href="#"><i class="fa fa-align-justify"></i></a>
    </div>

    <header class="header">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="logo" class="logo">
                        <?php if ($logo) { ?>
                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>"
                                                            alt="<?php echo $name; ?>" class="img-responsive"/>
                        </a>
                        <?php } else { ?>
                        <h1>
                            <a href="<?php echo $home; ?>"><?php echo $name; ?></a>
                        </h1>
                        <?php } ?>
                    </div>
                    <div class="box-right">
                        <div class="box-right_inner">
                            <?php echo $currency; ?>
                            <?php echo $language; ?>
                            <div id="top-links" class="nav">
                                <ul class="list-inline">
                                    <li class="first">
                                        <i class="fa"></i>
                                        <span style="font-size: larger;margin-right: 10px">Call us on: <a style="font-size: larger;color:#ff4f02; font-weight:bold;" href="tel:03332224010" onclick="ga('send', 'event', 'Phone Call', 'Click', 'Header');">0333 222 4010</a></span>
                                    </li>
                                    <li>
                                        <a href="<?php echo $home; ?>">
                                            <i class="fa fa-home"></i>
                                            <span><?php echo $text_home; ?></span>
                                        </a>
                                    </li>
                                    <!--
                                    <li>
                                        <a href="<?php echo $wishlist; ?>" id="wishlist-total"
                                           title="<?php echo $text_wishlist; ?>">
                                            <i class="fa fa-heart"></i>
                                            <span><?php echo $text_wishlist;?>
                                                <span class="count">(<?php echo $text_wishlist2;?>)</span>
                                            </span>
                                        </a>
                                    </li>
                                    -->
                                    <li>
                                        <a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>">
                                            <i class=" fa fa-user"></i>
                                            <span><?php echo $text_account; ?></span>
                                            <span class="caret"></span>
                                        </a>
                                        
                                    </li>
                                    <li>
                                        <a href="<?php echo $checkout; ?>"
                                           title="<?php echo $text_shopping_cart; ?>">
                                            <i class="fa fa-shopping-cart"></i>
                                            <span><?php echo $text_shopping_cart; ?></span>
                                        </a>
                                    </li>
                                    <!--
                                    <li>
									<a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>">
									 <i class="fa fa-share"></i>
									  <span><?php echo $text_checkout; ?></span>
									</a>
									</li>

									  <?php if ($logged) { ?>

                                            <li>
                                                <a href="<?php echo $order; ?>"><?php echo $text_order; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a>
                                            </li>
                                            <?php } else { ?>
                                            <li>
                                                <a href="<?php echo $register; ?>"><?php echo $text_register; ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo $login; ?>"><?php echo $text_login; ?></a>
                                            </li>
                                        <?php } ?>
                                    -->
                                </ul>
                            </div>
                        </div>
                          
                        
							<div class="cart-position">
								<div class="cart-inner"><?php echo $cart; ?></div>
							</div>
                              <!-- search -->
							<div id="search">
								<div class="inner">
									
									<?php echo $search; ?>
								</div>
							</div>

                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12"><?php if ($categories) { ?>
                    <div id="tm_menu" class="nav__primary">
                        <?php if ($categories_html) {  echo $categories_html; } ?>
                    </div>
                    <?php } ?></div>

            </div>
        </div>


        <?php if ($categories_html) { ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="menu-gadget" class="menu-gadget">
                        <div id="menu-icon" class="menu-icon"><?php echo $text_category; ?></div>
                        <?php if ($categories) {  echo $categories_html; } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>


    </header>

