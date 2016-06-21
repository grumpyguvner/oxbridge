<?php if ($idata[$langcode]['Widgets']['YouTube']['Show'] == 'true'): ?>
<li class="iYouTube iWidget grid_footer_3">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['YouTube']['Title']; ?></h2>
        <div class="belowTitleContainer">
		<?php $videoHeight = (!empty($idata[$langcode]['Widgets']['YouTube']['Height'])) ? (int)$idata[$langcode]['Widgets']['YouTube']['Height'] : 200; ?>
		<?php $videoWidth = (!empty($idata[$langcode]['Widgets']['YouTube']['Width'])) ? (int)$idata[$langcode]['Widgets']['YouTube']['Width'] : 210; ?>
        <object width="<?php echo $videoWidth; ?>" height="<?php echo $videoHeight; ?>">
          <param name="movie" value="https://www.youtube.com/v/<?php echo $idata[$langcode]['Widgets']['YouTube']['URL']; ?>?version=3&autoplay=0"></param>
          <param name="allowScriptAccess" value="always"></param>
          <embed src="https://www.youtube.com/v/<?php echo $idata[$langcode]['Widgets']['YouTube']['URL']; ?>?version=3&autoplay=0"
                 type="application/x-shockwave-flash"
                 allowscriptaccess="always"
                 width="<?php echo $videoWidth; ?>" height="<?php echo $videoHeight; ?>"></embed>
        </object>
        </div>
	</div>
</li>
<?php endif; ?>