<?php if ($idata[$langcode]['Widgets']['ContactForm']['Show'] == 'true'): ?>
<li class="iContactForm iWidget grid_footer_3" id="messageSent">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['ContactForm']['Title']?></h2>
        <div class="belowTitleContainer">
            <div class="iContactFields">
            	<?php if (empty($flash)) { ?>
                <div class="redflashmessage"></div>
                <?php } else echo $flash; ?>
                <form action="#messageSent" method="post" onsubmit="return iContactFormValidation(this)">
                    <label for="contactName"><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelName']?></label><input type="text" id="contactName"  value="<?php echo (!empty($this->request->post['iContactForm']['Name'])) ? $this->request->post['iContactForm']['Name'] : ''; ?>" name="iContactForm[Name]" />
                    <hr />
                    <label for="contactEmail"><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelEmail']?></label><input type="text" id="contactEmail"  value="<?php echo (!empty($this->request->post['iContactForm']['Email'])) ? $this->request->post['iContactForm']['Email'] : ''; ?>" name="iContactForm[Email]" />
                    <hr />
                    <label for="contactMessage"><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelMessage']?> (<span id="iCustomFooterMessageLimit"><?php echo $messageLimit; ?></span>)</label><textarea id="contactMessage" name="iContactForm[Message]"><?php echo (!empty($this->request->post['iContactForm']['Message'])) ? $this->request->post['iContactForm']['Message'] : ''; ?></textarea>

                    <?php if ($idata[$langcode]['Widgets']['ContactForm']['UseCaptcha'] == 'true'): ?>
                        <hr />
                        <div class="icustomfooter-captcha-holder"><img src="index.php?route=module/icustomfooter/captcha" alt=""></div>
                        <div class="icustomfooter-captcha-input">
                            <input type="text" id="contactCaptcha" name="iContactForm[Captcha]" placeholder="<?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelCaptcha']?>"/>
                    	</div>
                    <?php endif; ?>
                	
                    <div class="icustomfooter-contact-submit">
                    	<input type="submit" class="icustomfooter-submit-btn" value="<?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelSend']?>" />
                	</div>
                </form>
                <script type="text/javascript">
                    var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    
                    var iContactFormValidation = function(form) {
                        if ($(form).find('#contactName').val() == '') {
                            $('.redflashmessage').html('<span><b><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelName']?></b> <?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelRequired']?></span>').slideDown();
                            return false;		
                        }
                        if ($(form).find('#contactEmail').val() == '') {
                            $('.redflashmessage').html('<span><b><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelEmail']?></b> <?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelRequired']?></span>').slideDown();
                            return false;		
                        }
                        if (!emailfilter.test($(form).find('#contactEmail').val())) {
                            $('.redflashmessage').html('<span><b><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelEmail']?></b> <?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelNotValid']?></span>').slideDown();
                            return false;		
                        }
                        if ($(form).find('#contactMessage').val() == '') {
                            $('.redflashmessage').html('<span><b><?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelMessage']?></b> <?php echo $idata[$langcode]['Widgets']['ContactForm']['LabelRequired']?></span>').slideDown();
                            return false;		
                        }
                        return true;
                    }
                    
                    $('#contactMessage').change(function() {
                        $('#contactMessage').val($('#contactMessage').val().substr(0, <?php echo $messageLimit; ?>));
                        $('#iCustomFooterMessageLimit').text(<?php echo $messageLimit; ?> - $('#contactMessage').val().length);
                    }).trigger('change');
                    $('#contactMessage').keyup(function() { $(this).trigger('change'); });
                    
                    $('#contactName').change(function() {
                        $('#contactName').val($('#contactName').val().substr(0, 255));
                    });
                    
                    $('#contactEmail').change(function() {
                        $('#contactEmail').val($('#contactEmail').val().substr(0, 255));
                    });
                </script>
            </div>
        </div>
	</div>
</li>
<?php endif; ?>