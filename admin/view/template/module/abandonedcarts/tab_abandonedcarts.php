<div id="abandonedCartsWrapper<?php echo $store['store_id']; ?>"> </div>
<!-- SendReminderModal -->
<div class="modal fade" id="sendReminderModal" tabindex="-3" role="dialog" aria-labelledby="sendReminderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 90% !important;margin: 20px auto;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="sendReminderModalLabel">Send reminder</h4>
      </div>
      <div class="modal-body" style="overflow:auto;" id="sendReminderModalBody">
      </div>
      <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
		<button class="btn btn-primary" data-loading-text="Sending..." id="sendMail"><i class="fa fa-envelope-square"></i> Send mail!</button>
      </div>
    </div>
  </div>
</div>
<script>
	$(window).load(function(){
		$('#sendReminderModalBody').css('height', $(window).height() * 0.72 + 'px');
    });
	$(window).resize(function() {
		$('#sendReminderModalBody').css('height', $(window).height() * 0.72 + 'px')
	})
	
	$('#sendMail').on('click', function(e){
		e.preventDefault();
		var language = $('input[name="AB_language_id"]').val();
		var template = $('input[name="AB_template_id"]').val();
		
		var content = $('#SendReminderCustomForm textarea[name="abandonedcarts[MailTemplate][' + template + '][Message][' + language + ']"]').html($('#SendReminderCustomForm  #message_' + template + '_' + language).code());

	    var email_validate = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var email = $('#customer_email').val().trim();
		if (!email.match(email_validate)) {
			alert("The email entered by the customer is invalid.")
		} else {
			var btn = $(this);
			btn.button('loading');
			$.ajax({
				url: 'index.php?route=module/abandonedcarts/sendcustomemail&token=<?php echo $token; ?>',
				type: 'post',
				data: $('#SendReminderCustomForm').serialize(),
				success: function(response) {
					 $('#sendReminderModal').modal('hide');
					 $('#messageResult').show();
					 $('#messageResult').delay(3000).fadeOut(600, function(){
						  $(this).hide(); 
					 }).slideUp(600);
				}
			}).always(function () {
			  btn.button('reset');
			});
		}
	});

    $(document).ready(function(){
         $.ajax({
            url: "index.php?route=module/abandonedcarts/getabandonedcarts&token=<?php echo $token; ?>&page=1&store_id=<?php echo $store['store_id']; ?>",
            type: 'get',
            dataType: 'html',
            success: function(data) {		
                $("#abandonedCartsWrapper<?php echo $store['store_id']; ?>").html(data);
            }
    
         });
    });

	function sendReminder(cartID, templateID) {
		$('#sendReminderModalBody').html("");      
		$('#sendReminderModalBody').load('index.php?route=module/abandonedcarts/sendReminder&token=<?php echo $token; ?>&id=' + cartID + '&template_id=' + templateID + '&store_id=<?php echo $store['store_id']; ?>');
		$('#sendReminderModal').modal();
	}
	function removeItem(cartID) {      
		var r=confirm("Are you sure you want to remove this entry?");
		if (r==true) {
			$.ajax({
				url: 'index.php?route=module/abandonedcarts/removeabandonedcart&token=<?php echo $token; ?>',
				type: 'post',
				data: {'cart_id': cartID},
				success: function(response) {
				location.reload();
			}
		});
	 }
	}
</script>