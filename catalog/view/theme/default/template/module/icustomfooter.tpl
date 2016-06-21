<?php if (!empty($icustomfooter)) { echo $icustomfooter; ?>

    <div id="icustomfooter-informational" class="icustomfooter-wrapper <?php echo $idata['Settings']['BackgroundPattern']; ?>">
        <div id="icustomfooter_default_footer">
            <div class="icustomfooter_default_footer_wrapper">
                <?php if ($idata['Settings']['UseFooterWith'] == 'defaultocwithicons') : ?>
                    <div class="column grid_footer_3">
                        <h3><?php echo $text_information; ?></h3>
                        <ul>
                          <?php foreach ($informations as $information) { ?>
                          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                          <?php } ?>
                        </ul>
                    </div>
                    <div class="column grid_footer_3">
                        <h3><?php echo $text_service; ?></h3>
                        <ul>
                          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
                          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
                          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
                        </ul>
                    </div>
                    <div class="column grid_footer_3">
                        <h3><?php echo $text_extra; ?></h3>
                        <ul>
                          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
                          <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
                          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
                          <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
                        </ul>
                    </div>
                    <div class="column grid_footer_3">
                        <h3><?php echo $text_account; ?></h3>
                        <ul>
                          <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
                          <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
                          <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="footerDivider"></div>
                <?php endif; ?>
              
                <?php if ($idata['Settings']['UseFooterWith'] == 'defaultocwithicons' || $idata['Settings']['UseFooterWith'] == 'icons') : ?>
                  <div class="wrapper">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <?php if ($idata['Settings']['SocialButtons']['Show'] == 'true'): ?>
                                <ul class="iButtons">
                                    <?php if ($idata['Settings']['SocialButtons']['PinterestPin']['Show'] == 'true'): ?>
                                        <li class="iPinterest iButton">
                                            <a href="http://pinterest.com/pin/create/button/" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                                            <script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
                                        </li>
                                    <?php endif; ?> 
                                    <?php if ($idata['Settings']['SocialButtons']['GooglePlus']['Show'] == 'true'): ?>
                                        <li class="iGooglePlus iButton">
                                            <g:plusone size="medium" annotation="none"></g:plusone>
                                            <script type="text/javascript">
                                              (function() {
                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                po.src = 'https://apis.google.com/js/plusone.js';
                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                              })();
                                            </script>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($idata['Settings']['SocialButtons']['TwitterPin']['Show'] == 'true'): ?>
                                        <li class="iTwitterPin iButton" style="width:90px;">	
                                            <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
                                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($idata['Settings']['SocialButtons']['FacebookLike']['Show'] == 'true'): ?>
                                        <li class="iFacebook iButton">
                                            <div id="fb-root"></div>
                                            <script>(function(d, s, id) {
                                              var js, fjs = d.getElementsByTagName(s)[0];
                                              if (d.getElementById(id)) return;
                                              js = d.createElement(s); js.id = id;
                                              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=159650554163037";
                                              fjs.parentNode.insertBefore(js, fjs);
                                            }(document, 'script', 'facebook-jssdk'));</script>
                                            <fb:like send="false" layout="button_count" width="200" show_faces="false"></fb:like>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($idata['Settings']['SocialButtons']['LinkedInShare']['Show'] == 'true'): ?>
                                        <li class="iLinkedInShare iButton">
                                        	<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US </script>
											<script type="IN/Share" data-counter="right"></script>
                                        </li>
                                    <?php endif; ?>
                                    <li class="clearfix"></li>
                                </ul>
                                <?php endif; ?>
                            </td>  
                            <td style="width: 180px">
                                <?php $poweredClass = ($idata['Settings']['SocialButtons']['Show'] == 'true') ? ($idata['Settings']['PaymentIcons']['Show'] == 'true') ? '' : 'rightAlign' : 'leftAlign'; ?>
                                <?php $poweredClass = ($idata['Settings']['PaymentIcons']['Show'] == 'false' && $idata['Settings']['SocialButtons']['Show'] == 'false') ? '' : $poweredClass; ?>
                                <div id="powered" style="width: 180px;background: transparent;" class="<?php echo $poweredClass; ?>"><?php echo $powered; ?></div>
                            </td>
                            <td>     
                                  <?php if ($idata['Settings']['PaymentIcons']['Show'] == 'true'): ?>
                                  <?php 
                                
                                    $fulldir = 'image/icustomfooter/paymenticons/';
                                    $raw_image_files = scandir($fulldir);
                                    $imgurl = 'image/icustomfooter/paymenticons/';
                                
                                    $image_files = array();
                                    foreach ($raw_image_files as $key => $value) {
                                        if (strstr($value,'.png') !== false || strstr($value,'.jpg') !== false || strstr($value,'.gif') !== false) {
                                            $name = $value;  $name = str_replace('.png','',$name); $name = str_replace('.jpg','',$name);
                                            $name = str_replace('.gif','',$name); $name = preg_replace('/[^a-z ]/i', '', $name);
                                            array_push($image_files,array('path' => $imgurl. $value, 'name'=>$name, 'origname' => $value));
                                        }
                                    }
                                    
                                  
                                  ?> 
                                  <div class="payment-methods">
                                    <table>
                                        <tr>
                                            <td>
                                                <?php foreach ($image_files as $key => $img) { ?>
                                                    <img src="<?php echo $img['path']; ?>" title="<?php echo $img['name']; ?>"/>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="clearfix"></div>
                                  </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                      </table>
                  </div>
            	<?php endif; ?>
            </div>
        </div>
    </div>
        
<?php } ?>
    
</div>
</body>
</html>