<div class="tabbable tabs-left" id="abcart_tabs">
    <ul class="nav nav-tabs mail-list">
        <li class="static"><a class="addNewMailTemplate"><i class="fa fa-plus"></i> Add New Template</a></li>
        <?php if (isset($moduleData['MailTemplate'])) { ?>
            <?php foreach ($moduleData['MailTemplate'] as $mailtemplate) { ?>
            <li><a href="#mailtemplate_<?php echo $mailtemplate['id']; ?>" data-toggle="tab" data-mailtemplate-id="<?php echo $mailtemplate['id']; ?>"><i class="fa fa-pencil-square-o"></i> <?php echo (isset($mailtemplate['Name']) && !empty($mailtemplate['Name'])) ? $mailtemplate['Name'] : 'Template '.$mailtemplate['id']; ?><i class="fa fa-minus-circle removeMailTemplate"></i>
                <input type="hidden" name="<?php echo $moduleName; ?>[MailTemplate][<?php echo $mailtemplate['id']; ?>][id]" value="<?php echo $mailtemplate['id']; ?>" />
                </a> </li>
            <?php } ?>
        <?php } ?>
    </ul>
    <div class="tab-content mail-settings">
        <?php if (isset($moduleData['MailTemplate'])) { ?>
            <?php foreach ($moduleData['MailTemplate'] as $mailtemplate) { 
                require(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_mailtab.php');
            } ?>
        <?php } ?>
    </div>
</div>
<script type="text/javascript" >
// Add Template
function addNewMailTemplate() {
	count = $('.mail-list li:last-child > a').data('mailtemplate-id') + 1 || 1;
	var ajax_data = {};
	ajax_data.token = '<?php echo $token; ?>';
	ajax_data.store_id = '<?php echo $store['store_id']; ?>';
	ajax_data.mailtemplate_id = count;

	$.ajax({
		url: 'index.php?route=module/<?php echo $moduleNameSmall; ?>/get_mailtemplate_settings',
		data: ajax_data,
		dataType: 'html',
		beforeSend: function() {
			NProgress.start();
		},
		success: function(settings_html) {
			$('.mail-settings').append(settings_html);
			
			if (count == 1) { $('a[href="#mailtemplate_'+ count +'"]').tab('show'); }
			tpl 	= '<li>';
			tpl 	+= '<a href="#mailtemplate_'+ count +'" data-toggle="tab" data-mailtemplate-id="'+ count +'">';
			tpl 	+= '<i class="fa fa-pencil-square-o"></i> Template '+ count;
			tpl 	+= '<i class="fa fa-minus-circle removeMailTemplate"></i>';
			tpl 	+= '<input type="hidden" name="<?php echo $moduleName; ?>[MailTemplate]['+ count +'][id]" value="'+ count +'"/>';
			tpl 	+= '</a>';
			tpl	+= '</li>';
			
			$('.mail-list').append(tpl);
			$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');
			
			NProgress.done();
			$('.mail-list').children().last().children('a').trigger('click');
			window.localStorage['currentSubTab'] = $('.mail-list').children().last().children('a').attr('href');
		}
	});
}

// Remove Template
function removeMailTemplate() {
	tab_link = $(event.target).parent();
	tab_pane_id = tab_link.attr('href');
	
	var confirmRemove = confirm('Are you sure you want to remove ' + tab_link.text().trim() + '?');
	
	if (confirmRemove == true) {
		tab_link.parent().remove();
		$(tab_pane_id).remove();
		
		if ($('.mail-list').children().length > 1) {
			$('.mail-list > li:nth-child(2) a').tab('show');
			window.localStorage['currentSubTab'] = $('.mail-list > li:nth-child(2) a').attr('href');
		}
	}
}

// Events for the Add and Remove buttons
$(document).ready(function() {
	// Add New Label
	$('.addNewMailTemplate').click(function(e) { addNewMailTemplate(); });
	// Remove Label
	$('.mail-list').delegate('.removeMailTemplate', 'click', function(e) { removeMailTemplate(); });
});

// Show the EDITOR
<?php 
if (isset($moduleData['MailTemplate'])) { 
	foreach ($moduleData['MailTemplate'] as $mailtemplate) {
		foreach ($languages as $language) { ?>
			$('#message_<?php echo $mailtemplate['id']; ?>_<?php echo $language['language_id']; ?>').summernote({
				height: 350
			});
<?php	}
	}
} ?>

// Selectors for discount
function selectorsForDiscount() {
	$('.discountTypeSelect').each(function() {
		//debugger;
		if ($(this).val() == 'P'){
			$(this).parents('.templates').find('#percentageAddon').show();
		} else {
			$(this).parents('.templates').find('#currencyAddon').show();
		}
		//
		$(this).parents('.templates').find('.discountMailSelect').each(function() {
			if ($(this).val() == 'yes'){
				$(this).parents('.templates').find('.discountMailSettings').show();
			} else {
				$(this).parents('.templates').find('.discountMailSettings').hide();
			}
		});
		//
		if ($(this).val() == 'N'){
			$(this).parents('.templates').find('.discountSettings').hide();
			$(this).parents('.templates').find('.discountMailSettings').hide();
		} else {
			$(this).parents('.templates').find('.discountSettings').show();
		}
	});

	$('.discountMailSelect').on('change', function(e){ 
		if($(this).val() == 'yes') {
			$(this).parents('.templates').find('.discountMailSettings').show(300);
		} else {
			$(this).parents('.templates').find('.discountMailSettings').hide(300);
		}	
	});
	
	$('.discountTypeSelect').on('change', function(e){ 
		if($(this).val() == 'P') {
			$(this).parents('.templates').find('#percentageAddon').show();
			$(this).parents('.templates').find('#currencyAddon').hide();
		} else {
			$(this).parents('.templates').find('#currencyAddon').show();
			$(this).parents('.templates').find('#percentageAddon').hide();
		}
		//
		$(this).parents('.templates').find('.discountMailSelect').each(function() {
			if ($(this).val() == 'yes'){
				$(this).parents('.templates').find('.discountMailSettings').show();
			} else {
				$(this).parents('.templates').find('.discountMailSettings').hide();
			}
		});
		//	
		if($(this).val() == 'N') {
			$(this).parents('.templates').find('.discountSettings').hide(300);
			$(this).parents('.templates').find('.discountMailSettings').hide();
		} else {
			$(this).parents('.templates').find('.discountSettings').show(300);
		}
	});
}

// Initialize selector for discount
$(function() {
	selectorsForDiscount();
});
</script>