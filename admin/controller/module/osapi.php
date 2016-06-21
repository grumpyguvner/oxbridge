<?php
/*
  osapi.php

  OneSaas Connect API 2.0.0.11 for OpenCart v2.0
  http://www.onesaas.com

  Copyright (c) 2012 OneSaas

*/
class ControllerModuleOsapi extends Controller {
	private $error = array();
	private $os_version = '2.0.0.11';

	public function index() {
		$this->load->language('module/osapi');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		// Check if plugin is initialised
		$ak_query = $this->db->query("select s.key from " . DB_PREFIX . "setting s where s.key = 'OSAPI_ACCESS_KEY' and s.code='OSAPI'");
		if ($ak_query->num_rows == 0) {
			// Inizialise AccessKey
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting VALUES (NULL, 0, 'OSAPI', 'OSAPI_ACCESS_KEY', CONCAT(MD5(NOW()), MD5(CURTIME())), 0)");
			// Inizialise Version
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting VALUES (NULL, 0, 'OSAPI', 'OSAPI_VERSION', '" . $this->os_version . "', 0)");
			// Create table osapi_last_modified if it does not exist
			$this->db->query("create table if not exists " . DB_PREFIX . "osapi_last_modified (object_type ENUM('product','customer') NOT NULL, id INT(11) NOT NULL, hash VARCHAR(255) not null, last_modified_before DATETIME NOT NULL, PRIMARY KEY(object_type, id)) Engine=MyISAM DEFAULT CHARSET UTF8");
		}
		// Check Version
		$version_query = $this->db->query("select s.value from " . DB_PREFIX . "setting s where s.key = 'OSAPI_VERSION' and s.code='OSAPI'");
			if ($version_query->num_rows == 0) {
				// Initialise OneSaas Connect Plugin Version
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting VALUES (NULL, 0, 'OSAPI', 'OSAPI_VERSION', '" . $this->os_version . "', 0)");
			} else {
				// Check Version is current or we need to update it (in case of upgrade)
				$version = $version_query->row['value'];
				if ($version != $this->os_version) {
					$this->db->query("UPDATE " . DB_PREFIX . "setting s SET s.value='" . $this->os_version . "' where s.key = 'OSAPI_VERSION' and s.code='OSAPI'");
				}
		}
		// Read AccessKey
		$ak = '';
		$ak_query = $this->db->query("select s.value from " . DB_PREFIX . "setting s where s.key = 'OSAPI_ACCESS_KEY' and s.code='OSAPI'");
		if ($ak_query->num_rows == 1) {
			$ak = $ak_query->row['value'];
		}		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('osapi', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['configkey'] = base64_encode(json_encode(array('ApiUrl' => HTTP_CATALOG, 'ApiToken' => $ak)));
		$data['os_version'] = $this->os_version;

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_info'] = $this->language->get('entry_info');
		$data['entry_key'] = $this->language->get('entry_key');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('module/osapi', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['action'] = $this->url->link('module/osapi', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['osapi_status'])) {
			$data['osapi_status'] = $this->request->post['osapi_status'];
		} else {
			$data['osapi_status'] = $this->config->get('osapi_status');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/osapi.tpl', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/osapi')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;		
	}		
}	
?>
