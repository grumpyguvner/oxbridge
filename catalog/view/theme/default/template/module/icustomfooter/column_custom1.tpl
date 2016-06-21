<?php if ($idata[$langcode]['Widgets']['Custom1']['Show'] == 'true'): ?>
<li class="iCustom iWidget grid_footer_3">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['Custom1']['Title']?></h2>
        <div class="belowTitleContainer">
			<div class="text"><?php echo html_entity_decode($idata[$langcode]['Widgets']['Custom1']['Text'])?></div>
        </div>
	</div>
</li>
<?php endif; ?>