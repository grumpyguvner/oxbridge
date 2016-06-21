<table class="table" style="margin-bottom: 0px;">
  <tr>
    <td class="col-xs-3">
    	<h5><span class="required">*</span> <strong>AbandonedCarts status:</strong></h5>
		<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable or disable the module Abandoned Carts.</span></td>
    <td class="col-xs-9">
    	<div class="col-md-4">
            <select name="<?php echo $moduleName; ?>[Enabled]" class="form-control">
              <option value="yes" <?php echo (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
              <option value="no"  <?php echo (empty($moduleData['Enabled']) || $moduleData['Enabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
   </td>
  </tr>
  <tr>
    <td class="col-xs-3">
    	<h5><strong>Date Format:</strong></h5>
		<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Select date format for the end date of coupon validity.</span></td>
    <td class="col-xs-9">
    	<div class="col-md-4">
            <select name="<?php echo $moduleName; ?>[DateFormat]" class="form-control">
              <option value="d-m-Y" <?php echo (isset($moduleData['DateFormat']) && $moduleData['DateFormat'] == 'd-m-Y') ? 'selected=selected' : '' ?>>dd-mm-yyyy</option>
              <option value="m-d-Y" <?php echo (isset($moduleData['DateFormat']) && $moduleData['DateFormat']== 'm-d-Y') ? 'selected=selected' : '' ?>>mm-dd-yyyy</option>
              <option value="Y-m-d" <?php echo (isset($moduleData['DateFormat']) && $moduleData['DateFormat']== 'Y-m-d') ? 'selected=selected' : '' ?>>yyyy-mm-dd</option>
              <option value="Y-d-m" <?php echo (isset($moduleData['DateFormat']) && $moduleData['DateFormat']== 'Y-d-m') ? 'selected=selected' : '' ?>>yyyy-dd-mm</option>
            </select>
        </div>
   </td>
  </tr>
  <tr>
    <td class="col-xs-3">
    	<h5><strong>Apply Taxes:</strong></h5>
		<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Apply taxes (if any) for the products in the emails.</span></td>
    <td class="col-xs-9">
    	<div class="col-md-4">
            <select name="<?php echo $moduleName; ?>[Taxes]" class="form-control">
              <option value="yes" <?php echo (isset($moduleData['Taxes']) && $moduleData['Taxes'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
              <option value="no" <?php echo (empty($moduleData['Taxes']) || $moduleData['Taxes']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
   </td>
  </tr>
  <tr>
 	<td class="col-xs-3">
    	<h5><strong>Remove expired coupons:</strong></h5>
		<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Remove all expired coupons created from the module.</span></td>
    <td class="col-xs-9">
    	<div class="col-md-4">
             <a class="btn btn-default btn-mini btn-remove-expired" onClick="removeExpiredCoupons();"><i class="fa fa-info-circle"></i>&nbsp;Clean up the coupons!</a>
        </div>
   </td>
  </tr>
  <tr>
    <td class="col-xs-3">
    	<h5><strong>Send BCC to store owner:</strong></h5>
		<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enabling this option will add <?php echo $e_mail; ?> as BCC recepient.</span></td>
    <td class="col-xs-9">
    	<div class="col-md-4">
            <select name="<?php echo $moduleName; ?>[BCC]" class="form-control">
              <option value="yes" <?php echo (isset($moduleData['BCC']) && $moduleData['BCC'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
              <option value="no" <?php echo (empty($moduleData['BCC']) || $moduleData['BCC']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
   </td>
  </tr>  
	<tr>
      <td class="col-xs-3">
		<h5><strong>Scheduled tasks:</strong></h5>
		<span class="help"><i class="fa fa-info-circle"></i>&nbsp;When activated, this function will send automatically emails to the customers who abandoned their carts.</span>
      </td>
      <td class="col-xs-9">
      	<div class="col-xs-4">
            <select id="ScheduleToggle" name="<?php echo $moduleName; ?>[ScheduleEnabled]" class="form-control">
              <option value="yes" <?php echo (!empty($moduleData['ScheduleEnabled']) && $moduleData['ScheduleEnabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
              <option value="no"  <?php echo (empty($moduleData['ScheduleEnabled']) || $moduleData['ScheduleEnabled']== 'no') ? 'selected=selected' : '' ?>>Disabled</option>
            </select>
        </div>
       </td>
    </tr>
</table>
<table class="table cronForm" id="mainSettings" style="border-top: 1px solid #ddd;
<? echo (!empty($moduleData['ScheduleEnabled']) && $moduleData['ScheduleEnabled'] == 'yes') ? '' : 'display:none;'; ?>;">
  <tr>
    <td class="col-xs-3">
    	<h5><span class="required">*</span> <strong>Type:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose the type of the schedule.</span>
    </td>
    <td class="col-xs-9">
    	<div class="col-md-4">
          <select name="<?php echo $moduleName; ?>[ScheduleType]" class="form-control">
            <option value="F" <?php if(!empty($moduleData['ScheduleType']) && $moduleData['ScheduleType'] == 'F') echo "selected" ?>>Fixed dates</option>
            <option value="P" <?php if(!empty($moduleData['ScheduleType']) && $moduleData['ScheduleType'] == 'P') echo "selected" ?>>Periodic</option>
          </select>
		</div>
	</td>
  </tr>
  <tr>
    <td class="col-xs-3">
    	<h5><span class="required">*</span> <strong>Schedule:</strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enter the desired schedule for the reminders. You will see the options for the fixed dates functionality or the periodic functionality depending on the option above.<br /><br/><strong>IMPORTANT:</strong> Keep in mind that the scheduling time is global variable for all stores in your OpenCart installation.</span>
    </td>
    <td class="col-xs-9">
	  <div class="col-md-5">
            <div id="FixedDateOptions" class="row">
                <div class="col-md-5">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                       <input type="text" id="FixedDate" class="form-control" data-date-format="DD.MM.YYYY" value="" placeholder="Date..." readonly />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <input type="text" id="FixedDateTime" class="timepicker form-control" data-date-format="HH:mm" placeholder="Time..." readonly />
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn addDate"><i class="fa fa-plus"></i> Add</button>
                </div>
            <div style="height:10px;clear:both;"></div>
            <div class="scrollbox dateList">
                <?php if(isset($moduleData['FixedDates'])) { 
                        foreach($moduleData['FixedDates'] as $date) {?>
                <div id="date<?php  $id = explode( '/', $date); $id=explode('.' , $id[0]); echo $id[0].$id[1].$id[2]; ?>"><?php echo $date ?> 
                <i class="fa fa-minus-circle removeIcon"></i>
                <input type="hidden" name="<?php echo $moduleName; ?>[FixedDates][]" value="<?php echo $date ?>" />
                </div>
                        <?php } } ?> 
             </div>
          </div>
          <div id="PeriodicOptions">
            <div id="CronSelector"></div>
            <input type="hidden" id="abCron" name="<?php echo $moduleName; ?>[PeriodicCronValue]" value="">
          </div>
      </div>
    </td>
  </tr>
  <tr>
    <td class="col-xs-2" style="vertical-align:top;padding-top:20px;">
      <a id="TestCronAvailablity" class="btn btn-warning cronBtn"><i class="fa fa-certificate"></i> Test Cron</a>
      <br /><br /><span class="help"><i class="fa fa-info-circle"></i>&nbsp;Click here to check if your server supports Cron commands.</span>
	</td>
	<td class="col-xs-10">
	  <div class="well" style="margin-left: 15px;">
      	<i class="fa fa-question-circle"></i>&nbsp;If you want to use the scheduling features, your server has to support <strong>CRON</strong> functions.<br /><br />The <strong>CRON</strong> daemon is a long running process that executes commands at specific dates and times. By clicking on the button <strong>Test Cron</strong> you can check if your server supports <strong>CRON</strong> commands. If your server <strong>does</strong> support Cron jobs, but this script shows that the feature is disabled, this means that the automatic creation of Cron commands is disabled. In that case, you can use this URL string: <br />
      	<br />
        <strong><?php echo $cronPhpPath; ?></strong>
        <br /><br />
		The script above will be executed <strong>every day at 00:00</strong>. You can change it depending on your preferences.
        <br /><br />
        	<i class="fa fa-question-circle"></i>&nbsp;If your server does not support <strong>CRON</strong> jobs, click on the button below.
        <br /><br />
        <a id="MyHostDoesNotHaveCron" class="btn btn-info btn-mini genericCronBtn" data-toggle="modal" data-target="#genericCronModal"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;My server does not support cron jobs</a>
      </div>  
    </td>
  </tr>
</table>
<!-- CronModal -->
<div class="modal fade" id="cronModal" tabindex="-1" role="dialog" aria-labelledby="cronModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="cronModalLabel">Schedule options & cron jobs</h4>
      </div>
      <div class="modal-body" id="cronModalBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- GenericCronModal -->
<div class="modal fade" id="genericCronModal" tabindex="-2" role="dialog" aria-labelledby="genericCronModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="genericCronModalLabel">Alternative cron solutions</h4>
      </div>
      <div class="modal-body">
        <p>If your server does not support cron jobs, you can try using services such as <strong>easycron.com</strong>, <strong>setcronjob.com</strong> or others which can provide you this feature.<br /><br />
        In order to do that, you have to register in the selected service and use this URL for execution:
        <ul>
            <li>- <a href="<?php echo HTTP_CATALOG; ?>index.php?route=module/<?php echo $moduleName; ?>/sendReminder"><?php echo HTTP_CATALOG; ?>index.php?route=module/<?php echo $moduleName; ?>/sendReminder</a></li>
        </ul>
        You should also enable the <strong>Scheduled tasks</strong> feature in AbandonedCarts settings and set the <strong>Delay</strong> option.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
// Cron
$('.cronBtn').on('click', function(e){
	var modal = $('#cronModal'), modalBody = $('#cronModal .modal-body');
    modal
        .on('show.bs.modal', function () {
            modalBody.load('index.php?route=module/<?php echo $moduleName; ?>/testcron&token=<?php echo $token; ?>')
        })
        .modal();
    e.preventDefault();
});

// Date & Time picker
$(document).ready(function() {	
	$('#FixedDate').datetimepicker({ pickTime: false });
	$('.timepicker').datetimepicker({ pickDate: false });
	$('#CronSelector').cron({
		  initial: "<?php if(!empty($moduleData['PeriodicCronValue'])) echo $moduleData['PeriodicCronValue']; else echo "* * * * *";  ?>",
    onChange: function() {
        $('#abCron').val($(this).cron("value"));		 
    }
	});
});
	if($('select[name="<?php echo $moduleName; ?>[ScheduleType]"]').val() == 'P') {
		$('#FixedDateOptions').hide();
	 	$('#PeriodicOptions').show(200);
	} else {
		$('#PeriodicOptions').hide();
		$('#fixedDateOptions').show(200);	
	}
$('select[name="<?php echo $moduleName; ?>[ScheduleType]"]').on('change', function(e){ 
	if($(this).val() == 'P') {
		$('#FixedDateOptions').hide();
	 	$('#PeriodicOptions').show(200);	
	} else {
		$('#PeriodicOptions').hide();
		$('#FixedDateOptions').show(200);	
		}	
});
$('.btn.addDate').on('click', function(e){
		e.preventDefault();
		if($('#FixedDate').val() && $('#FixedDateTime').val() ){
			$('.scrollbox.dateList').append('<div id="date' + $('#FixedDate').val().replace(/\./g,'') + '">' + $('#FixedDate').val() + '/' + $('#FixedDateTime').val() +'<i class="fa fa-minus-circle removeIcon"></i><input type="hidden" name="<?php echo $moduleName; ?>[FixedDates][]" value="' + $('#FixedDate').val() + '/' + $('#FixedDateTime').val() + '" /></div>');
			$('#FixedDate').val('');
			$('#FixedDateTime').val('');
		} else {
			alert('Please fill date and time!');
		}
		refreshRemoveButtonForTheCronJobs();
});
function refreshRemoveButtonForTheCronJobs() {
	$('.scrollbox.dateList div .removeIcon').click(function() {
		$(this).parent().remove();
	});
}
refreshRemoveButtonForTheCronJobs();
// Hide & Show Scheduled table
$(function() {
    var $typeSelector = $('#ScheduleToggle');
    var $toggleArea = $('#mainSettings');
	 
    $typeSelector.change(function(){
        if ($typeSelector.val() === 'yes') {
            $toggleArea.show(500) 
        }
        else {
            $toggleArea.hide(500);
        }
    });
});
function removeExpiredCoupons() {      
	var r=confirm("Are you sure that you want to remove all expired coupons?");
	if (r==true) {
		$.ajax({
			url: 'index.php?route=module/abandonedcarts/removeallexpiredcoupons&token=<?php echo $token; ?>',
			type: 'post',
			data: {'remove': r },
			success: function(response) {
				alert('The expired coupons were removed!');
				location.reload();
			}
		});
 	}
}
</script>