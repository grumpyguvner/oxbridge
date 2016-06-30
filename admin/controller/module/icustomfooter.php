<?php
class ControllerModuleICustomFooter extends Controller {
	private $moduleName = 'icustomfooter';
	private $error = array();
	private $version = '3.3.2';
	
	public function duplicateSettings(){
		$this->load->model('module/icustomfooter');

		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
				$this->session->data['error'] = $this->language->get('error_permission');
				$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$toStoreID = $this->request->get['to'];
			$fromStoreID = $this->request->get['from'];
			$data['module_data_from_store'] = $this->model_module_icustomfooter->getSetting('icustomfooter', $fromStoreID);
			$this->model_module_icustomfooter->editSetting('icustomfooter', $data['module_data_from_store'], $toStoreID);
			$this->session->data['success'] = 'You have successfully dublicated store settings!';
			$this->response->redirect($this->url->link('module/icustomfooter', 'store_id='.$toStoreID.'&token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function duplicateLangSettings(){
		$this->load->model('module/icustomfooter');

		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }


		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
				$this->session->data['error'] = $this->language->get('error_permission');
				$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$toLangID = $this->request->get['to'];
			$fromLangID = $this->request->get['from'];
			$data['module_data'] = $this->model_module_icustomfooter->getSetting('icustomfooter', $this->request->get['store_id']);
			$data['module_data']['icustomfooter'][$fromLangID] = $data['module_data']['icustomfooter'][$toLangID];
			$this->model_module_icustomfooter->editSetting('icustomfooter', $data['module_data'], $this->request->get['store_id']);
			$this->session->data['success'] = 'You have successfully dublicated column settings!';
			$this->response->redirect($this->url->link('module/icustomfooter', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function index() {
		$data['moduleName'] = $this->moduleName;
		
		$this->load->model('localisation/language');
		$this->load->model('setting/store');
		$this->load->model('module/icustomfooter');
		
		$this->load->language('module/icustomfooter');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }
		
		$store = $this->getCurrentStore($this->request->get['store_id']);
		
		//Settings and Layouts
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && isset($this->request->post)) {
			if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
				$this->session->data['error'] = $this->language->get('error_permission');
				$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
					$this->request->post['icustomfooter']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
				}
				if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
					$this->request->post['icustomfooter']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']),true);
				}		
				if (!empty($this->request->post['paymentIconName'])) {
					$this->model_module_icustomfooter->uploadIcon();
				} else {
					if (!empty($this->request->post)) {
						$data = $this->request->post;
						$this->model_module_icustomfooter->editSetting('icustomfooter', $data, $this->request->post['store_id']);
						$this->session->data['success'] = $this->language->get('text_success');
						$this->response->redirect($this->url->link('module/icustomfooter', 'store_id='.$this->request->post['store_id'].'&token=' . $this->session->data['token'], 'SSL'));
					}
				}	
			}
		}
		
		// Initialize
		$this->document->addStyle('view/stylesheet/icustomfooter.css');
		$this->document->addScript('view/javascript/icustomfooter.js');
		
		$data['heading_title'] = $this->language->get('heading_title').' '.$this->version;
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');
		
		// Columns
		$dirName = DIR_APPLICATION . 'view/template/module/icustomfooter/';
		$data['dirName'] = $dirName;
		$column_files = scandir($dirName); 
		
		foreach ($column_files as $key => $file) {
			if (strpos($file, 'column_') === 0) {
				$data['columns'][] = array(
					'file' => $dirName . $file,
					'var' => substr($file, 7, strripos($file, '.') - 7)
				);
			}
			if (strpos($file, 'settings_column_') === 0) {
				$data['settings_columns'][] = array(
					'file' => $dirName . $file,
					'var' => substr($file, 16, strripos($file, '.') - 16)
				);
			}
		}
		
		$data['extraColumnAttributes'] = array(
			//'googlemaps' => ' onclick="$(\'.GoogleMapsPreviewButton\').click();"'
		);
		
		foreach (array_merge($data['columns'], $data['settings_columns']) as $column) {
			$data[$column['var']] = $this->language->get($column['var']);	
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$data['customColumnCount'] = 5;
		$data['customcolumn'] = $this->language->get('customcolumn');
		$data['duplicatecolumn'] = $this->language->get('duplicatecolumn');
		$data['footercustomization'] = $this->language->get('footercustomization');
		$data['assistance'] = $this->language->get('assistance');
		$data['globalsettings'] = $this->language->get('globalsettings');
		$data['assistancetitle'] = $this->language->get('assistancetitle');
		$data['assistancetext'] = $this->language->get('assistancetext');
		$data['yes'] = $this->language->get('yes');
		$data['no'] = $this->language->get('no');
		$data['flat'] = $this->language->get('flat');
		$data['white'] = $this->language->get('white');
		$data['dark'] = $this->language->get('dark');
		$data['hidewhatunfits'] = $this->language->get('hidewhatunfits');
		$data['showscrollers'] = $this->language->get('showscrollers');
		$data['dashed'] = $this->language->get('dashed');
		$data['dotted'] = $this->language->get('dotted');
		$data['solid'] = $this->language->get('solid');
		$data['double'] = $this->language->get('double');
		$data['groove'] = $this->language->get('groove');
		$data['ridge'] = $this->language->get('ridge');
		$data['inset'] = $this->language->get('inset');
		$data['outset'] = $this->language->get('outset');
		$data['noline'] = $this->language->get('noline');
		$data['defaultfont'] = $this->language->get('defaultfont');
		$data['greenicons'] = $this->language->get('greenicons');
		$data['whiteicons'] = $this->language->get('whiteicons');
		$data['blueicons'] = $this->language->get('blueicons');
		$data['preview'] = $this->language->get('preview');
		$data['titleofthecolumn'] = $this->language->get('titleofthecolumn');
		$data['aboutus_text'] = $this->language->get('aboutus_text');
		$data['showcolumn'] = $this->language->get('showcolumn');
		$data['columnposition'] = $this->language->get('columnposition');
		$data['contactus_iconset'] = $this->language->get('contactus_iconset');
		$data['contactus_title'] = $this->language->get('contactus_title');
		$data['contactus_text'] = $this->language->get('contactus_text');
		$data['contactus_address'] = $this->language->get('contactus_address');
		$data['contactus_phone'] = $this->language->get('contactus_phone');
		$data['contactus_fax'] = $this->language->get('contactus_fax');
		$data['contactus_email'] = $this->language->get('contactus_email');
		$data['contactus_skype'] = $this->language->get('contactus_skype');
		$data['maps_longlat'] = $this->language->get('maps_longlat');
		$data['maps_preview'] = $this->language->get('maps_preview');
		$data['maps_apikey'] = $this->language->get('maps_apikey');
		$data['contactform_sendemailsto'] = $this->language->get('contactform_sendemailsto');
		$data['twitter_numberoftweets'] = $this->language->get('twitter_numberoftweets');
		$data['twitter_keyword'] = $this->language->get('twitter_keyword');
		$data['twitter_widget_id'] = $this->language->get('twitter_widget_id');
		$data['twitter_fetch_tweets_from'] = $this->language->get('twitter_fetch_tweets_from');
		$data['twitter_profile'] = $this->language->get('twitter_profile');
		$data['twitter_keyword_mentioned_in_twitter'] = $this->language->get('twitter_keyword_mentioned_in_twitter');
		$data['facebook_pageurl'] = $this->language->get('facebook_pageurl');
		$data['facebook_pagetitle'] = $this->language->get('facebook_pagetitle');
		$data['facebook_widgetheight'] = $this->language->get('facebook_widgetheight');
		$data['facebook_usesmallheader'] = $this->language->get('facebook_usesmallheader');
		$data['facebook_hidecoverphoto'] = $this->language->get('facebook_hidecoverphoto');
		$data['facebook_showfriendsfaces'] = $this->language->get('facebook_showfriendsfaces');
		$data['facebook_showpageposts'] = $this->language->get('facebook_showpageposts');
		$data['youtube_url'] = $this->language->get('youtube_url');
		$data['youtube_width'] = $this->language->get('youtube_width');
		$data['youtube_height'] = $this->language->get('youtube_height');
		$data['custom_text'] = $this->language->get('custom_text');
		$data['contactform_captchaspamprotection'] = $this->language->get('contactform_captchaspamprotection');
		$data['contactform_emailsubject'] = $this->language->get('contactform_emailsubject');
		$data['contactform_nameboxlabel'] = $this->language->get('contactform_nameboxlabel');
		$data['contactform_emailboxlabel'] = $this->language->get('contactform_emailboxlabel');
		$data['contactform_messageboxlabel'] = $this->language->get('contactform_messageboxlabel');
		$data['contactform_captchaboxlabel'] = $this->language->get('contactform_captchaboxlabel');
		$data['contactform_sendbuttonlabel'] = $this->language->get('contactform_sendbuttonlabel');

		$data['duplicate_column_label'] = $this->language->get('duplicate_column_label');
		$data['duplicate_column_help'] = $this->language->get('duplicate_column_help');
		$data['duplicate_settings_label'] = $this->language->get('duplicate_settings_label');
		$data['duplicate_settings_help'] = $this->language->get('duplicate_settings_help');
		$data['duplicate_button'] = $this->language->get('duplicate_button');

		$data['contactform_successfulsentmessage'] = $this->language->get('contactform_successfulsentmessage');
		$data['contactform_requiredfieldmessage'] = $this->language->get('contactform_requiredfieldmessage');
		$data['contactform_notvalidmessage'] = $this->language->get('contactform_notvalidmessage');
		$data['contactform_notvalidcaptcha'] = $this->language->get('contactform_notvalidcaptcha');
		$data['contactform_message_max_length'] = $this->language->get('contactform_message_max_length');
		$data['paymenticons_showpaymenticons'] = $this->language->get('paymenticons_showpaymenticons');
		$data['paymenticons_paymenticons'] = $this->language->get('paymenticons_paymenticons');
		$data['paymenticons_addfiles'] = $this->language->get('paymenticons_addfiles');
		$data['paymenticons_uploadicons']	= $this->language->get('paymenticons_uploadicons');
		$data['paymenticons_titleoftheicon'] = $this->language->get('paymenticons_titleoftheicon');
		$data['paymenticons_upload'] = $this->language->get('paymenticons_upload');
		$data['paymenticons_confirm_delete'] = $this->language->get('paymenticons_confirm_delete');
		$data['paymenticons_delete'] = $this->language->get('paymenticons_delete');
		$data['showsocialbuttons'] = $this->language->get('showsocialbuttons');
		$data['facebooklikebutton'] = $this->language->get('facebooklikebutton');
		$data['pinterestpin'] = $this->language->get('pinterestpin');
		$data['googleplusbutton'] = $this->language->get('googleplusbutton');
		$data['linkedinbutton'] = $this->language->get('linkedinbutton');
		$data['twittertweet'] = $this->language->get('twittertweet');
		$data['showcustomfooter'] = $this->language->get('showcustomfooter');
		$data['footerwrapperwidth'] = $this->language->get('footerwrapperwidth');
		$data['footerwidth'] = $this->language->get('footerwidth');
		$data['footerusefooterwith'] = $this->language->get('footerusefooterwith');
		$data['footerusewithdefaultocwithicons'] = $this->language->get('footerusewithdefaultocwithicons');
		$data['footerusewiththemefooter'] = $this->language->get('footerusewiththemefooter');
		$data['footerusewithicons'] = $this->language->get('footerusewithicons');
		$data['footerusewithnone'] = $this->language->get('footerusewithnone');
		$data['hidepoweredby'] = $this->language->get('hidepoweredby');
		$data['footerfontfamily'] = $this->language->get('footerfontfamily');
		$data['footerbackgroundstyle'] = $this->language->get('footerbackgroundstyle');
		$data['footerbackgroundcolor'] = $this->language->get('footerbackgroundcolor');
		$data['usebackgroundcolor'] = $this->language->get('usebackgroundcolor');
		$data['footertextcolor'] = $this->language->get('footertextcolor');
		$data['footerlinkcolor'] = $this->language->get('footerlinkcolor');
		$data['whencontentoverflows'] = $this->language->get('whencontentoverflows');
		$data['columnheight'] = $this->language->get('columnheight');
		$data['columntitlecolor'] = $this->language->get('columntitlecolor');
		$data['columntitlebordercolor'] = $this->language->get('columntitlebordercolor');
		$data['columnlinestyle'] = $this->language->get('columnlinestyle');
		$data['responsivedesign'] = $this->language->get('responsivedesign');
		$data['columnheight'] = $this->language->get('columnheight');
		$data['columnwidth'] = $this->language->get('columnwidth');
		$data['customcss'] = $this->language->get('customcss');
		$data['text_default'] = $this->language->get('text_default');
		
		$data['module_data'] = $this->model_module_icustomfooter->getSetting('icustomfooter', $this->request->get['store_id']);
		$data['module_data'] = !isset($data['module_data']['icustomfooter']) ? $this->model_module_icustomfooter->getDefaultSettings() : $data['module_data']['icustomfooter'];
		
		// Images
		
		$raw_image_files = scandir(PAYMENTICONS_FOLDER);
		$imgurl = dirname(IMODULE_SERVER) . '/image/icustomfooter/paymenticons/';
		
		$image_files = array();
		foreach ($raw_image_files as $key => $value) {
			if (strstr($value, '.png') !== false || strstr($value, '.jpg') !== false || strstr($value, '.jpeg') !== false || strstr($value, '.gif') !== false) {
				$name = $value;
				$name = str_replace('.png', '', $name);
				$name = str_replace('.jpg', '', $name);
				$name = str_replace('.jpeg', '', $name);
				$name = str_replace('.gif', '', $name);
				$name = preg_replace('/[^a-z ]/i', '', $name);
				array_push($image_files, array(
					'path' => $imgurl . $value,
					'file' => PAYMENTICONS_FOLDER . $value,
					'name' => $name,
					'origname' => $value,
					'delete' => $this->url->link('module/icustomfooter/image_delete', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'] . '&image=' . $key, 'SSL'),
					'moveup' => $this->url->link('module/icustomfooter/image_moveup', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'] . '&moveup=' . $key, 'SSL'),
					'movedown' => $this->url->link('module/icustomfooter/image_movedown', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'] . '&movedown=' . $key, 'SSL')
				));
			}
		}
		
		$data['images'] = $image_files;
		
		$data['store']	= $store;
		
		$data['stores'] = $this->model_module_icustomfooter->getSystemStores();
		
		$data['token']	= $this->session->data['token'];
		
		$this->load->model('design/layout');
		
		$data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->template = 'module/icustomfooter.tpl';
		
		$data['header'] 		= $this->load->controller('common/header');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		$data['footer'] 		= $this->load->controller('common/footer');
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['action'] = $this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['languages'] = $this->model_module_icustomfooter->getSystemLanguages();

		foreach ($data['languages'] as $key => $value) {
			$data['languages'][$key]['flag_url'] = version_compare(VERSION, '2.2.0.0', "<") 
			? 'view/image/flags/'.$data['languages'][$key]['image']
			: 'language/'.$data['languages'][$key]['code'].'/'.$data['languages'][$key]['code'].'.png"';
		}

		
		$this->response->setOutput($this->load->view('module/icustomfooter.tpl', $data));
	}	
	
	public function image_moveup() {
		$this->language->load('module/icustomfooter');
		$this->load->model('module/icustomfooter');
		
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }

		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$this->model_module_icustomfooter->normalizeImages();
			
			$raw_image_files = scandir(PAYMENTICONS_FOLDER);
			
			$moveUp = $this->request->get['moveup']; 
			$oldName = $raw_image_files[$this->request->get['moveup']];
			$newName = str_pad($moveUp - 1, strlen(count($raw_image_files) - 1), '0', STR_PAD_LEFT) . '_' . preg_replace('/[^a-z .]/i', '', $oldName);
			rename(PAYMENTICONS_FOLDER . $oldName, PAYMENTICONS_FOLDER . $newName);
			
			$oldName = $raw_image_files[$moveUp - 1];
			$newName = str_pad($moveUp, strlen(count($raw_image_files) - 1), '0', STR_PAD_LEFT) . '_' . preg_replace('/[^a-z .]/i', '', $oldName);
			rename(PAYMENTICONS_FOLDER . $oldName, PAYMENTICONS_FOLDER . $newName);
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->response->redirect($this->url->link('module/icustomfooter', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function image_movedown() {
		$this->language->load('module/icustomfooter');
		$this->load->model('module/icustomfooter');
		
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }

		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$this->model_module_icustomfooter->normalizeImages();
			
			$raw_image_files = scandir(PAYMENTICONS_FOLDER);
			
			$moveDown = $this->request->get['movedown']; 
			$oldName = $raw_image_files[$this->request->get['movedown']];
			$newName = str_pad($moveDown + 1, strlen(count($raw_image_files) - 1), '0', STR_PAD_LEFT) . '_' . preg_replace('/[^a-z .]/i', '', $oldName);
			rename(PAYMENTICONS_FOLDER . $oldName, PAYMENTICONS_FOLDER . $newName);
			
			$oldName = $raw_image_files[$moveDown + 1];
			$newName = str_pad($moveDown, strlen(count($raw_image_files) - 1), '0', STR_PAD_LEFT) . '_' . preg_replace('/[^a-z .]/i', '', $oldName);
			rename(PAYMENTICONS_FOLDER . $oldName, PAYMENTICONS_FOLDER . $newName);
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->response->redirect($this->url->link('module/icustomfooter', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function image_delete() {
		$this->language->load('module/icustomfooter');
		$this->load->model('module/icustomfooter');
		
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }

		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$raw_image_files = scandir(PAYMENTICONS_FOLDER);
			
			unlink(PAYMENTICONS_FOLDER . $raw_image_files[$this->request->get['image']]);
			$this->model_module_icustomfooter->normalizeImages();
			
			$this->session->data['success'] = $this->language->get('text_success');
		}
		
		$this->response->redirect($this->url->link('module/icustomfooter', 'store_id='.$this->request->get['store_id'].'&token=' . $this->session->data['token'], 'SSL'));
	}
	
	private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }
	
	private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }
	
	public function install() {
		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
			$this->language->load('module/icustomfooter');
			$this->session->data['error'] = $this->language->get('error_permission');
			$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('module/icustomfooter');
	    	$this->model_module_icustomfooter->install();
		}
	}
	
	public function uninstall() {
		if (!$this->user->hasPermission('modify', 'module/icustomfooter')) {
			$this->language->load('module/icustomfooter');
			$this->session->data['error'] = $this->language->get('error_permission');
			$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('module/icustomfooter');
			$this->load->model('setting/store');
			$this->load->model('localisation/language');
			$this->load->model('design/layout');
			
			$this->model_module_icustomfooter->deleteSetting($this->moduleName,0);
			$stores=$this->model_setting_store->getStores();
			
			foreach ($stores as $store) {
				$this->model_module_icustomfooter->deleteSetting('icustomfooter', $store['store_id']);
			}
			$this->model_module_icustomfooter->uninstall();
		}
	}
}
?>