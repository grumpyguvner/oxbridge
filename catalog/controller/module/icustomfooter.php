<?php  
class ControllerModuleIcustomfooter extends Controller {
	public function index() {
		$this->load->model('module/icustomfooter');
		
		$data = $this->model_module_icustomfooter->getSetting('icustomfooter', $this->config->get('config_store_id'));
		
		if (!empty($data['icustomfooter'])) {
			$data = $data['icustomfooter'];		
		}
		
		if (!empty($data) && $data['Settings']['Show'] == 'true') {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/icustomfooter.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/icustomfooter.css');
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/icustomfooter.css');
			}
			
			if (is_dir(DIR_TEMPLATE . $this->config->get('config_template').'/template/module/icustomfooter/')) {
				$data['themefoldername'] = $this->config->get('config_template');
				$data['themepath'] = 'catalog/view/theme/' . $this->config->get('config_template');
			} else {
				$data['themefoldername'] = 'default';
				$data['themepath'] = 'catalog/view/theme/default/';
			}
			
			$data['columns'] = array();
			$data['idata'] = $data;
			
			$data['footerPath'] = is_dir(DIR_TEMPLATE . $this->config->get('config_template').'/template/module/icustomfooter/') ? DIR_TEMPLATE . $this->config->get('config_template').'/template/module/icustomfooter/' : DIR_TEMPLATE . '/default/template/module/icustomfooter/';
			
			$config_language_id = $this->config->get('config_language_id');
			$this->load->model('localisation/language');
			$language = $this->model_localisation_language->getLanguage($config_language_id);
			$langcode = $language['code'];
			
			$data['langcode'] = $langcode;
						
			$positions = $data[$langcode]['Positions'];
			asort($positions);
			
			foreach ($positions as $file => $pos) {
				$column = $this->load->controller('module/icustomfooter/column_' . strtolower($file), array('idata' => $data, 'langcode' => $langcode));
				
				if ($column) {
					$data['columns'][] = $column;
				}
			}

			if(version_compare(VERSION, '2.2.0.0', "<")) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/icustomfooter.tpl')) {
					return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/icustomfooter.tpl', $data);
				} else {
					return $this->load->view('default/template/module/icustomfooter/icustomfooter.tpl', $data);
				}
			} else {
			       return $this->load->view('module/icustomfooter/icustomfooter', $data);
			 }
			

		}
	}
	
	public function column_aboutus($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }


	}
	
	public function column_custom1($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_custom2($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_custom3($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_custom4($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_custom5($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_contacts($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_googlemaps($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_contactform($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		$config = $setting['idata'][$setting['langcode']]['Widgets']['ContactForm'];
		
		$val = intval($config['MaxMessageLength']);
		if (empty($val)) $val = 1000;
		$data['messageLimit'] = $val;
		$data['flash'] = '';
		
		if (isset($this->request->post['iContactForm'])) {
			$pass = true;
			if ($config['UseCaptcha'] == 'true') {
				if (empty($this->session->data['icustomfooter_captcha']) || empty($this->request->post['iContactForm']['Captcha']) || $this->request->post['iContactForm']['Captcha'] != $this->session->data['icustomfooter_captcha']) $pass = false;
				if (!$pass) $data['flash'] = '<div class="redflashmessage" style="display:block;">'.$config['LabelInvalidCaptcha'].'</div>';
			}
			
			if (empty($this->request->post['iContactForm']['Message']) || empty($this->request->post['iContactForm']['Name']) || empty($this->request->post['iContactForm']['Email'])) $pass = false;
			
			if ($pass) {
				
				if (VERSION < '2.0.2.0') {
					$mail = new Mail($this->config->get('config_mail'));
				} else {
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				}
				
				$mail->setTo($config['Email']);
				$mail->setFrom(substr($this->request->post['iContactForm']['Email'], 0, 255));
				$mail->setSender(substr($this->request->post['iContactForm']['Name'], 0, 255));
				$mail->setSubject($config['EmailSubject']);
				$mail->setText(strip_tags(substr($this->request->post['iContactForm']['Message'], 0, $val)));
				$mail->send();
					
				$data['flash'] = '<div class="flashmessage">'.$config['LabelSuccess'].'</div>';
			}
		}
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_twitter($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_facebook($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function column_youtube($setting) {
		$data['idata'] = $setting['idata'];
		$data['langcode'] = $setting['langcode'];
		
		if(version_compare(VERSION, '2.2.0.0', "<")) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/icustomfooter/' . __FUNCTION__ . '.tpl')) {
				return $this->load->view($this->config->get('config_template').'/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			} else {
				return $this->load->view('default/template/module/icustomfooter/' . __FUNCTION__ . '.tpl', $data);
			}
		} else {
		       return $this->load->view('module/icustomfooter/' . __FUNCTION__, $data);
		 }
	}
	
	public function captcha() {
		$this->load->model('module/icustomfooter');
		
		if(VERSION < '2.1.0.0') {
			$this->load->library('icustomfooter_captcha');
		}
		
		$captcha = new icustomfooter_captcha();
		
		$this->session->data['icustomfooter_captcha'] = $captcha->getCode();
		
		$data = $this->model_module_icustomfooter->getSetting('icustomfooter', $this->config->get('config_store_id'));
		
		if (!empty($data['icustomfooter'])) {
			$data = $data['icustomfooter'];
		}
		
		if ($data['Settings']['BackgroundPattern'] == 'flatfooterlayout') {
			$escape = array(255, 255, 255);
			$transparent = true;
		} else if ($data['Settings']['BackgroundPattern'] == 'whitebgpattern') {
			$escape = array(255, 255, 255);
			$transparent = true;
		} else if ($data['Settings']['BackgroundPattern'] == 'darkbgpattern') {
			$escape = array(0, 0, 0);
			$transparent = true;
		} else {
			$escape = $this->hex2rgb($data['Settings']['BackgroundColor']);
			$transparent = false;
		}
		
		$captcha->showImage($escape, $transparent);
	}
	
	public function hex2rgb($hex) { // from http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}
}
?>