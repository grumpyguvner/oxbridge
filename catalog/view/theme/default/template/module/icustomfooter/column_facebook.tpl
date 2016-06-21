<?php if ($idata[$langcode]['Widgets']['Facebook']['Show'] == 'true'): ?>
<li class="iFacebook iWidget grid_footer_3">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['Facebook']['Title']?></h2>
        <div class="belowTitleContainer">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo htmlentities($idata[$langcode]['Widgets']['Facebook']['URL'])?>&amp;width=250&amp;height=<?php echo $idata[$langcode]['Widgets']['Facebook']['Height']?>&amp;colorscheme=<?php echo(!empty($idata['Settings']['BackgroundPattern']) && $idata['Settings']['BackgroundPattern'] == 'darkbgpattern' ? 'dark' : 'light');?>&amp;show_faces=true&amp;border_color=%23ddd&amp;stream=false&amp;header=false&amp;appId=159650554163037" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:<?php echo $idata[$langcode]['Widgets']['Facebook']['Height']?>px;" allowTransparency="true"></iframe>
        </div>
	</div>
</li>
<?php endif; ?>