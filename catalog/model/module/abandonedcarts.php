<?php
class ModelModuleAbandonedcarts extends Model {
	public function getStores($data = array()) {
		$store_data = $this->cache->get('store');

		if (!$store_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY url");
			$store_data = $query->rows;
			$this->cache->set('store', $store_data);
		}
		return $store_data;
	}
	
	public function getStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->getStoreData($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL();
        }
        return $store;
    }
	
	private function getStoreData($store_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "store WHERE store_id = '" . (int)$store_id . "'");

		return $query->row;
	}
	
	private function getCatalogURL(){
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTP_SERVER;
        } else {
            $storeURL = HTTPS_SERVER;
        } 
        return $storeURL;
    }
	
	public function getCartInfo($id) {	
		$query =  $this->db->query("SELECT * FROM `" . DB_PREFIX . "abandonedcarts`
			WHERE `id`=".$id);
		
		return $query->row; 
	}
		
	public function generateuniquerandomcouponcode() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$couponCode = '';
		for ($i = 0; $i < 10; $i++) {	
			$couponCode .= $characters[rand(0, strlen($characters) - 1)]; 
		}
		if($this->isUniqueCode($couponCode)) {	
			return $couponCode;
		} else {	
			return $this->generateuniquerandomcouponcode();
		}
	}
	
	public function isUniqueCode($randomCode) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE code='".$this->db->escape($randomCode)."'");
		if($query->num_rows == 0) {
			return true;
					} else {
			return false;
		}	
	}
	
	public function addCoupon($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', discount = '" . (float)$data['discount'] . "', type = '" . $this->db->escape($data['type']) . "', total = '" . (float)$data['total'] . "', logged = '" . (int)$data['logged'] . "', shipping = '" . (int)$data['shipping'] . "', date_start = '" . $this->db->escape($data['date_start']) . "', date_end = '" . $this->db->escape($data['date_end']) . "', uses_total = '" . (int)$data['uses_total'] . "', uses_customer = '" . (int)$data['uses_customer'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");

		$coupon_id = $this->db->getLastId();

		if (isset($data['coupon_product'])) {
			foreach ($data['coupon_product'] as $product_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_product SET coupon_id = '" . (int)$coupon_id . "', product_id = '" . (int)$product_id . "'");
			}
		}

		if (isset($data['coupon_category'])) {
			foreach ($data['coupon_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_category SET coupon_id = '" . (int)$coupon_id . "', category_id = '" . (int)$category_id . "'");
			}
		}		
	}
	
	public function sendMail($data = array()) {
		$this->load->model('module/abandonedcarts');
		$this->load->model('setting/setting');	
		
		if (VERSION < '2.0.2.0') {
			$mailToUser = new Mail($this->config->get('config_mail'));
		} else {
			$mailToUser = new Mail();
			$mailToUser->protocol = $this->config->get('config_mail_protocol');
			$mailToUser->parameter = $this->config->get('config_mail_parameter');
			$mailToUser->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mailToUser->smtp_username = $this->config->get('config_mail_smtp_username');
			$mailToUser->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mailToUser->smtp_port = $this->config->get('config_mail_smtp_port');
			$mailToUser->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		}
		$mailToUser->setTo($data['email']);
		$mailToUser->setFrom($this->config->get('config_email'));
		$mailToUser->setSender($this->config->get('config_name'));
		$mailToUser->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
		$mailToUser->setHtml($data['message']);
		
		$abandonedCartsSettings = $this->model_setting_setting->getSetting('AbandonedCarts', $data['store_id']);
		if(isset($abandonedCartsSettings['abandonedcarts']['BCC']) && $abandonedCartsSettings['abandonedcarts']['BCC'] == 'yes') { 
			$mailToUser->setAbandonedCartsBcc($this->config->get('config_email'));
		}
		
		$mailToUser->send();
		 
		if ($mailToUser) 
		return true;
			else
		return false;
	}
	
	public function getCarts($dayLimit) {
		if ($dayLimit == 0) {
			$query =  $this->db->query("SELECT * FROM `" . DB_PREFIX . "abandonedcarts` 
				WHERE `notified`=0 AND `ordered`=0");
		} else {
			$query =  $this->db->query("SELECT * FROM `" . DB_PREFIX . "abandonedcarts` 
				WHERE DATE(`date_modified`) = '".date("Y-m-d ",strtotime('-'.$dayLimit.' days'))."' AND `ordered`=0");
		}
		
		return $query->rows; 
	} 
	
	public function getLanguageId($language_code) {
		$query = $this->db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE code = '" . $language_code . "'");
		return $query->row['language_id'];
	}
}
?>