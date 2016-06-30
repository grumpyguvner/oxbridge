<?php class Modelmoduleicustomfooter extends Model {
	public function __construct($register) {
		if (!defined('IMODULE_ROOT')) define('IMODULE_ROOT', substr(DIR_APPLICATION, 0, strrpos(DIR_APPLICATION, '/', -2)) . '/');
		if (!defined('IMODULE_SERVER_NAME')) define('IMODULE_SERVER_NAME', substr((defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER), 7, strlen((defined('HTTP_CATALOG') ? HTTP_CATALOG : HTTP_SERVER)) - 8));
		if (!defined('IMODULE_SERVER')) define('IMODULE_SERVER', isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1')) ? HTTPS_SERVER : HTTP_SERVER);
		if (!defined('PAYMENTICONS_FOLDER')) define('PAYMENTICONS_FOLDER', DIR_IMAGE . 'icustomfooter/paymenticons/');
		
		parent::__construct($register);
	}

	private function getDBCode(){
		return version_compare(VERSION, '2.0.1.0', '>=') ? 'code' : 'group';
	}
	
	public function getSetting($code, $store_id = 0) {
		$setting_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `".$this->getDBCode()."` = '" . $this->db->escape($code) . "'");

		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$setting_data[$result['key']] = $result['value'];
			} else {
				$setting_data[$result['key']] = unserialize($result['value']);
			}
		}

		return $setting_data;
	}
	
	public function editSetting($code, $data, $store_id = 0) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `".$this->getDBCode()."` = '" . $this->db->escape($code) . "'");

		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($code)) == $code) {
				if (!is_array($value)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `".$this->getDBCode()."` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `".$this->getDBCode()."` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
				}
			}
		}
	}
	
	public function deleteSetting($code, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `".$this->getDBCode()."` = '" . $this->db->escape($code) . "'");
	}
	
	public function findTextBetween($word1, $word2, $content) {
		$between = str_replace($word1, '',substr($content, strpos($content, $word1), strpos($content, $word2) - strpos($content, $word1)));
		return $between;
	}
	
	public function normalizeImages() {
		$raw_image_files = scandir(PAYMENTICONS_FOLDER);
		foreach ($raw_image_files as $index => $file) {
			if (in_array($file, array('.', '..'))) continue;
			$oldName = $file;
			$newName = str_pad($index, strlen(count($raw_image_files) - 1), '0', STR_PAD_LEFT) . '_' . preg_replace('/[^a-z .]/i', '', $oldName);
			rename(PAYMENTICONS_FOLDER . $oldName, PAYMENTICONS_FOLDER . $newName);
		}
	}
	
	public function uploadIcon() {
		$files = $this->request->files['paymentIcon'];
		$dir = DIR_IMAGE . 'icustomfooter/paymenticons/';
		
		if ((($files["type"] == "image/gif") || ($files["type"] == "image/jpeg") || ($files["type"] == "image/png")) && $files["size"] < 102400) {
			if ($files["error"] > 0) {
				$this->session->data['error'] = $this->language->get('error_upload');
				$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$extension = pathinfo($files['name'], PATHINFO_EXTENSION);
				$target_name = $dir . '00_' . $this->request->post['paymentIconName'] . '.' . $extension;
				
				if (file_exists($target_name)) {
					$this->session->data['error'] = $this->language->get('error_upload_exists');
					$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					move_uploaded_file($files["tmp_name"], $target_name);
					$this->session->data['success'] = $this->language->get('success_upload_icon');
					$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		} else {
			$this->session->data['error'] = $this->language->get('error_upload');
			$this->response->redirect($this->url->link('module/icustomfooter', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
		exit();				
	}
	
	public function getSystemStores() {
		$this->load->model('setting/store');
		return array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' .$this->language->get('text_default') . ')', 'url' => NULL, 'ssl' => NULL)), $this->model_setting_store->getStores());
	}
	
	public function getSystemLanguages() {
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages(array());
		return $languages;
	}
	
	public function getDefaultSettings() {
		$settings_json = '{"en":{"Widgets":{"AboutUs":{"Show":"true","Title":"About us","Text":"<p>iCustomFooter is a widely popular custom footer creation module. It is light-weight piece of software that comes with preset Twitter, Facebook, YouTube and Pinterest integrations. Other options include text editing via Rich Text Editor and controlling the visibility of each widget. Should you have any concerns or questions please visit our support page from the link in the module.<\/p>\r\n\r\n<p>Enjoy iCustomFooter!<\/p>\r\n"},"ContactForm":{"Show":"true","UseCaptcha":"true","Title":"Drop us a line","Email":"conicgp@gmail.com","EmailSubject":"iCustomFooter Message","LabelName":"Name","LabelEmail":"Email","LabelMessage":"Message","MaxMessageLength":"1000","LabelCaptcha":"Enter code","LabelSend":"Send message","LabelSuccess":"Your message was sent, thanks!","LabelRequired":"is a required field","LabelNotValid":"is not valid","LabelInvalidCaptcha":"Invalid CAPTCHA code"},"Contacts":{"Show":"true","IconSet":"blueicons","Title":"Contact us","Text":"<p>Work days 9am - 6pm<\/p>\r\n","Address1":"1 Infinite Loop","Address2":"Cupertino, CA 95014","Phone1":"800-692-7753","Phone2":"1-800-MY-APPLE","Fax1":"800-692-7753","Fax2":"1-800-MY-APPLE","Email1":"some@apple.com","Email2":"other@apple.com","Skype1":"appleskype","Skype2":"petermarretc"},"Facebook":{"Show":"true","Title":"Facebook","URL":"http:\/\/www.facebook.com\/iSenseLabs","PageTitle":"iSenseLabs","Height":"310","UseSmallHeader":"false","HideCoverPhoto":"false","ShowFriendsFaces":"true","ShowPagePosts":"true"},"GoogleMaps":{"Show":"true","Title":"Google Maps","Points":{"0":{"Name":"Store1","Longitude":"42.6973336","Latitude":"23.323"}},"APIKey":""},"Twitter":{"Show":"true","NumberOfTweets":"2","Title":"Tweet feed","Method":"profile","Profile":"iSenseLabs","Keyword":"isense"},"YouTube":{"Show":"true","Title":"YouTube","URL":"0xpknJCGSdA","Width":"262","Height":"262"},"Custom1":{"Show":"true","Title":"Custom column 1","Text":"<p>In this column you can put any custom content you want via the admin panel. You can edit it though a rich text editor which means you can format the text, upload images, add flash, links and others. You can also change the title of each column in iCustomFooter.<\/p>\r\n\r\n<p>As Norman Vincent Pealse says,&nbsp;<em>\u201cEvery problem has in it the seeds of its own solution. If you don\u2019t have any problems, you don\u2019t get any seeds.\u201d<\/em><\/p>\r\n\r\n<p>Enjoy the custom column!<\/p>\r\n"},"Custom2":{"Show":"false","Title":"Custom column 2","Text":"<p>In this column you can put any custom content you want via the admin panel. You can edit it though a rich text editor which means you can format the text, upload images, add flash, links and others. You can also change the title of each column in iCustomFooter.<\/p>\r\n\r\n<p>As Norman Vincent Pealse says,&nbsp;<em>\u201cEvery problem has in it the seeds of its own solution. If you don\u2019t have any problems, you don\u2019t get any seeds.\u201d<\/em><\/p>\r\n\r\n<p>Enjoy the custom column!<\/p>\r\n"},"Custom3":{"Show":"false","Title":"Custom column 3","Text":"<p>In this column you can put any custom content you want via the admin panel. You can edit it though a rich text editor which means you can format the text, upload images, add flash, links and others. You can also change the title of each column in iCustomFooter.<\/p>\r\n\r\n<p>As Norman Vincent Pealse says,&nbsp;<em>\u201cEvery problem has in it the seeds of its own solution. If you don\u2019t have any problems, you don\u2019t get any seeds.\u201d<\/em><\/p>\r\n\r\n<p>Enjoy the custom column!<\/p>\r\n"},"Custom4":{"Show":"false","Title":"Custom column 4","Text":"<p>In this column you can put any custom content you want via the admin panel. You can edit it though a rich text editor which means you can format the text, upload images, add flash, links and others. You can also change the title of each column in iCustomFooter.<\/p>\r\n\r\n<p>As Norman Vincent Pealse says,&nbsp;<em>\u201cEvery problem has in it the seeds of its own solution. If you don\u2019t have any problems, you don\u2019t get any seeds.\u201d<\/em><\/p>\r\n\r\n<p>Enjoy the custom column!<\/p>\r\n"},"Custom5":{"Show":"false","Title":"Custom column 5","Text":"<p>In this column you can put any custom content you want via the admin panel. You can edit it though a rich text editor which means you can format the text, upload images, add flash, links and others. You can also change the title of each column in iCustomFooter.<\/p>\r\n\r\n<p>As Norman Vincent Pealse says,&nbsp;<em>\u201cEvery problem has in it the seeds of its own solution. If you don\u2019t have any problems, you don\u2019t get any seeds.\u201d<\/em><\/p>\r\n\r\n<p>Enjoy the custom column!<\/p>\r\n"}},"Positions":{"aboutus":"1","contactform":"4","contacts":"3","facebook":"7","googlemaps":"5","twitter":"6","youtube":"8","Custom1":"2","Custom2":"9","Custom3":"10","Custom4":"11","Custom5":"12"}},"Settings":{"PaymentIcons":{"Show":"true"},"SocialButtons":{"Show":"true","FacebookLike":{"Show":"true"},"TwitterPin":{"Show":"true"},"PinterestPin":{"Show":"true"},"GooglePlus":{"Show":"true"},"LinkedInShare":{"Show":"true"}},"Show":"false","ResponsiveDesign":"no","FooterWrapperWidth":"100%","FooterWidth":"1170px","UseFooterWith":"defaultocwithicons","HidePoweredBy":"","FontFamily":"fontfamilyinherit","BackgroundPattern":"flatfooterlayout","ColumnContentOverflow":"overflowhidden","ColumnHeight":"390px","ColumnWidth":"292px","BackgroundColor":"#06101a","ColumnColor":"#ffffff","ColumnBorderColor":"#ffffff","TextColor":"#ffffff","LinkColor":"#23a1d1","ColumnLineStyle":"dotted","CustomCSS":"\/* Write your Custom CSS here *\/\r\n"}}';
		$settings = json_decode($settings_json, true);
		$languages = $this->getSystemLanguages();
		
		foreach($languages as $l) {
			if (strtolower($l['code']) != 'en') {
				$settings[$l['code']] = $settings['en'];
			}
		}
		
		return $settings;
	}
	
	public function install() {
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=1 WHERE `name` LIKE'%iCustomFooter by iSenseLabs%'");
		$this->getDefaultSettings();
		$modifications = $this->load->controller('extension/modification/refresh');
  	} 
  
  	public function uninstall() {
		$this->db->query("UPDATE `" . DB_PREFIX . "modification` SET status=0 WHERE `name` LIKE'%iCustomFooter by iSenseLabs%'");
		$modifications = $this->load->controller('extension/modification/refresh');
  	}
}
?>