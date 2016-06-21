<?php
#################################################################
## Open Cart Module:  CONTACT US SUPPORT DEPARTAMENTS          ##
##-------------------------------------------------------------##
## Copyright © 2015 MB "Programanija" All rights reserved.     ##
## http://www.opencartextensions.eu						       ##
## http://www.extensionsmarket.com 						       ##
##-------------------------------------------------------------##
## Permission is hereby granted, when purchased, to  use this  ##
## mod on one domain. This mod may not be reproduced, copied,  ##
## redistributed, published and/or sold.				       ##
##-------------------------------------------------------------##
## Violation of these rules will cause loss of future mod      ##
## updates and account deletion				      			   ##
#################################################################

class ControllerModuleSupportDepartaments extends Controller {
	
    private $error = array();
	
	public function install() {
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "departament` (
		  `departament_id` int(11) NOT NULL AUTO_INCREMENT,
		  `departament_group_id` int(11) NOT NULL,
		  `sort_order` int(3) NOT NULL,
		  PRIMARY KEY (`departament_id`)
		)");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "departament_description` (
		  `departament_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `departament_group_id` int(11) NOT NULL,
		  `name` varchar(64) NOT NULL,
		  `email` VARCHAR( 255 ) NOT NULL,
		  PRIMARY KEY (`departament_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "departament_group` (
		  `departament_group_id` int(11) NOT NULL AUTO_INCREMENT,
		  `sort_order` int(3) NOT NULL,
		  PRIMARY KEY (`departament_group_id`)
		)");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "departament_group_description` (
		  `departament_group_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `name` varchar(64) NOT NULL,
          `email` VARCHAR( 255 ) NOT NULL,
		  PRIMARY KEY (`departament_group_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");
    }
	
	public function uninstall() {
		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "departament`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "departament_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "departament_group`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "departament_group_description`");
    }
	
	
	
	public function index() {
		$this->load->language('module/support_departaments');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('module/support_departaments');
		$this->getList();
	}

	public function add() {
        $this->load->language('module/support_departaments');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('module/support_departaments');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_module_support_departaments->addDepartament($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
            
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
            
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function edit() {
		$this->load->language('module/support_departaments');
		$this->document->setTitle($this->language->get('heading_title_m'));

		$this->load->model('module/support_departaments');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
         
            
            
            
            
			$this->model_module_support_departaments->editDepartament($this->request->get['departament_group_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function delete() {
		$this->load->language('module/support_departaments');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('module/support_departaments');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $departament_group_id) {
				$this->model_module_support_departaments->deleteDepartament($departament_group_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
            
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getList();
	}
    
	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'fgd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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
			'text' => $this->language->get('heading_title_m'),
			'href' => $this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['insert'] = $this->url->link('module/support_departaments/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('module/support_departaments/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['departaments'] = array();

		$departament_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$departament_total = $this->model_module_support_departaments->getTotalDepartamentGroups();

		$results = $this->model_module_support_departaments->getDepartamentGroups($departament_data);
        
       

		foreach ($results as $result) {
			$data['departaments'][] = array(
				'departament_group_id' => $result['departament_group_id'],
				'name'            => $result['name'],
                'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('module/support_departaments/edit', 'token=' . $this->session->data['token'] . '&departament_group_id=' . $result['departament_group_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title_m');
        $data['advert'] = $this->language->get('advert');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_group'] = $this->language->get('column_group');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . '&sort=fgd.name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . '&sort=fg.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $departament_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($departament_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($departament_total - $this->config->get('config_limit_admin'))) ? $departament_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $departament_total, ceil($departament_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/support_departaments.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title_m');
		$data['advert'] = $this->language->get('advert');
		$data['text_form'] = !isset($this->request->get['departament_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_group'] = $this->language->get('entry_group');
		$data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_master_email'] = $this->language->get('entry_master_email');
        $data['help_master_email'] = $this->language->get('help_master_email');
        
        
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_departament_add'] = $this->language->get('button_departament_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['group'])) {
			$data['error_group'] = $this->error['group'];
		} else {
			$data['error_group'] = array();
		}

		if (isset($this->error['departament'])) {
			$data['error_departament'] = $this->error['departament'];
		} else {
			$data['error_departament'] = array();
		}
        if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = array();
		}

		$url = '';

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
			'text' => $this->language->get('heading_title_m'),
			'href' => $this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['departament_group_id'])) {
			$data['action'] = $this->url->link('module/support_departaments/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('module/support_departaments/edit', 'token=' . $this->session->data['token'] . '&departament_group_id=' . $this->request->get['departament_group_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('module/support_departaments', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['departament_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$departament_group_info = $this->model_module_support_departaments->getDepartamentGroup($this->request->get['departament_group_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

        
        
       
        
		if (isset($this->request->post['departament_group'])) {
			$data['departament_group'] = $this->request->post['departament_group'];
		} elseif (isset($this->request->get['departament_group_id'])) {
			$data['departament_group'] = $this->model_module_support_departaments->getDepartamentGroupEmails($this->request->get['departament_group_id']);
		} else {
			$data['departament_group'] = array();
		}
        
        
        
        if (isset($this->request->post['departament_group_description'])) {
			$data['departament_group_description'] = $this->request->post['departament_group_description'];
		} elseif (isset($this->request->get['departament_group_id'])) {
			$data['departament_group_description'] = $this->model_module_support_departaments->getDepartamentGroupDescriptions($this->request->get['departament_group_id']);
		} else {
			$data['departament_group_description'] = array();
		}
        
        

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($departament_group_info)) {
			$data['sort_order'] = $departament_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
        
       
        if (isset($this->request->post['departament'])) {
			$data['departaments'] = $this->request->post['departament'];
		} elseif (isset($this->request->get['departament_group_id'])) {
			$data['departaments'] = $this->model_module_support_departaments->getDepartamentDescriptions($this->request->get['departament_group_id']);
		} else {
			$data['departaments'] = array();
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/support_departaments_form.tpl', $data));
	}
    
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/support_departaments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['departament_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
				$this->error['group'][$language_id] = $this->language->get('error_group');
			}
		}
    
        
		if (isset($this->request->post['departament'])) {
			foreach ($this->request->post['departament'] as $departament_id => $departament) {
				
                foreach ($departament['departament_description'] as $language_id => $departament_description) {
					if ((utf8_strlen($departament_description['name']) < 1) || (utf8_strlen($departament_description['name']) > 64)) {
						$this->error['departament'][$departament_id][$language_id] = $this->language->get('error_name');
					}
				}
                
                
                foreach ($departament['departament_email'] as $language_id => $departament_email) {
					if ((utf8_strlen($departament_email['name']) < 1) || (utf8_strlen($departament_email['name']) > 255)) {
						 $this->error['email'][$departament_id][$language_id] = $this->language->get('error_email');
					}
				}
                
                
			}
   
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/support_departaments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['departament_name'])) {
			$this->load->model('module/support_departaments');

			$departament_data = array(
				'departament_name' => $this->request->get['departament_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$departaments = $this->model_module_support_departaments->getDepartaments($departament_data);

			foreach ($departaments as $departament) {
				$json[] = array(
					'departament_id' => $departament['departament_id'],
					'name'      => strip_tags(html_entity_decode($departament['group'] . ' &gt; ' . $departament['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}