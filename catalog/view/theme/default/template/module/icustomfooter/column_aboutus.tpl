<?php if ($idata[$langcode]['Widgets']['AboutUs']['Show'] == 'true'): ?>
<li class="iAboutUs iWidget grid_footer_3">
    <div class="iWidgetWrapper">
        <h2><?php echo $idata[$langcode]['Widgets']['AboutUs']['Title']?></h2>
        <div class="belowTitleContainer">
        	<div class="text"><?php echo html_entity_decode($idata[$langcode]['Widgets']['AboutUs']['Text'])?></div>
        </div>
    </div>
</li>
<?php endif; ?>