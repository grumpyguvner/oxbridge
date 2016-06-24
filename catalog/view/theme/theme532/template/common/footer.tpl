<footer>
    <?php if (empty($icustomfooter)) { ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?php if ($informations) { ?>
                <div class="footer_box">
                    <h5 data-equal-group="2"><?php echo $text_information; ?></h5>
                    <ul class="list-unstyled">
                        <?php foreach ($informations as $information) { ?>
                        <li>
                            <a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="footer_box">
                    <h5 data-equal-group="2"><?php echo $text_service; ?></h5>
                    <ul class="list-unstyled">
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
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="footer_box">
                    <h5 data-equal-group="2"><?php echo $text_extra; ?></h5>
                    <ul class="list-unstyled">
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
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="footer_box">
                    <h5 data-equal-group="2"><?php echo $text_account; ?></h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $order; ?>"><?php echo $text_order; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            

        </div>
    </div>
    <?php } ?>
    <div class="copyright" style="margin-bottom: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $powered; ?>
                </div>
                <div class="col-sm-6 text-right" style="padding-right: 24px;">
                    <a href="https://www.facebook.com/oxbridgehome" rel="nofollow" target="_blank">
                        <img src="https://oxbridgehomelearning.uk/image/catalog/email/facebook_30x30.png" width="30" height="30" alt="Facebook">
                    </a> &nbsp;

                    <a href="https://www.twitter.com/oxbridgehome" rel="nofollow" target="_blank">
                        <img src="https://oxbridgehomelearning.uk/image/catalog/email/twitter_30x30.png" width="30" height="30" alt="Twitter">
                    </a> &nbsp;

                    <a href="https://plus.google.com/+OxbridgehomelearningUk" rel="nofollow" target="_blank">
                        <img src="https://oxbridgehomelearning.uk/image/catalog/email/google_30x30.png" width="30" height="30" alt="GooglePlus">
                    </a> &nbsp;

                    <a href="https://www.linkedin.com/company/oxbridge-home-learning" rel="nofollow" target="_blank">
                        <img src="https://oxbridgehomelearning.uk/image/catalog/email/linkedin_30x30.png" width="30" height="30" alt="LinkedIn">
                    </a> &nbsp;

                </div>
            </div>
        </div>
    </div>

</footer>
</div>

<script src="<?php echo $global_path ?>js/livesearch.min.js" type="text/javascript"></script>
<script src="<?php echo $global_path ?>js/script.min.js" type="text/javascript"></script>


<!-- begin livechat code -->
<script type='text/javascript'>

    $(function() {
        var fc_CSS = document.createElement('link');fc_CSS.setAttribute('rel', 'stylesheet');
        var isSecured = (window.location && window.location.protocol == 'https:');
        var rtlSuffix = ((document.getElementsByTagName('html')[0].getAttribute('lang')) === 'ar') ? '-rtl' : '';
        fc_CSS.setAttribute('type', 'text/css');
        fc_CSS.setAttribute('href', ((isSecured) ? 'https://d36mpcpuzc4ztk.cloudfront.net' : 'http://assets1.chat.freshdesk.com') + '/css/visitor' + rtlSuffix + '.css');
        document.getElementsByTagName('head')[0].appendChild(fc_CSS);
        var fc_JS = document.createElement('script');
        fc_JS.type = 'text/javascript';
        fc_JS.src = ((isSecured) ? 'https://d36mpcpuzc4ztk.cloudfront.net' : 'http://assets.chat.freshdesk.com') + '/js/visitor.js';
        (document.body ? document.body : document.getElementsByTagName('head')[0]).appendChild(fc_JS);
        window.freshchat_setting = 'eyJ3aWRnZXRfc2l0ZV91cmwiOiJveGJyaWRnZWxlYXJuaW5nLmZyZXNoZGVzay5jb20iLCJwcm9kdWN0X2lkIjpudWxsLCJuYW1lIjoiT3hicmlkZ2UgTGVhcm5pbmciLCJ3aWRnZXRfZXh0ZXJuYWxfaWQiOm51bGwsIndpZGdldF9pZCI6IjA5ZmRhMjVhLTY4NTQtNDlhNC1hNjM5LTA1NThlNzYxMmFkMCIsInNob3dfb25fcG9ydGFsIjpmYWxzZSwicG9ydGFsX2xvZ2luX3JlcXVpcmVkIjpmYWxzZSwiaWQiOjYwMDAwMjI1NDMsIm1haW5fd2lkZ2V0Ijp0cnVlLCJmY19pZCI6Ijc3YTY0ODc4Njk5ZTA3MWUzODEzODY2NGY2NzU3ZjAwIiwic2hvdyI6MSwicmVxdWlyZWQiOjIsImhlbHBkZXNrbmFtZSI6Ik94YnJpZGdlIExlYXJuaW5nIiwibmFtZV9sYWJlbCI6Ik5hbWUiLCJtYWlsX2xhYmVsIjoiRW1haWwiLCJtZXNzYWdlX2xhYmVsIjoiTWVzc2FnZSIsInBob25lX2xhYmVsIjoiUGhvbmUgTnVtYmVyIiwidGV4dGZpZWxkX2xhYmVsIjoiVGV4dGZpZWxkIiwiZHJvcGRvd25fbGFiZWwiOiJEcm9wZG93biIsIndlYnVybCI6Im94YnJpZGdlbGVhcm5pbmcuZnJlc2hkZXNrLmNvbSIsIm5vZGV1cmwiOiJjaGF0LmZyZXNoZGVzay5jb20iLCJkZWJ1ZyI6MSwibWUiOiJNZSIsImV4cGlyeSI6MTQzNTY3NDE5ODAwMCwiZW52aXJvbm1lbnQiOiJwcm9kdWN0aW9uIiwiZGVmYXVsdF93aW5kb3dfb2Zmc2V0IjozMCwiZGVmYXVsdF9tYXhpbWl6ZWRfdGl0bGUiOiJDaGF0IGluIHByb2dyZXNzIiwiZGVmYXVsdF9taW5pbWl6ZWRfdGl0bGUiOiJMZXQncyB0YWxrISIsImRlZmF1bHRfdGV4dF9wbGFjZSI6IllvdXIgTWVzc2FnZSIsImRlZmF1bHRfY29ubmVjdGluZ19tc2ciOiJXYWl0aW5nIGZvciBhbiBhZ2VudCIsImRlZmF1bHRfd2VsY29tZV9tZXNzYWdlIjoiSGkhIEhvdyBjYW4gd2UgaGVscCB5b3UgdG9kYXk/IiwiZGVmYXVsdF93YWl0X21lc3NhZ2UiOiJPbmUgb2YgdXMgd2lsbCBiZSB3aXRoIHlvdSByaWdodCBhd2F5LCBwbGVhc2Ugd2FpdC4iLCJkZWZhdWx0X2FnZW50X2pvaW5lZF9tc2ciOiJ7e2FnZW50X25hbWV9fSBoYXMgam9pbmVkIHRoZSBjaGF0IiwiZGVmYXVsdF9hZ2VudF9sZWZ0X21zZyI6Int7YWdlbnRfbmFtZX19IGhhcyBsZWZ0IHRoZSBjaGF0IiwiZGVmYXVsdF9hZ2VudF90cmFuc2Zlcl9tc2dfdG9fdmlzaXRvciI6IllvdXIgY2hhdCBoYXMgYmVlbiB0cmFuc2ZlcnJlZCB0byB7e2FnZW50X25hbWV9fSIsImRlZmF1bHRfdGhhbmtfbWVzc2FnZSI6IlRoYW5rIHlvdSBmb3IgY2hhdHRpbmcgd2l0aCB1cy4gSWYgeW91IGhhdmUgYWRkaXRpb25hbCBxdWVzdGlvbnMsIGZlZWwgZnJlZSB0byBwaW5nIHVzISIsImRlZmF1bHRfbm9uX2F2YWlsYWJpbGl0eV9tZXNzYWdlIjoiT3VyIGFnZW50cyBhcmUgdW5hdmFpbGFibGUgcmlnaHQgbm93LiBTb3JyeSBhYm91dCB0aGF0LCBidXQgcGxlYXNlIGxlYXZlIHVzIGEgbWVzc2FnZSBhbmQgd2UnbGwgZ2V0IHJpZ2h0IGJhY2suIiwiZGVmYXVsdF9wcmVjaGF0X21lc3NhZ2UiOiJXZSBjYW4ndCB3YWl0IHRvIHRhbGsgdG8geW91LiBCdXQgZmlyc3QsIHBsZWFzZSB0ZWxsIHVzIGEgYml0IGFib3V0IHlvdXJzZWxmLiIsImFnZW50X3RyYW5zZmVyZWRfbXNnIjoiWW91ciBjaGF0IGhhcyBiZWVuIHRyYW5zZmVycmVkIHRvIHt7YWdlbnRfbmFtZX19IiwiYWdlbnRfcmVvcGVuX2NoYXRfbXNnIjoie3thZ2VudF9uYW1lfX0gcmVvcGVuZWQgdGhlIGNoYXQiLCJ2aXNpdG9yX3NpZGVfaW5hY3RpdmVfbXNnIjoiVGhpcyBjaGF0IGhhcyBiZWVuIGluYWN0aXZlIGZvciB0aGUgcGFzdCAyMCBtaW51dGVzLiIsImFnZW50X2Rpc2Nvbm5lY3RfbXNnIjoie3thZ2VudF9uYW1lfX0gaGFzIGJlZW4gZGlzY29ubmVjdGVkIiwic2l0ZV9pZCI6Ijc3YTY0ODc4Njk5ZTA3MWUzODEzODY2NGY2NzU3ZjAwIiwiYWN0aXZlIjp0cnVlLCJ3aWRnZXRfcHJlZmVyZW5jZXMiOnsid2luZG93X2NvbG9yIjoiIzc3Nzc3NyIsIndpbmRvd19wb3NpdGlvbiI6IkJvdHRvbSBSaWdodCIsIndpbmRvd19vZmZzZXQiOiIzMCIsIm1pbmltaXplZF90aXRsZSI6IkxldCdzIHRhbGshIiwibWF4aW1pemVkX3RpdGxlIjoiQ2hhdCBpbiBwcm9ncmVzcyIsInRleHRfcGxhY2UiOiJZb3VyIE1lc3NhZ2UiLCJ3ZWxjb21lX21lc3NhZ2UiOiJIaSEgSG93IGNhbiB3ZSBoZWxwIHlvdSB0b2RheT8iLCJ0aGFua19tZXNzYWdlIjoiVGhhbmsgeW91IGZvciBjaGF0dGluZyB3aXRoIHVzLiBJZiB5b3UgaGF2ZSBhZGRpdGlvbmFsIHF1ZXN0aW9ucywgZmVlbCBmcmVlIHRvIHBpbmcgdXMhIiwid2FpdF9tZXNzYWdlIjoiT25lIG9mIHVzIHdpbGwgYmUgd2l0aCB5b3UgcmlnaHQgYXdheSwgcGxlYXNlIHdhaXQuIiwiYWdlbnRfam9pbmVkX21zZyI6Int7YWdlbnRfbmFtZX19IGhhcyBqb2luZWQgdGhlIGNoYXQiLCJhZ2VudF9sZWZ0X21zZyI6Int7YWdlbnRfbmFtZX19IGhhcyBsZWZ0IHRoZSBjaGF0IiwiYWdlbnRfdHJhbnNmZXJfbXNnX3RvX3Zpc2l0b3IiOiJZb3VyIGNoYXQgaGFzIGJlZW4gdHJhbnNmZXJyZWQgdG8ge3thZ2VudF9uYW1lfX0iLCJjb25uZWN0aW5nX21zZyI6IldhaXRpbmcgZm9yIGFuIGFnZW50In0sInJvdXRpbmciOm51bGwsInByZWNoYXRfZm9ybSI6dHJ1ZSwicHJlY2hhdF9tZXNzYWdlIjoiV2UgY2FuJ3Qgd2FpdCB0byB0YWxrIHRvIHlvdS4gQnV0IGZpcnN0LCBwbGVhc2UgdGVsbCB1cyBhIGJpdCBhYm91dCB5b3Vyc2VsZi4iLCJwcmVjaGF0X2ZpZWxkcyI6eyJuYW1lIjp7InRpdGxlIjoiTmFtZSIsInNob3ciOiIyIn0sImVtYWlsIjp7InRpdGxlIjoiRW1haWwiLCJzaG93IjoiMiJ9LCJwaG9uZSI6eyJ0aXRsZSI6IlBob25lIE51bWJlciIsInNob3ciOiIwIn0sInRleHRmaWVsZCI6eyJ0aXRsZSI6IlRleHRmaWVsZCIsInNob3ciOiIwIn0sImRyb3Bkb3duIjp7InRpdGxlIjoiRHJvcGRvd24iLCJzaG93IjoiMCIsIm9wdGlvbnMiOlsibGlzdDEiLCJsaXN0MiIsImxpc3QzIl19fSwiYnVzaW5lc3NfY2FsZW5kYXIiOm51bGwsIm5vbl9hdmFpbGFiaWxpdHlfbWVzc2FnZSI6eyJ0ZXh0IjoiT3VyIGFnZW50cyBhcmUgdW5hdmFpbGFibGUgcmlnaHQgbm93LiBTb3JyeSBhYm91dCB0aGF0LCBidXQgcGxlYXNlIGxlYXZlIHVzIGEgbWVzc2FnZSBhbmQgd2UnbGwgZ2V0IHJpZ2h0IGJhY2suIiwidGlja2V0X2xpbmtfb3B0aW9uIjoiMCIsImN1c3RvbV9saW5rX3VybCI6IiJ9LCJwcm9hY3RpdmVfY2hhdCI6ZmFsc2UsInByb2FjdGl2ZV90aW1lIjoxNSwic2l0ZV91cmwiOiJveGJyaWRnZWxlYXJuaW5nLmZyZXNoZGVzay5jb20iLCJleHRlcm5hbF9pZCI6bnVsbCwiZGVsZXRlZCI6ZmFsc2UsIm9mZmxpbmVfY2hhdCI6eyJzaG93IjoiMCIsImZvcm0iOnsibmFtZSI6Ik5hbWUiLCJlbWFpbCI6IkVtYWlsIiwibWVzc2FnZSI6Ik1lc3NhZ2UifSwibWVzc2FnZXMiOnsidGl0bGUiOiJMZWF2ZSB1cyBhIG1lc3NhZ2UhIiwidGhhbmsiOiJUaGFuayB5b3UgZm9yIHdyaXRpbmcgdG8gdXMuIFdlIHdpbGwgZ2V0IGJhY2sgdG8geW91IHNob3J0bHkuIiwidGhhbmtfaGVhZGVyIjoiVGhhbmsgeW91ISJ9fSwibW9iaWxlIjp0cnVlLCJjcmVhdGVkX2F0IjoiMjAxNS0wNS0zMFQxNDozMjowNS4wMDBaIiwidXBkYXRlZF9hdCI6IjIwMTUtMDUtMzBUMTQ6MzI6MTEuMDAwWiJ9';
    });

</script>
<!-- end livechat code -->



</body></html>