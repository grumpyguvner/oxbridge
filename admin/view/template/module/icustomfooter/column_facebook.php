<table class="table">
	<tr>
    	<td class="col-xs-2">
        	<label for="FacebookShow_<?php echo $lang['code']; ?>"><?php echo $showcolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][Show]" id="FacebookShow_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['Show'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['Show'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="ColumnPositionFacebook_<?php echo $lang['code']; ?>"><?php echo $columnposition; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input id="ColumnPositionFacebook_<?php echo $lang['code']; ?>" class="form-control" type="text" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Positions][facebook]" value="<?php echo $module_data[$lang['code']]['Positions']['facebook']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookTitle_<?php echo $lang['code']; ?>"><?php echo $titleofthecolumn; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][Title]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['Title']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookURL_<?php echo $lang['code']; ?>"><?php echo $facebook_pageurl; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookURL_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][URL]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['URL']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookPageTitle_<?php echo $lang['code']; ?>"><?php echo $facebook_pagetitle; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookPageTitle_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][PageTitle]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['PageTitle']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookHeight_<?php echo $lang['code']; ?>"><?php echo $facebook_widgetheight; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<input type="text" id="FacebookHeight_<?php echo $lang['code']; ?>" class="form-control" name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][Height]" value="<?php echo $module_data[$lang['code']]['Widgets']['Facebook']['Height']; ?>" />
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookUseSmallHeader_<?php echo $lang['code']; ?>"><?php echo $facebook_usesmallheader; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][UseSmallHeader]" id="FacebookUseSmallHeader_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['UseSmallHeader'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['UseSmallHeader'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookHideCoverPhoto_<?php echo $lang['code']; ?>"><?php echo $facebook_hidecoverphoto; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][HideCoverPhoto]" id="FacebookHideCoverPhoto_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['HideCoverPhoto'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['HideCoverPhoto'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookShowFriendsFaces_<?php echo $lang['code']; ?>"><?php echo $facebook_showfriendsfaces; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][ShowFriendsFaces]" id="FacebookShowFriendsFaces_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['ShowFriendsFaces'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['ShowFriendsFaces'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
    <tr>
    	<td class="col-xs-2">
        	<label for="FacebookShowPagePosts_<?php echo $lang['code']; ?>"><?php echo $facebook_showpageposts; ?></label>
        </td>
        <td>
        	<div class="col-xs-4">
            	<select name="<?php echo $moduleName; ?>[<?php echo $lang['code']; ?>][Widgets][Facebook][ShowPagePosts]" id="FacebookShowPagePosts_<?php echo $lang['code']; ?>" class="form-control">
                    <option value="true" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['ShowPagePosts'] == 'true') ? 'selected=selected' : '';?>><?php echo $yes; ?></option>
                    <option value="false" <?php echo ($module_data[$lang['code']]['Widgets']['Facebook']['ShowPagePosts'] == 'false') ? 'selected=selected' : '';?>><?php echo $no; ?></option>
                </select>
            </div>
    	</td>
    </tr>
</table>