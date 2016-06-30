<?php if ($idata[$langcode]['Widgets']['Facebook']['Show'] == 'true'): ?>
<li class="iFacebook iWidget grid_footer_3">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['Facebook']['Title']?></h2>
        <div class="belowTitleContainer">
            <div class="fb-page" data-href="<?php echo $idata[$langcode]['Widgets']['Facebook']['URL']; ?>" data-height="<?php echo $idata[$langcode]['Widgets']['Facebook']['Height']; ?>" data-small-header="<?php echo $idata[$langcode]['Widgets']['Facebook']['UseSmallHeader']; ?>" data-adapt-container-width="true" data-hide-cover="<?php echo $idata[$langcode]['Widgets']['Facebook']['HideCoverPhoto']; ?>" data-show-facepile="<?php echo $idata[$langcode]['Widgets']['Facebook']['ShowFriendsFaces']; ?>" data-show-posts="<?php echo $idata[$langcode]['Widgets']['Facebook']['ShowPagePosts']; ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $idata[$langcode]['Widgets']['Facebook']['URL']; ?>"><a href="<?php echo $idata[$langcode]['Widgets']['Facebook']['URL']; ?>"><?php echo $idata[$langcode]['Widgets']['Facebook']['PageTitle']; ?></a></blockquote></div></div>
        </div>
	</div>
</li>
<?php endif; ?>