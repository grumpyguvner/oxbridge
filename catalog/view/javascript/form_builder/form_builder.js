//==============================================================================
// Form Builder Pro v220.1
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

var initialized = false;

function initializeFormBuilder() {
	// Parent-child fields
	$('.form-field :input').on('change', function(){
		var key = $(this).parents('.form-field').attr('data-key');
		$(this).parents('form').find('[data-parent^="' + key + ':"]').slideUp();
		
		if ($(this).hasClass('checkbox-field')) {
			$('input[name="' + $(this).attr('name') + '"]:checked').each(function(){
				$(this).parents('form').find('[data-parent="' + key + ':' + $(this).val() + '"]').slideDown().css('display', 'inline-block');
			});
		} else {
			$(this).parents('form').find('[data-parent="' + key + ':' + $(this).val() + '"]').slideDown().css('display', 'inline-block');
		}
	});
	
	// Date Selection fields
	$('.date-field').each(function(){
		var min = false;
		var max = false;
		
		if ($(this).attr('min')) {
			min = $(this).attr('min').split('-');
			min = new Date(min[0], min[1]-1, min[2])
		}
		if ($(this).attr('max')) {
			max = $(this).attr('max').split('-');
			max = new Date(max[0], max[1]-1, max[2])
		}
		
		$(this).pickadate({
			format: 'yyyy-mm-dd',
			min: min,
			max: max,
		});
	});
	
	// Time Selection fields
	$('.time-field').each(function(){
		var min = false;
		var max = false;
		
		if ($(this).attr('min')) {
			min = $(this).attr('min').split(':');
			min = [min[0], min[1]]
		}
		if ($(this).attr('max')) {
			max = $(this).attr('max').split(':');
			max = [max[0], max[1]]
		}
		
		$(this).pickatime({
			format: 'h:i A',
			interval: parseInt($(this).attr('data-interval')),
			min: min,
			max: max,
		});
	});
	
	// File Upload fields
	$('.file-field').each(function(){
		element = $(this);
		fileUploadProgress = element.parent().find('.file-upload-progress');
		
		element.fileupload({
			dataType: 'json',
			done: function (e, data) {
				if (data.result['error']) {
					fileUploadProgress.after('<div class="file-upload-error"><div class="remove-icon" onclick="$(this).parent().remove()"></div>' + data.result['name'] + ': <em>' + data.result['error'] + '</em></div>');
				} else {
					fileUploadProgress.after('<div class="file-upload-success"><div class="remove-icon" onclick="if (confirm(form_language[\'button_delete\'])) $(this).parent().remove()"></div>' + data.result['name'] + '<input type="hidden" name="' + element.attr('id') + '[]" value="' + data.result['file'] + '" /></div>');
				}
			},
			progressall: function (e, data) {
				var progress = Math.round(data.loaded / data.total * 10000) / 100;
				fileUploadProgress.html(progress == 100 ? '' : progress + '%');
			}
		});
	});
	
	// finished
	initialized = true;
}
$(document).ready(function(){
	if (!initialized) {
		initializeFormBuilder();
	}
});

// Validation functions
function validateMin(element, min) {
	if (element.val().length && element.val().length < min) {
		alert(form_language['error_minlength'].replace('[min]', min));
		element.focus();
	}
}

function validateMaxAllowed(element, event, max, allowed) {
	if ($.inArray(event.which, [0, 8, 13]) != -1) return;
	if (max && (element.val().length + 1) > max && element[0].selectionStart == element[0].selectionEnd) {
		event.preventDefault();
	}
	if (allowed && allowed.indexOf(String.fromCharCode(event.which)) == -1) {
		event.preventDefault();
	}
}

function validatePaste(element, max, allowed) {
	setTimeout(function(){
		if (allowed) {
			var regex = new RegExp('[^' + allowed.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&') + ']', 'g');
			element.val(element.val().replace(regex, ''));
		}
		if (max && element.val().length > max) {
			element.val(element.val().substr(0, max));
		}
	}, 0);
}

function validateForm(module_id) {
	var errors = [];
	$('#form' + module_id + ' .required-background').removeClass('required-background');
	
	$('#form' + module_id + ' .required-field').each(function(){
		var element = $(this);
		element.find(':input').not('input[type="file"], button').each(function(){
			if (!$(this).val()) element.addClass('required-background');
		});
		element.find(':checkbox, :radio').each(function(){
			if ($(this).val()) element.removeClass('required-background');
		});
	});
	if ($('#form' + module_id + ' .required-background').length) {
		errors.push(form_language['error_required']);
	}
	
	var regex = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/i;
	$('#form' + module_id + ' .email-field').each(function(){
		if ($(this).val() || $(this).parent().find('.confirm-field').val()) {
			if (!regex.test($(this).val())) {
				$(this).parent().addClass('required-background');
				errors.push(form_language['error_invalid_email']);
			}
			if ($(this).parent().find('.confirm-field').length && $(this).val() != $(this).parent().find('.confirm-field').val()) {
				$(this).parent().addClass('required-background');
				errors.push(form_language['error_email_mismatch']);
			}
		}
	});
	
	return errors;
}

// Submission function
function submitForm(element, module_id, please_wait, success, redirect) {
	var buttonText = element.html();
	element.attr('disabled', 'disabled').html(please_wait);
	
	var errors = validateForm(module_id);
	if (errors.length) {
                $('#form' + module_id+' .box-content').prepend("<div class='message error'>"+errors.join('\n')+"</div>");
                setTimeout(function() {
                    $('#form' + module_id+' .box-content .message').remove();
                }, 5000);
//		alert('• ' + errors.join('\n• '));
		element.removeAttr('disabled').html(buttonText);
	} else {
		$.ajax({
			type: 'POST',
                        //changed url: line below as wasn't working when capthca not present
                        //url: 'index.php?route=module/form_builder/submit&module_id=' + module_id + '&captcha=' + (typeof grecaptcha === 'undefined' ? '' : grecaptcha.getResponse()),
			url: 'index.php?route=module/form_builder/submit&module_id=' + module_id,
			data: $('#form' + module_id).find(':input:not(:checkbox), :checkbox:checked').serialize(),
			success: function(data) {
				element.removeAttr('disabled').html(buttonText);
				if (data.trim() == 'success') {
					if (success) {
                                            $('#form' + module_id+' .box-content').prepend("<div class='message success'>"+success+"</div>");
                                            setTimeout(function() {
                                                $('#form' + module_id+' .box-content .message').remove();
                                            }, 5000);
//                                            alert(success);
					}
                                        $('.tab-slide-out').tabSlideOut('close');
                                        var gaCategory = $('#form' + module_id).find('[name="gaCategory"]');
                                        var gaEvent = $('#form' + module_id).find('[name="gaEvent"]');
                                        if( gaCategory.length && gaEvent.length ){
                                            ga('send', 'event', { eventCategory: gaCategory.val(), eventAction: gaEvent.val()});
                                        }
					if (redirect) {
						location = redirect;
					}
				} else {
                                        $('#form' + module_id+' .box-content').prepend("<div class='message error'>"+data+"</div>");
                                        setTimeout(function() {
                                            $('#form' + module_id+' .box-content .message').remove();
                                        }, 5000);
//					alert(data);
				}
			}
		});
	}
}
