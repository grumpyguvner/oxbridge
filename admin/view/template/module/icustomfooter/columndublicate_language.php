 <table class="table">
	<tr>
    	<td class="col-xs-2">
				<label for="sel2"><?php echo $duplicate_column_label; ?>
					<span class="help"><?php echo $duplicate_column_help; ?></span>
				</label> 	
	  	</td>
	  	<td>
		  	<div class="col-xs-10">
			  <select class="form-control item-inline" id="duplicateLang<?php echo $index_1; ?>" style="max-width: 415px;">
			    <?php foreach ($languages  as $lang) { ?>
                   <option value="<?php echo $lang['code']; ?>" ><?php echo $lang['name']; ?></option>
	            <?php } ?> 
			  </select>
	          <button type="button" id="duplicateLangButton<?php echo $index_1; ?>" class="btn btn-primary item-inline item-top"><?php echo $duplicate_button; ?></button>
			</div>
		</td>
    </tr>
</table>



<script type="text/javascript">
$( "#duplicateLangButton<?php echo $index_1; ?>" ).click(function() {
  if (confirm('This will delete your old column settings! Are you sure?')) {
  			var fromLangCode = $('ul.columnSettings .active').data('langcode');
  			var toLangCode = $('#duplicateLang<?php echo $index_1; ?>').val();
   			window.location.href = 'index.php?route=module/icustomfooter/duplicateLangSettings&store_id=<?php echo $store["store_id"]; ?>&from=' + encodeURIComponent(fromLangCode) + '&to='+ encodeURIComponent(toLangCode) +'&token=<?php echo $token; ?>';
	} 
});
</script>