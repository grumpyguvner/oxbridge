<?php

class ControllerSaleOrderEntry extends Controller {
	private $error = array();

	public function add() {
		$this->load->language('sale/order');
		$this->load->language('sale/order_entry');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		unset($this->session->data['cookie']);
		if ($this->validate()) {
			$this->load->model('user/api');
			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));
			if ($api_info) {
				$curl = curl_init();
				if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
					curl_setopt($curl, CURLOPT_PORT, 443);
				}
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));
				$json = curl_exec($curl);
				if (!$json) {
					$this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
				} else {
					$response = json_decode($json, true);
					if (isset($response['cookie'])) {
						$this->session->data['cookie'] = $response['cookie'];
					}
					curl_close($curl);
				}
			}
		}
		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/order');
		$this->load->language('sale/order_entry');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order');
		unset($this->session->data['cookie']);
		if ($this->validate()) {
			$this->load->model('user/api');
			$api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));
			if ($api_info) {
				$curl = curl_init();
				if (substr(HTTPS_CATALOG, 0, 5) == 'https') {
					curl_setopt($curl, CURLOPT_PORT, 443);
				}
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLINFO_HEADER_OUT, true);
				curl_setopt($curl, CURLOPT_USERAGENT, $this->request->server['HTTP_USER_AGENT']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, HTTPS_CATALOG . 'index.php?route=api/login');
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($api_info));
				$json = curl_exec($curl);
				if (!$json) {
					$this->error['warning'] = sprintf($this->language->get('error_curl'), curl_error($curl), curl_errno($curl));
				} else {
					$response = json_decode($json, true);
					if (isset($response['cookie'])) {
						$this->session->data['cookie'] = $response['cookie'];
					}
					curl_close($curl);
				}
			}
		}
		$this->getForm();
	}

	public function getForm() {
		$this->load->model('sale/customer');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = !isset($this->request->get['order_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_ip_add'] = sprintf($this->language->get('text_ip_add'), $this->request->server['REMOTE_ADDR']);
		$data['text_order'] = $this->language->get('text_order');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_currency'] = $this->language->get('text_currency');
		$data['text_payment_address'] = $this->language->get('text_payment_address');
		$data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$data['text_order_id'] = $this->language->get('text_order_id');
		$data['text_customer_group'] = $this->language->get('text_customer_group');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_email_exists'] = $this->language->get('text_email_exists');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_save_customer'] = $this->language->get('text_save_customer');
		$data['text_notify_customer'] = $this->language->get('text_notify_customer');
		$data['text_save_address'] = $this->language->get('text_save_address');
		$data['text_company'] = $this->language->get('text_company');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_address_1'] = $this->language->get('text_address_1');
		$data['text_address_2'] = $this->language->get('text_address_2');
		$data['text_address_3'] = $this->language->get('text_address_3');
		$data['text_country'] = $this->language->get('text_country');
		$data['text_shipping_same_payment'] = $this->language->get('text_shipping_same_payment');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_order_detail'] = $this->language->get('text_order_detail');
		$data['text_add_product'] = $this->language->get('text_add_product');
		$data['text_add_voucher'] = $this->language->get('text_add_voucher');
		$data['text_products'] = $this->language->get('text_products');
		$data['text_order_options'] = $this->language->get('text_order_options');
		$data['text_order_options2'] = $this->language->get('text_order_options2');
		$data['text_order_totals'] = $this->language->get('text_order_totals');
		$data['text_customer_error'] = $this->language->get('text_customer_error');
		$data['text_order_error'] = $this->language->get('text_order_error');
		$data['text_product_error'] = $this->language->get('text_product_error');
		$data['text_please_wait'] = $this->language->get('text_please_wait');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_zone_code'] = $this->language->get('entry_zone_code');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_notax'] = $this->language->get('entry_notax');
		$data['entry_custom_price'] = $this->language->get('entry_custom_price');
		$data['entry_to_name'] = $this->language->get('entry_to_name');
		$data['entry_to_email'] = $this->language->get('entry_to_email');
		$data['entry_from_name'] = $this->language->get('entry_from_name');
		$data['entry_from_email'] = $this->language->get('entry_from_email');
		$data['entry_theme'] = $this->language->get('entry_theme');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_add_customer'] = $this->language->get('entry_add_customer');
		$data['entry_shipping_method'] = $this->language->get('entry_shipping_method');
		$data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$data['entry_coupon'] = $this->language->get('entry_coupon');
		$data['entry_voucher'] = $this->language->get('entry_voucher');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_custom_shipping_title'] = $this->language->get('entry_custom_shipping_title');
		$data['entry_custom_shipping_cost'] = $this->language->get('entry_custom_shipping_cost');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_option'] = $this->language->get('column_option');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_price_t'] = $this->language->get('column_price_t');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_total_t'] = $this->language->get('column_total_t');
		$data['column_notax'] = $this->language->get('column_notax');
		$data['column_action'] = $this->language->get('column_action');
		$data['help_product_autocomplete'] = $this->language->get('help_product_autocomplete');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_refresh'] = $this->language->get('button_refresh');
		$data['button_product_add'] = $this->language->get('button_product_add');
		$data['button_voucher_add'] = $this->language->get('button_voucher_add');
		$data['button_apply'] = $this->language->get('button_apply');
		$data['button_upload'] = $this->language->get('button_upload');
		$data['button_update'] = $this->language->get('button_update');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_custom_shipping_apply'] = $this->language->get('button_custom_shipping_apply');
		$data['tab_order'] = $this->language->get('tab_order');
		$data['tab_customer'] = $this->language->get('tab_customer');
		$data['tab_payment'] = $this->language->get('tab_payment');
		$data['tab_shipping'] = $this->language->get('tab_shipping');
		$data['tab_product'] = $this->language->get('tab_product');
		$data['tab_voucher'] = $this->language->get('tab_voucher');
		$data['tab_total'] = $this->language->get('tab_total');
		$data['token'] = $this->session->data['token'];
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$data['oe_require_email'] = $this->config->get('oe_require_email');
		$data['oe_require_telephone'] = $this->config->get('oe_require_telephone');
		$data['oe_require_city'] = $this->config->get('oe_require_city');
		$data['oe_require_zone'] = $this->config->get('oe_require_zone');
		$data['product_column_option'] = 0;
		$data['product_column_price'] = 0;
		$data['product_column_pricet'] = 0;
		$data['product_column_total'] = 0;
		$data['product_column_totalt'] = 0;
		$data['product_column_notax'] = 0;
		$prod_cols = $this->config->get('oe_product_columns');
		if (is_array($prod_cols)) {
			if (in_array('option', $prod_cols)) {
				$data['product_column_option'] = 1;
			}
			if (in_array('price', $prod_cols)) {
				$data['product_column_price'] = 1;
			}
			if (in_array('pricet', $prod_cols)) {
				$data['product_column_pricet'] = 1;
			}
			if (in_array('total', $prod_cols)) {
				$data['product_column_total'] = 1;
			}
			if (in_array('totalt', $prod_cols)) {
				$data['product_column_totalt'] = 1;
			}
			if (in_array('notax', $prod_cols)) {
				$data['product_column_notax'] = 1;
			}
		}
		$url = '';
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		$data['cancel'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL');
		if (isset($this->request->get['order_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
		}
		if (!empty($order_info)) {
			$data['order_id'] = $this->request->get['order_id'];
			$data['order_balance'] = $order_info['total'];
			$data['store_id'] = $order_info['store_id'];
			$data['store_name'] = $order_info['store_name'];
			$this->load->model('localisation/currency');
			$currency_info = $this->model_localisation_currency->getCurrency($order_info['currency_id']);
			if ($currency_info['symbol_left']) {
				$data['currency_info'] = '( ' . $currency_info['symbol_left'] . ' ) ' . $currency_info['title'];
			} else {
				$data['currency_info'] = '( ' . $currency_info['symbol_right'] . ' ) ' . $currency_info['title'];
			}
			$data['customer'] = $order_info['customer'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['customer_group_id'] = $order_info['customer_group_id'];
			$this->load->model('sale/customer_group');
			$customer_group = $this->model_sale_customer_group->getCustomerGroup($order_info['customer_group_id']);
			$data['customer_group'] = $customer_group['name'];
			$data['firstname'] = $order_info['firstname'];
			$data['lastname'] = $order_info['lastname'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['fax'] = $order_info['fax'];
			$data['account_custom_field'] = $order_info['custom_field'];
			$data['addresses'] = $this->model_sale_customer->getAddresses($order_info['customer_id']);
			$data['payment_firstname'] = $order_info['payment_firstname'];
			$data['payment_lastname'] = $order_info['payment_lastname'];
			$data['payment_company'] = $order_info['payment_company'];
			$data['payment_address_1'] = $order_info['payment_address_1'];
			$data['payment_address_2'] = $order_info['payment_address_2'];
			$data['payment_city'] = $order_info['payment_city'];
			$data['payment_postcode'] = $order_info['payment_postcode'];
			$data['payment_country_id'] = $order_info['payment_country_id'];
			$data['payment_country'] = $order_info['payment_country'];
			$data['payment_zone_id'] = $order_info['payment_zone_id'];
			$data['payment_zone'] = $order_info['payment_zone'];
			$data['payment_custom_field'] = $order_info['payment_custom_field'];
			$data['payment_method'] = $order_info['payment_method'];
			$data['payment_code'] = $order_info['payment_code'];
			$data['shipping_firstname'] = $order_info['shipping_firstname'];
			$data['shipping_lastname'] = $order_info['shipping_lastname'];
			$data['shipping_company'] = $order_info['shipping_company'];
			$data['shipping_address_1'] = $order_info['shipping_address_1'];
			$data['shipping_address_2'] = $order_info['shipping_address_2'];
			$data['shipping_city'] = $order_info['shipping_city'];
			$data['shipping_postcode'] = $order_info['shipping_postcode'];
			$data['shipping_country_id'] = $order_info['shipping_country_id'];
			$data['shipping_country'] = $order_info['shipping_country'];
			$data['shipping_zone_id'] = $order_info['shipping_zone_id'];
			$data['shipping_zone'] = $order_info['shipping_zone'];
			$data['shipping_custom_field'] = $order_info['shipping_custom_field'];
			$data['shipping_method'] = $order_info['shipping_method'];
			if ($order_info['shipping_code']) {
				$data['shipping_code'] = $order_info['shipping_code'];
			} else {
				$data['shipping_code'] = 'custom.custom';
			}
			// Products
			$data['order_products'] = array();
			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);
			foreach ($products as $product) {
				$notax = 0;
				$custom_product = 0;
				$oe_product_info = $this->model_sale_order->getOeOrderProducts($this->request->get['order_id'], $product['order_product_id']);
				if ($oe_product_info) {
					$custom_product = $oe_product_info['custom_product'];
					$notax = $oe_product_info['notax'];
				}
				$data['order_products'][] = array(
					'product_id'		=> $product['product_id'],
					'name'				=> $product['name'],
					'model'				=> $product['model'],
					'option'			=> $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']),
					'quantity'			=> $product['quantity'],
					'price'				=> $product['price'],
					'total'				=> $product['total'],
					'notax'				=> $notax,
					'custom_product'	=> $custom_product,
					'reward'			=> $product['reward']
				);
			}
			// Vouchers
			$data['order_vouchers'] = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);
			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
			$data['store_credit'] = '';
			$data['order_totals'] = array();
			$order_totals = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);
			foreach ($order_totals as $order_total) {
				// If coupon, voucher or reward points
				$start = strpos($order_total['title'], '(') + 1;
				$end = strrpos($order_total['title'], ')');
				if ($start && $end) {
					if ($order_total['code'] == 'coupon') {
						$data['coupon'] = substr($order_total['title'], $start, $end - $start);
					}
					if ($order_total['code'] == 'voucher') {
						$data['voucher'] = substr($order_total['title'], $start, $end - $start);
					}
					if ($order_total['code'] == 'reward') {
						$data['reward'] = substr($order_total['title'], $start, $end - $start);
					}
				}
				if ($order_total['code'] == 'credit') {
					$data['store_credit'] = -$order_total['value'];
				}
			}
			$data['order_status_id'] = $order_info['order_status_id'];
			$data['comment'] = $order_info['comment'];
			$data['affiliate_id'] = $order_info['affiliate_id'];
			$data['affiliate'] = $order_info['affiliate_firstname'] . ' ' . $order_info['affiliate_lastname'];
			$data['currency_code'] = $order_info['currency_code'];
		} else {
			$data['order_id'] = 0;
			$data['new_order'] = $this->language->get('text_new_order');
			$data['order_balance'] = 0;
			$data['store_id'] = '';
			$data['store_name'] = '';
			$data['currency_info'] = '';
			$data['customer'] = '';
			$data['customer_id'] = '';
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
			$data['customer_group'] = '';
			$data['firstname'] = '';
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = '';
			$data['fax'] = '';
			$data['customer_custom_field'] = array();
			$data['addresses'] = array();
			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_company'] = '';
			$data['payment_address_1'] = '';
			$data['payment_address_2'] = '';
			$data['payment_city'] = '';
			$data['payment_postcode'] = '';
			$data['payment_country_id'] = $this->config->get('config_country_id');
			$data['payment_country'] = '';
			$data['payment_zone_id'] = '';
			$data['payment_zone'] = '';
			$data['payment_custom_field'] = array();
			$data['payment_method'] = '';
			$data['payment_code'] = '';
			$data['shipping_firstname'] = '';
			$data['shipping_lastname'] = '';
			$data['shipping_company'] = '';
			$data['shipping_address_1'] = '';
			$data['shipping_address_2'] = '';
			$data['shipping_city'] = '';
			$data['shipping_postcode'] = '';
			$data['shipping_country_id'] = '';
			$data['shipping_country'] = '';
			$data['shipping_zone_id'] = '';
			$data['shipping_zone'] = '';
			$data['shipping_custom_field'] = array();
			$data['shipping_method'] = '';
			$data['shipping_code'] = '';
			$data['order_products'] = array();
			$data['order_vouchers'] = array();
			$data['order_totals'] = array();
			$data['order_status_id'] = $this->config->get('config_order_status_id');
			$data['comment'] = '';
			$data['affiliate_id'] = '';
			$data['affiliate'] = '';
			$data['currency_code'] = $this->config->get('config_currency');
			$data['coupon'] = '';
			$data['voucher'] = '';
			$data['reward'] = '';
			$data['store_credit'] = '';
		}
		// Stores
		$this->load->model('setting/store');
		$data['stores'] = array();
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default'),
			'href'     => $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG
		);
		$results = $this->model_setting_store->getStores();
		foreach ($results as $result) {
			$data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'href'     => $this->request->server['HTTPS'] ? str_replace("http", "https", $result['url']) : $result['url']
			);
		}
		// Customer Groups
		$this->load->model('sale/customer_group');
		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		// Custom Fields
		$this->load->model('sale/custom_field');
		$data['custom_fields'] = array();
		$filter_data = array(
			'sort'  => 'cf.sort_order',
			'order' => 'ASC'
		);
		$custom_fields = $this->model_sale_custom_field->getCustomFields($filter_data);
		foreach ($custom_fields as $custom_field) {
			$data['custom_fields'][] = array(
				'custom_field_id'    => $custom_field['custom_field_id'],
				'custom_field_value' => $this->model_sale_custom_field->getCustomFieldValues($custom_field['custom_field_id']),
				'name'               => $custom_field['name'],
				'value'              => $custom_field['value'],
				'type'               => $custom_field['type'],
				'location'           => $custom_field['location'],
				'sort_order'         => $custom_field['sort_order']
			);
		}
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();
		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();
		$data['voucher_min'] = $this->config->get('config_voucher_min');
		$this->load->model('sale/voucher_theme');
		$data['voucher_themes'] = $this->model_sale_voucher_theme->getVoucherThemes();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		if ($this->config->get('oe_form_type') == 'tab') {
			$data['one_page_form'] = 0;
			$this->response->setOutput($this->load->view('sale/order_entry_tab_form.tpl', $data));
		} else {
			$data['one_page_form'] = 1;
			$this->response->setOutput($this->load->view('sale/order_entry_one_form.tpl', $data));
		}
	}

	public function checkEmail() {
		$this->load->model('sale/order_entry');
		$result = $this->model_sale_order_entry->checkEmail($this->request->get['email']);
		if ($result) {
			$json = "exists";
		} else {
			$json = "new";
		}
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();
		$this->load->model('sale/order_entry');
		$this->load->model('catalog/product');
		$this->load->model('catalog/option');
		$filter_name = $this->request->get['filter_name'];
		$limit = 10;
		$filter_data = array(
			'name'	=> $filter_name,
			'start'	=> 0,
			'limit'	=> 10
		);
		$results = $this->model_sale_order_entry->getProducts($filter_data);
		foreach ($results as $result) {
			$option_data = array();
			$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);
			foreach ($product_options as $product_option) {
				$option_info = $this->model_catalog_option->getOption($product_option['option_id']);
				if ($option_info) {
					$product_option_value_data = array();
					foreach ($product_option['product_option_value'] as $product_option_value) {
						$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);
						if ($option_value_info) {
							$product_option_value_data[] = array(
								'product_option_value_id' => $product_option_value['product_option_value_id'],
								'option_value_id'         => $product_option_value['option_value_id'],
								'name'                    => $option_value_info['name'],
								'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
								'price_prefix'            => $product_option_value['price_prefix']
							);
						}
					}
					$option_data[] = array(
						'product_option_id'    => $product_option['product_option_id'],
						'product_option_value' => $product_option_value_data,
						'option_id'            => $product_option['option_id'],
						'name'                 => $option_info['name'],
						'type'                 => $option_info['type'],
						'value'                => $product_option['value'],
						'required'             => $product_option['required']
					);
				}
			}
			$json[] = array(
				'product_id'	=> $result['product_id'],
				'name'			=> strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				'model'			=> $result['model'],
				'sku'			=> $result['sku'],
				'option'		=> $option_data,
				'price'			=> $result['price']
			);
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function clearOrderEntry() {
		unset($this->session->data['oe']);
		$this->response->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'sale/order_entry')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

}