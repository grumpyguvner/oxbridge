<style type="text/css" rel="stylesheet">
	.icustomfooter-wrapper {
		width:<?php echo $idata['Settings']['FooterWrapperWidth']?>;
	}
	#iCustomFooter, #icustomfooter_default_footer {
		width:<?php echo $idata['Settings']['FooterWidth']?>;
	}
	.iCustomFooter ul>li.grid_footer_3, #icustomfooter_default_footer .column {
		width:<?php echo $idata['Settings']['ColumnWidth']?>;
	}
	.iWidgets .iWidget .belowTitleContainer {
		height:<?php echo ($idata['Settings']['ColumnHeight']-70)?>px;
	}
	#powered {
		<?php echo $idata['Settings']['HidePoweredBy']?>
	}
	#icustomfooter-custom.usebackgroundcolor, #icustomfooter-informational.usebackgroundcolor {
		<?php echo (!empty($idata['Settings']['BackgroundColor']) && $idata['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'background-color:'.$idata['Settings']['BackgroundColor'].';' : ''; ?>
	}
	.usebackgroundcolor #iCustomFooter .iWidgets .iWidget h2 {
		<?php echo (!empty($idata['Settings']['ColumnColor']) && $idata['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'color:'.$idata['Settings']['ColumnColor'].';' : '' ?>
		<?php echo (!empty($idata['Settings']['ColumnBorderColor']) && $idata['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'border-bottom: 1px ' . $idata['Settings']['ColumnLineStyle'] . ' '.$idata['Settings']['ColumnBorderColor'].';' : '' ?>
	}
	.usebackgroundcolor #icustomfooter_default_footer h3 {
		<?php echo (!empty($idata['Settings']['ColumnColor']) && $idata['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'color:'.$idata['Settings']['ColumnColor'].';' : '' ?>
	}
	.usebackgroundcolor #iCustomFooter .iWidgets .iWidget p, .usebackgroundcolor #iCustomFooter .iWidgets .iWidget.iContactUs .iContactsListing li, .usebackgroundcolor #iCustomFooter .iWidgets .iWidget.iContactForm label {
		<?php echo (!empty($idata['Settings']['TextColor']) && $idata['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'color:'.$idata['Settings']['TextColor'] : ''.';' ?>
	}
	.usebackgroundcolor #icustomfooter_default_footer .column ul > li > a {
		<?php echo (!empty($idata['Settings']['LinkColor']) && $idata['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'color:'.$idata['Settings']['LinkColor'] : ''.';' ?>
	}
</style>