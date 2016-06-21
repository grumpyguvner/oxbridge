<?php
class ControllerCommonFooter extends Controller {
			
			/* AbandonedCarts - Begin */
			protected function register_abandonedCarts() {
				$ip = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '*HiddenIP*';
				
				if (isset($this->session->data['abanonedCart_ID']) & !empty($this->session->data['abanonedCart_ID'])) {
					$id = $this->session->data['abanonedCart_ID'];
				} else if ($this->customer->isLogged()) {
					$id = (!empty($this->session->data['abanonedCart_ID'])) ? $this->session->data['abanonedCart_ID'] : $this->customer->getEmail();
				} else {
					$id = (!empty($this->session->data['abanonedCart_ID'])) ? $this->session->data['abanonedCart_ID'] : session_id();
				}

				$exists = $this->db->query("SELECT * FROM `" . DB_PREFIX . "abandonedcarts` WHERE `restore_id` = '$id'");
				$cart = $this->cart->getProducts();
				$store_id = (int)$this->config->get('config_store_id');
				$cart = (!empty($cart)) ? $cart : '';
				
				$lastpage = "$_SERVER[REQUEST_URI]";
				
				$checker = $this->customer->getId();
				if (!empty($checker)) {
					$customer = array(
						'id'=> $this->customer->getId(), 
						'email' => $this->customer->getEmail(),		
						'telephone' => $this->customer->getTelephone(),
						'firstname' => $this->customer->getFirstName(),
						'lastname' => $this->customer->getLastName(),
						'language' => $this->session->data['language']
					);
				} 

				$route = isset($this->request->get['route']) ? $this->request->get['route'] : '';
				if ($route!='checkout/success') {
				  if (empty($exists->row)) {
					  if (!empty($cart)) {
						  if (!isset($customer)) {
							  $customer = array(
								  'language' => $this->session->data['language']
							  );
						  }
						  $cart = json_encode($cart);
						  $customer = (!empty($customer)) ? json_encode($customer) : '';
						  $this->db->query("INSERT INTO `" . DB_PREFIX . "abandonedcarts` SET `cart`='".$this->db->escape($cart)."', `customer_info`='".$this->db->escape($customer)."', `last_page`='$lastpage', `ip`='$ip', `date_created`=NOW(), `date_modified`=NOW(), `restore_id`='".$id."', `store_id`='".$store_id."'");
						  $this->session->data['abanonedCart_ID'] = $id;
					  } 
				  } else {
					  if (!empty($cart)) {
						  $cart = json_encode($cart);
						  $this->db->query("UPDATE `" . DB_PREFIX . "abandonedcarts` SET `cart` = '".$this->db->escape($cart)."', `last_page`='".$this->db->escape($lastpage)."', `date_modified`=NOW() WHERE `restore_id`='$id'");
					  }
					  if (isset($customer)) {
						  $customer = json_encode($customer);
						  $this->db->query("UPDATE `" . DB_PREFIX . "abandonedcarts` SET `customer_info` = '".$this->db->escape($customer)."', `last_page`='".$this->db->escape($lastpage)."', `date_modified`=NOW() WHERE `restore_id`='$id'");
					  }
				  }
				}
			}
			/* AbandonedCarts - End */
			
	public function index() {

				$data['global_path'] = 'catalog/view/theme/' . $this->config->get('config_template') . '/';
				
		$this->load->language('common/footer');

			/* AbandonedCarts - Begin */
			$this->load->model('setting/setting');
			$abandonedCartsSettings = $this->model_setting_setting->getSetting('abandonedcarts', $this->config->get('store_id'));
			if (isset($abandonedCartsSettings['abandonedcarts']['Enabled']) && $abandonedCartsSettings['abandonedcarts']['Enabled']=='yes') { 
				$this->register_abandonedCarts();
			}
			/* AbandonedCarts - End */
			

				$this->load->language('module/cookie');
				
				$text_strings = array(
					'text_before',
					'link_text',
					'text_after',
					'accept_text',
					'cookie_url'
				);
				
				foreach ($text_strings as $text) {
					$data[$text] = $this->language->get($text);
				}
			


			$data['maintenance'] = $this->config->get('config_maintenance');
			
		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
 
			$data['text_account'] = $this->language->get('text_account');
			$data['text_follow'] = $this->language->get('text_follow');
			$data['text_support'] = $this->language->get('text_support');
			$data['text_twi'] = $this->language->get('text_twi');
			$data['text_fb'] = $this->language->get('text_fb');
			$data['text_rss'] = $this->language->get('text_rss');
			$data['text_yt'] = $this->language->get('text_yt');
			

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = '/contact';
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		
			$data['sitemap'] = '/sitemap';
			
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');
 
			$data['address'] = nl2br($this->config->get('config_address'));
			$data['telephone'] = $this->config->get('config_telephone');
			$data['fax'] = $this->config->get('config_fax');
			
			

			if (($data['maintenance']==0)) {
			$data['footer_top'] = $this->load->controller('common/footer_top');
			}
			

$extendedseo = $this->config->get('extendedseo');
		$data['powered'] = sprintf($this->language->get('text_powered'), ((isset($extendedseo['link']))?'<a href="'.$this->config->get('config_url').'">':'').$this->config->get('config_name').'</a>', date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

		
			$this->load->model('setting/setting');
			$icustomfooterconfig = $this->model_setting_setting->getSetting('icustomfooter', $this->config->get('config_store_id'));
			if (!empty($icustomfooterconfig['icustomfooter'])) {
				$icustomfooterconfig = $icustomfooterconfig['icustomfooter'];		
			}

			$data['idata'] = $icustomfooterconfig;
			if ($this->config->get('config_maintenance') && !$this->user->isLogged()) {
				$maintenance_enabled = 1;
			} else {
				$maintenance_enabled = 0;
			}
			
			if (!empty($icustomfooterconfig['Settings']['Show']) && $icustomfooterconfig['Settings']['Show'] == 'true' && $maintenance_enabled == '0') {
				$data['icustomfooter'] = $this->load->controller('module/icustomfooter');

				$langcode = $this->language->get('code');
				if (empty($langcode)) {
					$langcode = !empty($this->request->cookie['language']) ? $this->request->cookie['language'] : 'en';
				}
				
				$data['langcode'] = $langcode;
				
				if (is_dir(DIR_TEMPLATE . $this->config->get('config_template').'/template/module/icustomfooter/')) {
					$data['themefoldername'] = $this->config->get('config_template');
					$data['themepath'] = 'catalog/view/theme/' . $this->config->get('config_template');
				} else {
					$data['themefoldername'] = 'default';
					$data['themepath'] = 'catalog/view/theme/default/';
				}
				
				if ($icustomfooterconfig['Settings']['UseFooterWith'] == 'themefooter') {
					$icustomfooter_tpl = 'common/footer.tpl';
				} else {
					$icustomfooter_tpl = 'module/icustomfooter.tpl';
				}
			} else {
				$icustomfooter_tpl = 'common/footer.tpl';
			}
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/' . $icustomfooter_tpl)) {
				return $this->load->view($this->config->get('config_template') . '/template/' . $icustomfooter_tpl, $data);
			
			
		} else {
			
				return $this->load->view('default/template/' . $icustomfooter_tpl, $data);
			
		}
	}
}