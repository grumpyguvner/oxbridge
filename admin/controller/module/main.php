<?php
class ControllerModuleMain extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('module/main');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('main', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
	
		$data['entry_status'] = $this->language->get('entry_status');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled']	= $this->language->get('text_enabled');
		$data['text_disabled']	= $this->language->get('text_disabled');
		
		$data['text_support'] = $this->language->get('text_support');
		$data['text_need_support'] = $this->language->get('text_need_support');
		$data['text_follow'] = $this->language->get('text_follow');
		$data['entry_mail_name'] = $this->language->get('entry_mail_name');
		$data['entry_mail_order_id'] = $this->language->get('entry_mail_order_id');
		$data['entry_mail_message'] = $this->language->get('entry_mail_message');
		$data['entry_mail_email'] = $this->language->get('entry_mail_email');
		$data['button_mail'] = $this->language->get('button_mail');
		$data['button_review'] = $this->language->get('button_review');
		$data['button_purchase'] = $this->language->get('button_purchase');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_about'] = $this->language->get('tab_about');
		        
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
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
			'href'      => $this->url->link('module/main', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$data['action'] = $this->url->link('module/main', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['token'] = $this->session->data['token'];
		
		if (isset($this->request->post['main_image_status'])) { 
			$data['main_image_status'] = $this->request->post['main_image_status']; 
		} else { 
			$data['main_image_status'] = $this->config->get('main_image_status');
		} 
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/main.tpl', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/main')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install() {
		$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product");
		$exists = false;
		
		foreach ($query->rows as $result) {
			if ($result['Field'] == 'main_image') {
				$exists = true;
				break;
			}
		}
		
		if (!$exists) {		
			$this->db->query("ALTER TABLE " . DB_PREFIX . "product ADD main_image varchar(255) NULL AFTER image");
		}
	}
	
	public function uninstall() {
		$query = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product");
		$exists = false;
		
		foreach ($query->rows as $result) {
			if ($result['Field'] == 'main_image') {
				$exists = true;
				break;
			}
		}
		
		if ($exists) {
			$this->db->query("ALTER TABLE " . DB_PREFIX . "product DROP main_image");
		}
	}
	
	public function mail() {
		$this->language->load('module/main');
		
		$json = array();
		
		if ($this->validate()) {
			if (strlen($this->request->post['mail_name']) < 3 || strlen($this->request->post['mail_name']) > 16) {
				$json['error']['name'] = $this->language->get('mail_error_name');
			}
			
			if ((strlen($this->request->post['mail_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['mail_email'])) {
				$json['error']['email'] = $this->language->get('mail_error_email');
			}
			
			if (strlen($this->request->post['mail_order_id']) < 3 || (int)$this->request->post['mail_order_id'] == 0) {
				$json['error']['order_id'] = $this->language->get('mail_error_order_id');
			}
			
			if (strlen($this->request->post['mail_message']) < 20 || strlen($this->request->post['mail_message']) > 2400) {
				$json['error']['message'] = $this->language->get('mail_error_message');
			}
		
			if (!$json) {
				$subject = '[Main Image] Support ' . $this->request->post['mail_name'];
				
				$message = 'Order ID: ' . $this->request->post['mail_order_id'] . "\n\n";
				$message .= $this->request->post['mail_message'];
				
				if (version_compare(VERSION, '2.0.2.0', '<')) {
					$mail = new Mail($this->config->get('config_mail'));
				} else {
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_host');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
				}
				
				$mail->setTo('support@marketinsg.com');
				$mail->setFrom($this->request->post['mail_email']);
				$mail->setSender($this->request->post['mail_name']);
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();
				
				$json['success'] = $this->language->get('mail_success');
			}
		} else {
			$json['error']['warning'] = $this->error['warning'];
		}
		
		$this->response->setOutput(json_encode($json));	
	}
}