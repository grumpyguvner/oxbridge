<?php
#################################################################
## Open Cart Module:  ULTIMATE TOP HEADER MENU LINKS MANAGER   ##
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

class ControllerModuleTopHeaderLinks extends Controller {
	
    private $error = array();
	
	public function install() {
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "header` (
		  `header_id` int(11) NOT NULL AUTO_INCREMENT,
		  `header_group_id` int(11) NOT NULL,
		  `sort_order` int(3) NOT NULL,
		  PRIMARY KEY (`header_id`)
		)");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "header_description` (
		  `header_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `header_group_id` int(11) NOT NULL,
		  `name` varchar(64) NOT NULL,
		  `link` VARCHAR( 255 ) NOT NULL,
		  PRIMARY KEY (`header_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");
        
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "header_group_to_store` (
          `header_group_id` int(11) NOT NULL,
          `store_id` int(11) NOT NULL,
          PRIMARY KEY (`header_group_id`,`store_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");
        

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "header_group` (
		  `header_group_id` int(11) NOT NULL AUTO_INCREMENT,
		  `sort_order` int(3) NOT NULL,
          `columns` INT( 3 ) NOT NULL,
		  PRIMARY KEY (`header_group_id`)
		)");

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "header_group_description` (
		  `header_group_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `name` varchar(64) NOT NULL,
          `link` VARCHAR( 255 ) NOT NULL,
		  PRIMARY KEY (`header_group_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;");
    }
	
	public function uninstall() {
		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "header`");
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "header_group_to_store`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "header_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "header_group`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "header_group_description`");
        
    }
	
	
	
	public function index() {
		$this->load->language('module/top_header_links');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('module/top_header_links');
		$this->getList();
	}

	public function add() {
        $this->load->language('module/top_header_links');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('module/top_header_links');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_module_top_header_links->addHeader($this->request->post);
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
			$this->response->redirect($this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function edit() {
		$this->load->language('module/top_header_links');
		$this->document->setTitle($this->language->get('heading_title_m'));

		$this->load->model('module/top_header_links');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_module_top_header_links->editHeader($this->request->get['header_group_id'], $this->request->post);
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
			$this->response->redirect($this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getForm();
	}

	public function delete() {
		$this->load->language('module/top_header_links');
		$this->document->setTitle($this->language->get('heading_title_m'));
		$this->load->model('module/top_header_links');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $header_group_id) {
				$this->model_module_top_header_links->deleteHeader($header_group_id);
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
			$this->response->redirect($this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		$data['insert'] = $this->url->link('module/top_header_links/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('module/top_header_links/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['headers'] = array();

		$header_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$header_total = $this->model_module_top_header_links->getTotalHeaderGroups();

		$results = $this->model_module_top_header_links->getHeaderGroups($header_data);
        
       
           

		foreach ($results as $result) {
            
                
			$data['headers'][] = array(
				'header_group_id' => $result['header_group_id'],
				'name'            => $result['name'],
				'columns'         => $result['columns'],
                'stores'          => implode(', ',$this->model_module_top_header_links->getHeaderGroupStoresNames($result['header_group_id'])),
                'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('module/top_header_links/edit', 'token=' . $this->session->data['token'] . '&header_group_id=' . $result['header_group_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title_m');
        $data['advert'] = $this->language->get('advert');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_group'] = $this->language->get('column_group');
		$data['column_store'] = $this->language->get('column_store');
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

		$data['sort_name'] = $this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . '&sort=fgd.name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . '&sort=fg.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $header_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($header_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($header_total - $this->config->get('config_limit_admin'))) ? $header_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $header_total, ceil($header_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/top_header_links.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title_m');
		$data['advert'] = $this->language->get('advert');
		$data['text_form'] = !isset($this->request->get['header_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default'] = $this->language->get('text_default');

		$data['entry_group'] = $this->language->get('entry_group');
		$data['entry_name'] = $this->language->get('entry_name');
        $data['entry_link'] = $this->language->get('entry_link');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_columns'] = $this->language->get('entry_columns');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_header_add'] = $this->language->get('button_header_add');
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

		if (isset($this->error['header'])) {
			$data['error_header'] = $this->error['header'];
		} else {
			$data['error_header'] = array();
		}
        if (isset($this->error['link'])) {
			$data['error_link'] = $this->error['link'];
		} else {
			$data['error_link'] = array();
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
			'href' => $this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
		
		if (!isset($this->request->get['header_group_id'])) {
			$data['action'] = $this->url->link('module/top_header_links/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('module/top_header_links/edit', 'token=' . $this->session->data['token'] . '&header_group_id=' . $this->request->get['header_group_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('module/top_header_links', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['header_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$header_group_info = $this->model_module_top_header_links->getHeaderGroup($this->request->get['header_group_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

        
        $this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();
        
        
        if (isset($this->request->post['link_store'])) {
			$data['link_store'] = $this->request->post['link_store'];
		} elseif (isset($this->request->get['header_group_id'])) {
			$data['link_store'] = $this->model_module_top_header_links->getLinkStores($this->request->get['header_group_id']);
		} else {
			$data['link_store'] = array(0);
		}
        
       
        
		if (isset($this->request->post['header_group'])) {
			$data['header_group'] = $this->request->post['header_group'];
		} elseif (isset($this->request->get['header_group_id'])) {
			$data['header_group'] = $this->model_module_top_header_links->getHeaderGroupLinks($this->request->get['header_group_id']);
		} else {
			$data['header_group'] = array();
		}
        
        
        
        if (isset($this->request->post['header_group_description'])) {
			$data['header_group_description'] = $this->request->post['header_group_description'];
		} elseif (isset($this->request->get['header_group_id'])) {
			$data['header_group_description'] = $this->model_module_top_header_links->getHeaderGroupDescriptions($this->request->get['header_group_id']);
		} else {
			$data['header_group_description'] = array();
		}
        
        
        if (isset($this->request->post['columns'])) {
			$data['columns'] = $this->request->post['columns'];
		} elseif (!empty($header_group_info)) {
			$data['columns'] = $header_group_info['columns'];
		} else {
			$data['columns'] = '';
		}
        

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($header_group_info)) {
			$data['sort_order'] = $header_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
        
       
        if (isset($this->request->post['header'])) {
			$data['headers'] = $this->request->post['header'];
		} elseif (isset($this->request->get['header_group_id'])) {
			$data['headers'] = $this->model_module_top_header_links->getHeaderDescriptions($this->request->get['header_group_id']);
		} else {
			$data['headers'] = array();
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/top_header_links_form.tpl', $data));
	}
    
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/top_header_links')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['header_group_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
				$this->error['group'][$language_id] = $this->language->get('error_group');
			}
		}
    
        
		if (isset($this->request->post['header'])) {
			foreach ($this->request->post['header'] as $header_id => $header) {
				
                foreach ($header['header_description'] as $language_id => $header_description) {
					if ((utf8_strlen($header_description['name']) < 1) || (utf8_strlen($header_description['name']) > 64)) {
						$this->error['header'][$header_id][$language_id] = $this->language->get('error_name');
					}
				}
                
                
                foreach ($header['header_link'] as $language_id => $header_link) {
					if ((utf8_strlen($header_link['name']) < 1) || (utf8_strlen($header_link['name']) > 255)) {
						 $this->error['link'][$header_id][$language_id] = $this->language->get('error_link');
					}
				}
                
                
			}
   
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/top_header_links')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['header_name'])) {
			$this->load->model('module/top_header_links');

			$header_data = array(
				'header_name' => $this->request->get['header_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$headers = $this->model_module_top_header_links->getHeaders($header_data);

			foreach ($headers as $header) {
				$json[] = array(
					'header_id' => $header['header_id'],
					'name'      => strip_tags(html_entity_decode($header['group'] . ' &gt; ' . $header['name'], ENT_QUOTES, 'UTF-8'))
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