<?php if ($idata[$langcode]['Widgets']['Twitter']['Show'] == 'true'): ?>
<li class="iTwitter iWidget grid_footer_3">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['Twitter']['Title']; ?></h2>
		<div class="belowTitleContainer">	 
        	<?php if (!empty($idata[$langcode]['Widgets']['Twitter']['WidgetID'])) :  ?>
            <ul class="iTweets">
                <a 
                	class="twitter-timeline" 
                    href="https://twitter.com/twitterapi" 
                    data-widget-id="<?php echo $idata[$langcode]['Widgets']['Twitter']['WidgetID']; ?>" 
                    height="<?php echo ((int)$idata['Settings']['ColumnHeight'] - 60); ?>" 
                    data-chrome="nofooter noheader noscrollbar noborders" 
                    data-tweet-limit="<?php echo floor(((int)$idata['Settings']['ColumnHeight'] - 60)/135); ?>" 
					<?php if ($idata['Settings']['BackgroundPattern'] == 'darkbgpattern') { ?>
                    	data-theme="dark" 
					<?php } ?>>Tweets by @<?php echo $idata[$langcode]['Widgets']['Twitter']['Profile']; ?></a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </ul>
			<?php endif; ?>
		</div>
	</div>
</li>
<?php endif; ?>