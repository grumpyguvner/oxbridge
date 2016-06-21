<?php if (!empty($idata)) { ?>

    <div class="clearfix"></div>
    
    <?php require_once($footerPath . 'customstyles.php'); ?>

	<div id="icustomfooter-custom" class="icustomfooter-wrapper <?php echo $idata['Settings']['BackgroundPattern']; ?>">
        <div id="iCustomFooter" class="iCustomFooter <?php echo $idata['Settings']['FontFamily']; ?> <?php echo $idata['Settings']['ColumnContentOverflow']; ?> <?php echo $idata[$langcode]['Widgets']['Contacts']['IconSet']; ?>">
            <ul class="iWidgets">
            <?php if ($columns) { ?>
                <?php foreach ($columns as $column) { ?>
                    <?php echo $column; ?>
                <?php } ?>
            <?php } ?>
            <li class="clearfix"></li>
            </ul>
        </div>
    </div>
	
    <style type="text/css" rel="stylesheet">
		<?php echo $idata['Settings']['CustomCSS']; ?>
	</style>
    
    <script type="text/javascript">
		var responsiveDesign = '<?php echo $idata['Settings']['ResponsiveDesign']; ?>';
		var customFooterWidth = <?php echo preg_replace('/\D/', '',$idata['Settings']['FooterWidth']); ?>;
		var columnWidth = <?php echo preg_replace('/\D/', '',$idata['Settings']['ColumnWidth']); ?>;
		/** Responsive Design logic */
		var inSmallWidthMode = false;
		var respondOnWidthChange = function() {
			var currentWidth = $(window).width();
			if (currentWidth < customFooterWidth + 5) {
				$('#iCustomFooter').width(currentWidth - 5);
				$('#icustomfooter_default_footer').width(currentWidth - 5);
				respondOnSmallWidth(currentWidth);
			} else {
				$('#iCustomFooter').width(customFooterWidth);
				$('#icustomfooter_default_footer').width(customFooterWidth);
				$('.iWidgets > li').css('width',columnWidth+'px');
				$('#icustomfooter_default_footer .grid_footer_3').css('width',columnWidth+'px');
			}
			
		}
		
		$('.iWidget h2').click(function() {
			if (inSmallWidthMode == true) {
				if ($(this).parent().find('.belowTitleContainer').css('display') == 'none') {
					$('.iWidget .belowTitleContainer').slideUp();
					$(this).parent().find('.belowTitleContainer').slideDown();
				}
			}
		});
		
		var respondOnSmallWidth = function(currentWidth) {
			if (currentWidth < (columnWidth*2+60)) {
				inSmallWidthMode = true;
				$('.iWidgets .belowTitleContainer').slideUp();
				$('.iWidgets > li').css('width','100%');
				$('#icustomfooter_default_footer .grid_footer_3').css('width','100%');
			} else {
				inSmallWidthMode = false;
				$('.iWidgets .belowTitleContainer').slideDown();
				$('.iWidgets > li').css('width','50%');
				$('#icustomfooter_default_footer .grid_footer_3').css('width','50%');
			}
		}
		
		$(document).ready(function() {
			if (responsiveDesign == 'yes') {
				$(window).resize(function() {
					respondOnWidthChange();
				});
				respondOnWidthChange();
			}
		});
		/** END */
	</script>
<?php } ?>