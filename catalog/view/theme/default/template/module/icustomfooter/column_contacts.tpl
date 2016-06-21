<?php if ($idata[$langcode]['Widgets']['Contacts']['Show'] == 'true'): ?>
<li class="iContactUs iWidget grid_footer_3">
	<div class="iWidgetWrapper">
		<h2><?php echo $idata[$langcode]['Widgets']['Contacts']['Title']?></h2>
        <div class="belowTitleContainer">
            <div class="text"><?php echo html_entity_decode($idata[$langcode]['Widgets']['Contacts']['Text'])?></div>
            <ul class="iContactsListing">
    
                <?php if (!empty($idata[$langcode]['Widgets']['Contacts']['Address1']) || !empty($idata[$langcode]['Widgets']['Contacts']['Address2'])): ?>
                <li class="iAddress">
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Address1']?></div>
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Address2']?></div>
                </li>
                <?php endif; ?>
                <?php if (!empty($idata[$langcode]['Widgets']['Contacts']['Phone1']) || !empty($idata[$langcode]['Widgets']['Contacts']['Phone2'])): ?>
                <li class="iPhone">
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Phone1']?></div>
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Phone2']?></div>
                </li>
                <?php endif; ?>
                <?php if (!empty($idata[$langcode]['Widgets']['Contacts']['Fax1']) || !empty($idata[$langcode]['Widgets']['Contacts']['Fax2'])): ?>
                <li class="iFax">
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Fax1']?></div>
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Fax2']?></div>
                </li>
                <?php endif; ?>   
                <?php if (!empty($idata[$langcode]['Widgets']['Contacts']['Email1']) || !empty($idata[$langcode]['Widgets']['Contacts']['Email2'])): ?>
                <li class="iEmail">
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Email1']?></div>
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Email2']?></div>
                </li>
                <?php endif; ?>              
                <?php if (!empty($idata[$langcode]['Widgets']['Contacts']['Skype1']) || !empty($idata[$langcode]['Widgets']['Contacts']['Skype2'])): ?>
                <li class="iSkype">
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Skype1']?></div>
                    <div class="contactItem"><?php echo $idata[$langcode]['Widgets']['Contacts']['Skype2']?></div>
                </li>
                <?php endif; ?>              
            </ul>
         </div>
	</div>
</li>
<?php endif; ?>
