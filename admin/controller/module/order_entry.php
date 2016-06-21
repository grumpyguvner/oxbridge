<?php

class ControllerModuleOrderEntry extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/order_entry');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/order_entry');
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('oe', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_not_required'] = $this->language->get('text_not_required');
		$data['text_required'] = $this->language->get('text_required');
		$data['text_installed_modules'] = $this->language->get('text_installed_modules');
		$data['text_oe_settings'] = $this->language->get('text_oe_settings');
		$data['text_no_modules'] = $this->language->get('text_no_modules');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_pricet'] = $this->language->get('text_pricet');
		$data['text_total'] = $this->language->get('text_total');
		$data['text_totalt'] = $this->language->get('text_totalt');
		$data['text_notax'] = $this->language->get('text_notax');
		$data['text_tab_form'] = $this->language->get('text_tab_form');
		$data['text_one_form'] = $this->language->get('text_one_form');
		$data['text_maintenance'] = $this->language->get('text_maintenance');
		$data['text_update_orders'] = $this->language->get('text_update_orders');
		$data['entry_require_telephone'] = $this->language->get('entry_require_telephone');
		$data['entry_require_email'] = $this->language->get('entry_require_email');
		$data['entry_require_city'] = $this->language->get('entry_require_city');
		$data['entry_require_zone'] = $this->language->get('entry_require_zone');
		$data['entry_product_columns'] = $this->language->get('entry_product_columns');
		$data['entry_form_type'] = $this->language->get('entry_form_type');
		$data['column_module_name'] = $this->language->get('column_module_name');
		$data['column_module_status'] = $this->language->get('column_module_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['help_product_columns'] = $this->language->get('help_product_columns');
		$data['help_form_type'] = $this->language->get('help_form_type');
		$data['tab_general_settings'] = $this->language->get('tab_general_settings');
		$data['tab_customer_settings'] = $this->language->get('tab_customer_settings');
		$data['tab_product_settings'] = $this->language->get('tab_product_settings');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_update_orders'] = $this->language->get('button_update_orders');
		$data['button_cancel'] = $this->language->get('button_cancel');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} elseif (isset($this->session->data['error_oe'])) {
			$data['error_warning'] = $this->session->data['error_oe'];
			unset($this->session->data['error_oe']);
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/order_entry', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['action'] = $this->url->link('module/order_entry', 'token=' . $this->session->data['token'], 'SSL');
		$data['update_orders'] = $this->url->link('module/order_entry/updateOrders', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->post['oe_form_type'])) {
			$data['oe_form_type'] = $this->request->post['oe_form_type'];
		} else {
			$data['oe_form_type'] = $this->config->get('oe_form_type');
		}
		if (isset($this->request->post['oe_require_telephone'])) {
			$data['oe_require_telephone'] = $this->request->post['oe_require_telephone'];
		} else {
			$data['oe_require_telephone'] = $this->config->get('oe_require_telephone');
		}
		if (isset($this->request->post['oe_require_email'])) {
			$data['oe_require_email'] = $this->request->post['oe_require_email'];
		} else {
			$data['oe_require_email'] = $this->config->get('oe_require_email');
		}
		if (isset($this->request->post['oe_require_city'])) {
			$data['oe_require_city'] = $this->request->post['oe_require_city'];
		} else {
			$data['oe_require_city'] = $this->config->get('oe_require_city');
		}
		if (isset($this->request->post['oe_require_zone'])) {
			$data['oe_require_zone'] = $this->request->post['oe_require_zone'];
		} else {
			$data['oe_require_zone'] = $this->config->get('oe_require_zone');
		}
		if (isset($this->request->post['oe_product_columns'])) {
			$data['oe_product_columns'] = $this->request->post['oe_product_columns'];
		} else {
			$data['oe_product_columns'] = $this->config->get('oe_product_columns');
			if (!is_array($data['oe_product_columns'])) {
				$data['oe_product_columns'] = array();
			}
		}
		$data['oe_modules'] = array();
		$results = $this->model_sale_order_entry->getModules();
		foreach ($results as $result) {
			$action = array();
			if ($this->config->get($result['module_code'] . '_status')) {
				$status = $this->language->get('text_enabled');
				$action[] = array(
					'text'	=> $this->language->get('text_disable'),
					'href'	=> $this->url->link('module/order_entry/disable', 'token=' . $this->session->data['token'] . '&module_id=' . $result['oe_module_id'], 'SSL')
				);
			} else {
				$status = $this->language->get('text_disabled');
				$action[] = array(
					'text'	=> $this->language->get('text_enable'),
					'href'	=> $this->url->link('module/order_entry/enable', 'token=' . $this->session->data['token'] . '&module_id=' . $result['oe_module_id'], 'SSL')
				);
			}
			$data['oe_modules'][] = array(
				'module_id'	=> $result['oe_module_id'],
				'name'		=> $result['module_name'],
				'status'	=> $status,
				'action'	=> $action
			);
		}
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/order_entry.tpl', $data));
	}

	public function enable() {
		$this->load->language('module/order_entry');
		if (isset($this->request->get['module_id']) && $this->validate()) {
			$this->load->model('sale/order_entry');
			$result = $this->model_sale_order_entry->enable($this->request->get['module_id']);
			if ($result == 1) {
				$this->session->data['success'] = $this->language->get('text_enable_success');
			} else {
				$this->session->data['error_oe'] = $this->language->get('error_module_id');
			}
		} else {
			$this->session->data['error_oe'] = $this->language->get('error_permission');
		}
		$this->response->redirect($this->url->link('module/order_entry', 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	public function disable() {
		$this->load->language('module/order_entry');
		if (isset($this->request->get['module_id']) && $this->validate()) {
			$this->load->model('sale/order_entry');
			$result = $this->model_sale_order_entry->disable($this->request->get['module_id']);
			if ($result == 1) {
				$this->session->data['success'] = $this->language->get('text_disable_success');
			} else {
				$this->session->data['error_oe'] = $this->language->get('error_module_id');
			}
		} else {
			$this->session->data['error_oe'] = $this->language->get('error_permission');
		}
		$this->response->redirect($this->url->link('module/order_entry', 'token=' . $this->session->data['token'], 'SSL'));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/order_entry')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function updateOrders() {
		$this->load->language('module/order_entry');
		$this->load->model('sale/order_entry');
		$this->model_sale_order_entry->updateOrders();
		$this->session->data['success'] = $this->language->get('text_update_orders_success');
		$this->response->redirect($this->url->link('module/order_entry', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function install() {
		$this->load->model('sale/order_entry');
		$this->model_sale_order_entry->install();
		return;
	}

	public function uninstall() {
		$this->load->model('sale/order_entry');
		$this->model_sale_order_entry->uninstall();
		return;
	}

}