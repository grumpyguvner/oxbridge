<?php
class ControllerModuleShowcase extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/showcase');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (!isset($this->request->get['module_id'])) {
			$data['apply_btn'] = false;
		} else {
			$data['apply_btn'] = true;
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('showcase', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			if (isset($this->request->post['apply']) && $this->request->post['apply'] == '1') {
				$this->session->data['success'] = $this->language->get('text_apply');
				$this->response->redirect($this->url->link('module/showcase', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL'));
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_allcat'] = $this->language->get('text_allcat');
		$data['text_fcat'] = $this->language->get('text_fcat');
		$data['text_allbrands'] = $this->language->get('text_allbrands');
		$data['text_fbrands'] = $this->language->get('text_fbrands');
		$data['text_count'] = $this->language->get('text_count');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_current'] = $this->language->get('text_current');
		$data['text_lg'] = $this->language->get('text_lg');
		$data['text_md'] = $this->language->get('text_md');
		$data['text_sm'] = $this->language->get('text_sm');
		$data['text_xs'] = $this->language->get('text_xs');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_items'] = $this->language->get('entry_items');
		$data['entry_cat'] = $this->language->get('entry_cat');
		$data['entry_brands'] = $this->language->get('entry_brands');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_btn_more'] = $this->language->get('entry_btn_more');
		$data['entry_btn_text'] = $this->language->get('entry_btn_text');
		$data['entry_carousel'] = $this->language->get('entry_carousel');
		$data['entry_margin'] = $this->language->get('entry_margin');
		$data['entry_mousewheel'] = $this->language->get('entry_mousewheel');
		$data['entry_dots'] = $this->language->get('entry_dots');
		$data['entry_nav'] = $this->language->get('entry_nav');
		$data['entry_nav_speed'] = $this->language->get('entry_nav_speed');
		$data['entry_prev_nav'] = $this->language->get('entry_prev_nav');
		$data['entry_next_nav'] = $this->language->get('entry_next_nav');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_child'] = $this->language->get('entry_child');
		$data['entry_subitems'] = $this->language->get('entry_subitems');
		$data['entry_desc'] = $this->language->get('entry_desc');
		$data['entry_parent_desc'] = $this->language->get('entry_parent_desc');
		$data['entry_subitems_desc'] = $this->language->get('entry_subitems_desc');
		$data['entry_desc_limit'] = $this->language->get('entry_desc_limit');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_margin'] = $this->language->get('entry_margin');
		$data['entry_nav_text'] = $this->language->get('entry_nav_text');
		$data['entry_prev_nav'] = $this->language->get('entry_prev_nav');
		$data['entry_next_nav'] = $this->language->get('entry_next_nav');

		$data['tab_items'] = $this->language->get('tab_items');
		$data['tab_subitems'] = $this->language->get('tab_subitems');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_apply'] = $this->language->get('button_apply');

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

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/showcase', 'token=' . $this->session->data['token'], 'SSL')
				);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/showcase', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
				);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/showcase', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/showcase', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['showcase'])) {
			$data['showcase'] = $this->request->post['showcase'];
		} elseif (!empty($module_info)) {
			$data['showcase'] = $module_info['showcase'];
		} else {
			$data['showcase'] = '';
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('catalog/category');
		$data['categories'] = array();

		if (!empty($this->request->post['showcase']['fcat'])) {
			$categories = $this->request->post['showcase']['fcat'];
		} elseif (!empty($module_info) && !empty($module_info['showcase']['fcat'])) {
			$categories = $module_info['showcase']['fcat'];
		} else {
			$categories = array();
		}

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => $category_info['name']
					);
			}
		}

		$this->load->model('catalog/manufacturer');
		$data['brands'] = array();

		if (!empty($this->request->post['showcase']['fbrand'])) {
			$brands = $this->request->post['showcase']['fbrand'];
		} elseif (!empty($module_info) && !empty($module_info['showcase']['fbrand'])) {
			$brands = $module_info['showcase']['fbrand'];
		} else {
			$brands = array();
		}

		foreach ($brands as $brand_id) {
			$brand_info = $this->model_catalog_manufacturer->getManufacturer($brand_id);

			if ($brand_info) {
				$data['brands'][] = array(
					'brand_id' => $brand_info['manufacturer_id'],
					'name'     => $brand_info['name']
					);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/showcase.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/showcase')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}
}