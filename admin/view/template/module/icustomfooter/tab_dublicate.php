 <table class="table">
	<tr>
    	<td class="col-xs-2">
    			<label for="sel2"><?php echo $duplicate_settings_label; ?>
					<span class="help"><?php echo $duplicate_settings_help; ?></span>
				</label> 
		</td>	
		<td>
		  	<div class="col-sm-4">
				  <select class="form-control" id="sel1">
				    <?php foreach ($stores  as $st) { ?>
			    				<?php if($st['store_id'] != $store['store_id']) { ?>
				                 <option value="<?php echo $st['store_id'];?>" ><?php echo $st['name']; ?></option>
				                 <?php } ?>
		            <?php } ?> 
				  </select>
			</div>
			<div class="col-sm-4">
		        <button type="button" id="duplicateButton" class="btn btn-primary"><?php echo $duplicate_button; ?></button>
	        </div>
		</td>
    </tr>
</table>


<script type="text/javascript">
$( "#duplicateButton" ).click(function() {
  if (confirm('This will delete your old setting and replace them with the new ones. Are you sure?')) {
   	window.location.href = 'index.php?route=module/icustomfooter/duplicateSettings&to=<?php echo $store["store_id"]; ?>&from='+ $('#sel1').val() +'&token=<?php echo $token; ?>';
	} 
});
</script>