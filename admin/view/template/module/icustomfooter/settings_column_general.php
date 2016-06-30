<?php //echo'<pre>'; var_dump($module_data); exit; ?>
<table class="table">
	<tr>
    	<td class="col-xs-2"><label for="SettingsShow"><?php echo $showcustomfooter; ?></label></td>
        <td>
        	<div class="col-xs-4">
                <select name="<?php echo $moduleName; ?>[Settings][Show]" class="form-control" id="SettingsShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['Show']) && $module_data['Settings']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['Show']) && $module_data['Settings']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsResponsiveDesign"><?php echo $responsivedesign; ?></label></td>
    	<td>
        	<div class="col-xs-4">
                <select name="<?php echo $moduleName; ?>[Settings][ResponsiveDesign]" class="form-control" id="SettingsResponsiveDesign">
                    <option value="no" <?php echo (!empty($module_data['Settings']['ResponsiveDesign']) && $module_data['Settings']['ResponsiveDesign'] == 'no') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                    <option value="yes" <?php echo (!empty($module_data['Settings']['ResponsiveDesign']) && $module_data['Settings']['ResponsiveDesign'] == 'yes') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsFooterWrapperWidth"><?php echo $footerwrapperwidth; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="SettingsFooterWrapperWidth" class="form-control" name="<?php echo $moduleName; ?>[Settings][FooterWrapperWidth]" value="<?php echo (!empty($module_data['Settings']['FooterWrapperWidth'])) ? $module_data['Settings']['FooterWrapperWidth'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsFooterWidth"><?php echo $footerwidth; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="SettingsFooterWidth" class="form-control" name="<?php echo $moduleName; ?>[Settings][FooterWidth]" value="<?php echo (!empty($module_data['Settings']['FooterWidth'])) ? $module_data['Settings']['FooterWidth'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsUseFooterWith"><?php echo $footerusefooterwith; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][UseFooterWith]" class="form-control" id="SettingsUseFooterWith">
                    <option value="defaultocwithicons" <?php echo (!empty($module_data['Settings']['UseFooterWith']) && $module_data['Settings']['UseFooterWith'] == 'defaultocwithicons') ? 'selected=selected' : ''; ?>><?php echo $footerusewithdefaultocwithicons; ?></option>
                    <option value="themefooter" <?php echo (!empty($module_data['Settings']['UseFooterWith']) && $module_data['Settings']['UseFooterWith'] == 'themefooter') ? 'selected=selected' : ''; ?>><?php echo $footerusewiththemefooter; ?></option>
                    <option value="icons" <?php echo (!empty($module_data['Settings']['UseFooterWith']) && $module_data['Settings']['UseFooterWith'] == 'icons') ? 'selected=selected' : ''; ?>><?php echo $footerusewithicons; ?></option>
                    <option value="none" <?php echo (!empty($module_data['Settings']['UseFooterWith']) && $module_data['Settings']['UseFooterWith'] == 'none') ? 'selected=selected' : ''; ?>><?php echo $footerusewithnone; ?></option>

                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsHidePoweredBy"><?php echo $hidepoweredby; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][HidePoweredBy]" class="form-control" id="SettingsHidePoweredBy">
                    <option value="" <?php echo ($module_data['Settings']['HidePoweredBy'] == '') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                    <option value="display:none;" <?php echo ($module_data['Settings']['HidePoweredBy'] == 'display:none;') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsFontFamily"><?php echo $footerfontfamily; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][FontFamily]" class="form-control" id="SettingsFontFamily">
                    <option value="fontfamilyinherit" <?php echo ($module_data['Settings']['FontFamily'] == 'fontfamilyinherit') ? 'selected=selected' : ''; ?>><?php echo $defaultfont; ?></option>
                    <option value="fontfamilyarialhelvetica" <?php echo ($module_data['Settings']['FontFamily'] == 'fontfamilyarialhelvetica') ? 'selected=selected' : ''; ?>>Arial, Helvetica</option>
                    <option value="fontfamilygeorgiatimesnewroman" <?php echo ($module_data['Settings']['FontFamily'] == 'fontfamilygeorgiatimesnewroman') ? 'selected=selected' : ''; ?>>Georgia, Times New Roman</option>
                    <option value="fontfamilytrebuchetms" <?php echo ($module_data['Settings']['FontFamily'] == 'fontfamilytrebuchetms') ? 'selected=selected' : ''; ?>>Trebuchet MS</option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsBackgroundPattern"><?php echo $footerbackgroundstyle; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][BackgroundPattern]" class="form-control" id="SettingsBackgroundPattern">
                	<option value="flatfooterlayout" <?php echo ($module_data['Settings']['BackgroundPattern'] == 'flatlayout') ? 'selected=selected' : ''; ?>><?php echo $flat; ?></option>
                    <option value="whitebgpattern" <?php echo ($module_data['Settings']['BackgroundPattern'] == 'whitebgpattern') ? 'selected=selected' : ''; ?>><?php echo $white; ?></option>
                    <option value="darkbgpattern" <?php echo ($module_data['Settings']['BackgroundPattern'] == 'darkbgpattern') ? 'selected=selected' : ''; ?>><?php echo $dark; ?></option>
                    <option value="usebackgroundcolor" <?php echo ($module_data['Settings']['BackgroundPattern'] == 'usebackgroundcolor') ? 'selected=selected' : ''; ?>><?php echo $usebackgroundcolor; ?></option>
    			</select>
    		</div>
    	</td>
    </tr>
    <tr class="custom-color-settings">
    	<td class="col-xs-2"><label for="SettingsBackgroundColor"><?php echo $footerbackgroundcolor; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsBackgroundColor" name="<?php echo $moduleName; ?>[Settings][BackgroundColor]" value="<?php echo !empty($module_data['Settings']['BackgroundColor']) ? $module_data['Settings']['BackgroundColor'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr class="custom-color-settings">
    	<td class="col-xs-2"><label for="SettingsColumnColor"><?php echo $columntitlecolor; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsColumnColor" name="<?php echo $moduleName; ?>[Settings][ColumnColor]" value="<?php echo $module_data['Settings']['ColumnColor']; ?>" />
            </div>
    	</td>
    </tr>
    <tr class="custom-color-settings">
    	<td class="col-xs-2"><label for="SettingsColumnBorderColor"><?php echo $columntitlebordercolor; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsColumnBorderColor" name="<?php echo $moduleName; ?>[Settings][ColumnBorderColor]" value="<?php echo $module_data['Settings']['ColumnBorderColor']; ?>" />
            </div>
    	</td>
    </tr>
    <tr class="custom-color-settings">
    	<td class="col-xs-2"><label for="SettingsTextColor"><?php echo $footertextcolor; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsTextColor" name="<?php echo $moduleName; ?>[Settings][TextColor]" value="<?php echo !empty($module_data['Settings']['TextColor']) ? $module_data['Settings']['TextColor'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr class="custom-color-settings">
    	<td class="col-xs-2"><label for="SettingsLinkColor"><?php echo $footerlinkcolor; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsLinkColor" name="<?php echo $moduleName; ?>[Settings][LinkColor]" value="<?php echo !empty($module_data['Settings']['LinkColor']) ? $module_data['Settings']['LinkColor'] : ''; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsColumnContentOverflow"><?php echo $whencontentoverflows; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][ColumnContentOverflow]" class="form-control" id="SettingsColumnContentOverflow">
                    <option value="overflowhidden" <?php echo ($module_data['Settings']['ColumnContentOverflow'] == 'overflowhidden') ? 'selected=selected' : ''; ?>><?php echo $hidewhatunfits; ?></option>
                    <option value="overflowauto" <?php echo ($module_data['Settings']['ColumnContentOverflow'] == 'overflowauto') ? 'selected=selected' : ''; ?>><?php echo $showscrollers; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsColumnHeight"><?php echo $columnheight; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsColumnHeight" name="<?php echo $moduleName; ?>[Settings][ColumnHeight]" value="<?php echo $module_data['Settings']['ColumnHeight']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsColumnWidth"><?php echo $columnwidth; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" class="form-control" id="SettingsColumnWidth" name="<?php echo $moduleName; ?>[Settings][ColumnWidth]" value="<?php echo $module_data['Settings']['ColumnWidth']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="SettingsColumnLineStyle"><?php echo $columnlinestyle; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][ColumnLineStyle]" class="form-control" id="SettingsColumnLineStyle">
                    <option value="dotted" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'dotted') ? 'selected=selected' : ''; ?>><?php echo $dotted; ?></option>
                    <option value="dashed" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'dashed') ? 'selected=selected' : ''; ?>><?php echo $dashed; ?></option>
                    <option value="solid" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'solid') ? 'selected=selected' : ''; ?>><?php echo $solid; ?></option>
                    <option value="double" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'double') ? 'selected=selected' : ''; ?>><?php echo $double; ?></option>
                    <option value="groove" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'groove') ? 'selected=selected' : ''; ?>><?php echo $groove; ?></option>
                    <option value="ridge" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'ridge') ? 'selected=selected' : ''; ?>><?php echo $ridge; ?></option>
                    <option value="inset" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'inset') ? 'selected=selected' : ''; ?>><?php echo $inset; ?></option>
                    <option value="outset" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'outset') ? 'selected=selected' : ''; ?>><?php echo $outset; ?></option>
                    <option value="none" <?php echo ($module_data['Settings']['ColumnLineStyle'] == 'none') ? 'selected=selected' : ''; ?>><?php echo $noline; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2 item-top"><label for="SettingsCustomCSS"><?php echo $customcss; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<textarea id="SettingsCustomCSS" class="form-control" rows="10" name="<?php echo $moduleName; ?>[Settings][CustomCSS]"><?php echo $module_data['Settings']['CustomCSS']; ?></textarea>
            </div>
    	</td>
    </tr>
</table>

<script>
$(document).ready(function(e) {
    var $typeSelector = $('#SettingsBackgroundPattern');
	var $toggleOptions = $(".custom-color-settings");
	 if ($typeSelector.val() == 'usebackgroundcolor') {
			$toggleOptions.show();
        }
        else {
			$toggleOptions.hide();
        }
    $typeSelector.change(function(){
        if ($typeSelector.val() == 'usebackgroundcolor') {
			$toggleOptions.show("fast");
        }
        else {
			$toggleOptions.hide("fast");
        }
    });
});
</script>