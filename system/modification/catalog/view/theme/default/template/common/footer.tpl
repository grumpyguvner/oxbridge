
			<?php if (!empty($icustomfooter)) echo $icustomfooter; ?>
			
<footer>
  <div class="container">
    <div class="row">
      <?php if ($informations) { ?>
      <div class="col-sm-3">
        <h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
      <div class="col-sm-3">
        <h5><?php echo $text_service; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_extra; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
        </ul>
      </div>
      <div class="col-sm-3">
        <h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul>
      </div>
    </div>
    <hr>
    <p><?php echo $powered; ?></p>
  </div>
</footer>

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->


				<?php
				global $config;
				if($config->get('cookiepolicy_status') == 1) { 
				?>
					<script type="text/javascript" >
						var text_before = "<?php echo $text_before; ?>";
						var link_text = "<?php echo $link_text; ?>";
						var text_after = "<?php echo $text_after; ?>";
						var accept_text = "<?php echo $accept_text; ?>";
						var cookie_url = "<?php echo $config->get('cookiepolicy_url'); ?>";
					</script>
					<script src="catalog/view/javascript/jquery.cookie.js"></script>
					<script src="catalog/view/javascript/jquery.cookiecuttr.js"></script>
					<link rel="stylesheet" href="catalog/view/javascript/cookie.css">
					<style>
						a.cc-cookie-accept {
							color: <?php echo $config->get('cookiepolicy_accept_text_colour'); ?>;
							background: <?php echo $config->get('cookiepolicy_accept_button_colour'); ?>;
						}
						a.cc-cookie-accept:hover {
							color: <?php echo $config->get('cookiepolicy_accept_text_hover'); ?>;
							background: <?php echo $config->get('cookiepolicy_accept_button_hover'); ?>;
						}
						.cc-cookies, .cc-cookies a {
							color: <?php echo $config->get('cookiepolicy_text_colour'); ?>;
						}
						.cc-cookies:before {
							opacity: <?php echo $config->get('cookiepolicy_opacity'); ?>;
							background: <?php echo $config->get('cookiepolicy_background_colour'); ?>;
						}
						<?php if($config->get('cookiepolicy_rounded_corners')!='') { ?>
							a.cc-cookie-accept {
								-webkit-border-radius: 3px 3px 3px 3px;
								border-radius: 3px 3px 3px 3px;
							}
						<?php }?>
					</style>
					
					<?php
						switch ($config->get('cookiepolicy_position')) { 
							case "1":
								echo '<style>.cc-cookies{bottom:0;}</style>';
								break; 
							case "2":
								echo '<style>.cc-cookies{top:0;}</style>';
								break;
							case "3":
								echo '<style>.cc-cookies{padding:15%; height:100%; top:0;}</style>';
								break;
						}
					?>
					<script>
						$(document).ready(function () {
							$.cookieCuttr();	
						});
					</script>
				<?php } ?>
			

                <?php
                    require_once DIR_SYSTEM . 'nitro/core/core.php';
                    require_once NITRO_INCLUDE_FOLDER . 'pagecache_widget.php';
                ?>
            
</body></html>