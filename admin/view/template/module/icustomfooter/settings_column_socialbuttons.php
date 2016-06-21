<table class="table">
	<tr>
    	<td class="col-xs-2"><label for="ButtonsShow"><?php echo $showsocialbuttons; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][SocialButtons][Show]" class="form-control" id="ButtonsShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['SocialButtons']['Show']) && $module_data['Settings']['SocialButtons']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['SocialButtons']['Show']) && $module_data['Settings']['SocialButtons']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="FacebookLikeShow"><?php echo $facebooklikebutton; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][SocialButtons][FacebookLike][Show]" class="form-control" id="FacebookLikeShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['SocialButtons']['FacebookLike']['Show']) && $module_data['Settings']['SocialButtons']['FacebookLike']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['SocialButtons']['FacebookLike']['Show']) && $module_data['Settings']['SocialButtons']['FacebookLike']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="TwitterPinShow"><?php echo $twittertweet; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][SocialButtons][TwitterPin][Show]" class="form-control" id="TwitterPinShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['SocialButtons']['TwitterPin']['Show']) && $module_data['Settings']['SocialButtons']['TwitterPin']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['SocialButtons']['TwitterPin']['Show']) && $module_data['Settings']['SocialButtons']['TwitterPin']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="PinterestPinShow"><?php echo $pinterestpin; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][SocialButtons][PinterestPin][Show]" class="form-control" id="PinterestPinShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['SocialButtons']['PinterestPin']['Show']) && $module_data['Settings']['SocialButtons']['PinterestPin']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['SocialButtons']['PinterestPin']['Show']) && $module_data['Settings']['SocialButtons']['PinterestPin']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="GooglePlusShow"><?php echo $googleplusbutton; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][SocialButtons][GooglePlus][Show]" class="form-control" id="GooglePlusShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['SocialButtons']['GooglePlus']['Show']) && $module_data['Settings']['SocialButtons']['GooglePlus']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['SocialButtons']['GooglePlus']['Show']) && $module_data['Settings']['SocialButtons']['GooglePlus']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2"><label for="LinkedInShareShow"><?php echo $linkedinbutton; ?></label></td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[Settings][SocialButtons][LinkedInShare][Show]" class="form-control" id="LinkedInShareShow">
                    <option value="true" <?php echo (!empty($module_data['Settings']['SocialButtons']['LinkedInShare']['Show']) && $module_data['Settings']['SocialButtons']['LinkedInShare']['Show'] == 'true') ? 'selected=selected' : ''; ?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo (!empty($module_data['Settings']['SocialButtons']['LinkedInShare']['Show']) && $module_data['Settings']['SocialButtons']['LinkedInShare']['Show'] == 'false') ? 'selected=selected' : ''; ?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
</table>