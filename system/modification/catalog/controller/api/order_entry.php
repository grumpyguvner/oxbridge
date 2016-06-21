<?php

class ControllerApiOrderEntry extends Controller {
	private $error = array();

	public function setStoreCredit() {
		$json = array();
		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if ($this->request->post['store_credit'] > 0) {
				$this->session->data['oe']['store_credit'] = $this->request->post['store_credit'];
			} else {
				unset($this->session->data['oe']['store_credit']);
			}
		}
		
				$this->response->addHeader('Access-Control-Allow-Origin: *');
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getCustomShipping() {
		$json = array();
		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->session->data['oe']['custom_shipping'])) {
				$json['title'] = $this->session->data['oe']['custom_shipping']['title'];
				$json['cost'] = $this->session->data['oe']['custom_shipping']['cost'];
			} else {
				$json['title'] = $this->config->get('oe_custom_shipping_title');
				$json['cost'] = $this->currency->format($this->config->get('oe_custom_cost'), false, false, false);
			}
		}
		
				$this->response->addHeader('Access-Control-Allow-Origin: *');
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function applyCustomShipping() {
		$this->load->language('shipping/oe_custom');
		$json = array();
		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if ($this->request->post['title'] != '' && $this->request->post['cost'] != '') {
				if (isset($this->session->data['shipping_methods'])) {
					$this->session->data['shipping_methods']['oe_custom']['quote']['oe_custom']['title'] = $this->request->post['title'];
					$this->session->data['shipping_methods']['oe_custom']['quote']['oe_custom']['cost'] = $this->request->post['cost'];
					$this->session->data['shipping_methods']['oe_custom']['quote']['oe_custom']['text'] = $this->currency->format($this->tax->calculate($this->request->post['cost'], $this->config->get('oe_custom_tax_class_id'), $this->config->get('config_tax')));
				}
				$this->session->data['oe']['custom_shipping']['title'] = $this->request->post['title'];
				$this->session->data['oe']['custom_shipping']['cost'] = $this->request->post['cost'];
				$json['shipping_methods'] = $this->session->data['shipping_methods'];
			} else {
				unset($this->session->data['oe']['custom_shipping']);
				$json['error']['warning'] = $this->language->get('error_custom_shipping');
			}
		}
		
				$this->response->addHeader('Access-Control-Allow-Origin: *');
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function removeCustomShipping() {
		$this->load->language('shipping/oe_custom');
		$json = array();
		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			if (isset($this->session->data['shipping_methods']) && isset($this->session->data['oe']['custom_shipping'])) {
				$json['title'] = $this->config->get('oe_custom_shipping_title');
				$json['cost'] = $this->currency->format($this->config->get('oe_custom_cost'), false, false, false);

				unset($this->session->data['oe']['custom_shipping']);
				$this->session->data['shipping_methods']['oe_custom']['quote']['oe_custom']['title'] = $this->config->get('oe_custom_shipping_title');
				$this->session->data['shipping_methods']['oe_custom']['quote']['oe_custom']['cost'] = $this->currency->format($this->config->get('oe_custom_cost'), false, false, false);
				$this->session->data['shipping_methods']['oe_custom']['quote']['oe_custom']['text'] = $this->currency->format($this->tax->calculate($this->config->get('oe_custom_cost'), $this->config->get('oe_custom_tax_class_id'), $this->config->get('config_tax')));
			}
			$json['shipping_methods'] = $this->session->data['shipping_methods'];
		}
		
				$this->response->addHeader('Access-Control-Allow-Origin: *');
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function setShippingMethod() {
		$json = array();
		$json['shipping_code'] = '';
		if (isset($this->request->post['shipping_method']) && $this->request->post['shipping_method']) {
			$shipping_method = $this->request->post['shipping_method'];
		} elseif (isset($this->request->get['shipping_method']) && $this->request->get['shipping_method']) {
			$shipping_method = $this->request->get['shipping_method'];
		}
		if (isset($this->session->data['shipping_methods']) && isset($shipping_method)) {
			$shipping = explode('.', $shipping_method);
			if (isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
				$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
				$json['shipping_code'] = $shipping_method;
			}
		}
		
				$this->response->addHeader('Access-Control-Allow-Origin: *');
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function setPaymentMethod() {
		$json = array();
		$json['payment_code'] = '';
		if (isset($this->request->post['payment_method']) && $this->request->post['payment_method']) {
			$payment_method = $this->request->post['payment_method'];
		} elseif (isset($this->request->get['payment_method']) && $this->request->get['payment_method']) {
			$payment_method = $this->request->get['payment_method'];
		}
		if (isset($this->session->data['payment_methods']) && isset($payment_method)) {
			if (isset($this->session->data['payment_methods'][$payment_method])) {
				$this->session->data['payment_method'] = $this->session->data['payment_methods'][$payment_method];
				$json['payment_code'] = $payment_method;
			}
		}
		
				$this->response->addHeader('Access-Control-Allow-Origin: *');
				$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
				$this->response->addHeader('Access-Control-Max-Age: 1000');
				$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
			
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}

?>