<?php
class ControllerModuleShowcase extends Controller {
	public function index($setting) {
		static $module = 1;

		$this->document->addStyle('catalog/view/theme/default/stylesheet/showcase.css');
		$this->document->addScript('catalog/view/javascript/jquery/showcase/sc-carousel.js');
		$this->document->addScript('catalog/view/javascript/jquery/showcase/jquery.mousewheel.min.js');

		if (isset($setting['showcase'][$this->config->get('config_language_id')]['title'])) {
			$data['title'] = $setting['showcase'][$this->config->get('config_language_id')]['title'];
		}

		$data['cat'] = !empty($setting['showcase']['cat']) ? $setting['showcase']['cat'] : '';
		$data['subitems'] = !empty($setting['showcase']['subitems']) ? $setting['showcase']['subitems'] : '';
		$data['current'] = !empty($setting['showcase']['current']) && $setting['showcase']['allcat'] ? $setting['showcase']['current'] : '';
		$data['count_status'] = !empty($setting['showcase']['count_status']) ? $setting['showcase']['count_status'] : '';
		$data['hide_empty'] = !empty($setting['showcase']['hide_empty']) ? $setting['showcase']['hide_empty'] : '';

		$data['parent_image'] = !empty($setting['showcase']['parent_image']) ? $setting['showcase']['parent_image'] : '';
		$data['child_image'] = !empty($setting['showcase']['child_image']) ? $setting['showcase']['child_image'] : '';

		$data['parent_width'] = !empty($setting['showcase']['parent_width']) ? $setting['showcase']['parent_width'] : '200';
		$data['child_width'] = !empty($setting['showcase']['child_width']) ? $setting['showcase']['child_width'] : '200';
		$data['parent_height'] = !empty($setting['showcase']['parent_height']) ? $setting['showcase']['parent_height'] : '200';
		$data['child_height'] = !empty($setting['showcase']['child_height']) ? $setting['showcase']['child_height'] : '200';

		$data['parent_desc'] = !empty($setting['showcase']['parent_desc']) ? $setting['showcase']['parent_desc'] : '';
		$data['parent_desc_limit'] = !empty($setting['showcase']['parent_desc_limit']) ? $setting['showcase']['parent_desc_limit'] : '-1';

		$data['child_desc'] = !empty($setting['showcase']['child_desc']) ? $setting['showcase']['child_desc'] : '';
		$data['child_desc_limit'] = !empty($setting['showcase']['child_desc_limit']) ? $setting['showcase']['child_desc_limit'] : '-1';

		$data['description_status'] = !empty($setting['showcase']['description_status']) ? $setting['showcase']['description_status'] : '';
		$data['description_limit'] = !empty($setting['showcase']['description_limit']) ? $setting['showcase']['description_limit'] : '-1';

		$data['parent_btn_more'] = !empty($setting['showcase']['parent_btn_more']) ? $setting['showcase']['parent_btn_more'] : '';
		$data['child_btn_more'] = !empty($setting['showcase']['child_btn_more']) ? $setting['showcase']['child_btn_more'] : '';

		$data['parent_btn_text'] = !empty($setting['showcase']['parent_btn_text']) ? html_entity_decode($setting['showcase']['parent_btn_text'], ENT_QUOTES, 'UTF-8') : 'View More';
		$data['child_btn_text'] = !empty($setting['showcase']['child_btn_text']) ? html_entity_decode($setting['showcase']['child_btn_text'], ENT_QUOTES, 'UTF-8') : 'View More';

		// Carousel
		$data['parent_carousel'] = 1;
		$data['child_carousel'] = 1;

		$data['parent_mousewheel'] = !empty($setting['showcase']['parent_mousewheel']) ? $setting['showcase']['parent_mousewheel'] : '';
		$data['child_mousewheel'] = !empty($setting['showcase']['child_mousewheel']) ? $setting['showcase']['child_mousewheel'] : '';

		$data['parent_margin'] = isset($setting['showcase']['parent_margin']) ? (int)$setting['showcase']['parent_margin'] : '20';
		$data['child_margin'] = isset($setting['showcase']['child_margin']) ? (int)$setting['showcase']['child_margin'] : '20';

		$data['parent_nav'] = !empty($setting['showcase']['parent_nav']) ? 'true' : 'false';
		$data['child_nav'] = !empty($setting['showcase']['child_nav']) ? 'true' : 'false';

		$data['parent_nav_speed'] = !empty($setting['showcase']['parent_nav_speed']) ? $setting['showcase']['parent_nav_speed'] : '200';
		$data['child_nav_speed'] = !empty($setting['showcase']['child_nav_speed']) ? $setting['showcase']['child_nav_speed'] : '200';

		$data['parent_dots'] = !empty($setting['showcase']['parent_dots']) ? 'true' : 'false';
		$data['child_dots'] = !empty($setting['showcase']['child_dots']) ? 'true' : 'false';

		$data['parent_prev_nav'] = !empty($setting['showcase']['parent_prev_nav']) ? html_entity_decode($setting['showcase']['parent_prev_nav'], ENT_QUOTES, 'UTF-8') : 'prev';
		$data['child_prev_nav'] = !empty($setting['showcase']['child_prev_nav']) ? html_entity_decode($setting['showcase']['child_prev_nav'], ENT_QUOTES, 'UTF-8') : 'prev';

		$data['parent_next_nav'] = !empty($setting['showcase']['parent_next_nav']) ? html_entity_decode($setting['showcase']['parent_next_nav'], ENT_QUOTES, 'UTF-8') : 'next';
		$data['child_next_nav'] = !empty($setting['showcase']['child_next_nav']) ? html_entity_decode($setting['showcase']['child_next_nav'], ENT_QUOTES, 'UTF-8') : 'next';

		$data['parent_items_lg'] = !empty($setting['showcase']['parent_items_lg']) ? $setting['showcase']['parent_items_lg'] : '5';
		$data['child_items_lg'] = !empty($setting['showcase']['child_items_lg']) ? $setting['showcase']['child_items_lg'] : '5';

		$data['parent_items_md'] = !empty($setting['showcase']['parent_items_md']) ? $setting['showcase']['parent_items_md'] : '4';
		$data['child_items_md'] = !empty($setting['showcase']['child_items_md']) ? $setting['showcase']['child_items_md'] : '4';

		$data['parent_items_sm'] = !empty($setting['showcase']['parent_items_sm']) ? $setting['showcase']['parent_items_sm'] : '3';
		$data['child_items_sm'] = !empty($setting['showcase']['child_items_sm']) ? $setting['showcase']['child_items_sm'] : '3';

		$data['parent_items_xs'] = !empty($setting['showcase']['parent_items_xs']) ? $setting['showcase']['parent_items_xs'] : '2';
		$data['child_items_xs'] = !empty($setting['showcase']['child_items_xs']) ? $setting['showcase']['child_items_xs'] : '2';

		$this->load->model('catalog/showcase');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$data['items'] = array();

		if ($setting['showcase']['cat']) {

			if (!$setting['showcase']['allcat']) {
				if (!empty($setting['showcase']['fcat'])) {
					$items = $setting['showcase']['fcat'];
				} else {
					$items = array();
				}
			} else {
				if ($data['current']) {
					$current_id = (int)end($parts);
					$items = $this->model_catalog_showcase->getShowcaseCategories($current_id);
				} else {
					$items = $this->model_catalog_showcase->getShowcaseCategories(0);
				}
			}

			foreach ($items as $item) {

				if (!$setting['showcase']['allcat']) {
					$item = $this->model_catalog_showcase->getShowcaseCategory($item);
				}

				if ($item) {
					if ($data['subitems']) {
						$lvl2_data = array();
						$subitems1 = $this->model_catalog_showcase->getShowcaseCategories($item['category_id']);

						foreach($subitems1 as $subitem1) {

							$filter_data = array(
								'filter_category_id' => $subitem1['category_id'],
								'filter_sub_category' => true
								);

							$lvl2_data[] = array(
								'name'        => $subitem1['name'],
								'href'        => $this->url->link('product/category', isset($this->request->get['path']) && $data['current'] ? 'path=' . $this->request->get['path'] . '_' . $item['category_id'] . '_' . $subitem1['category_id'] : 'path=' . $item['category_id'] . '_' . $subitem1['category_id']),
								'description' => utf8_substr(strip_tags(html_entity_decode($subitem1['description'], ENT_QUOTES, 'UTF-8')), 0, $data['child_desc_limit']) . ($subitem1['description'] && $data['child_desc_limit'] > 0 ? '...' : ''),
								'item_id'     => isset($this->request->get['path']) && $data['current'] ? implode('-', $parts) . '-' . $item['category_id'] . '-' . $subitem1['category_id'] : $item['category_id'] . '-' . $subitem1['category_id'],
								'count'       => $data['count_status'] ? $this->model_catalog_product->getTotalProducts($filter_data) : '',
								'active'      => in_array($subitem1['category_id'], $parts),
								'not_empty'   => $this->model_catalog_product->getTotalProducts($filter_data) == 0 && $data['hide_empty'] ? 0 : 1,
								'thumb'       => $this->model_tool_image->resize(($subitem1['image'] == '' ? 'placeholder.png' : $subitem1['image']), $data['child_width'], $data['child_height'])
								);
						}
					}

					$filter_data = array(
						'filter_category_id'  => $item['category_id'],
						'filter_sub_category' => true
						);

					$data['items'][] = array(
						'name'        => $item['name'],
						'href'        => $this->url->link('product/category', isset($this->request->get['path']) && $data['current'] ? 'path=' . $this->request->get['path'] . '_' . $item['category_id'] : 'path=' . $item['category_id']),
						'parent_desc' => utf8_substr(strip_tags(html_entity_decode($item['description'], ENT_QUOTES, 'UTF-8')), 0, $data['parent_desc_limit']) . ($item['description'] && $data['parent_desc_limit'] > 0 ? '...' : ''),
						'description' => utf8_substr(strip_tags(html_entity_decode($item['description'], ENT_QUOTES, 'UTF-8')), 0, $data['description_limit']) . ($item['description'] && $data['description_limit'] > 0 ? '...' : ''),
						'item_id'     => isset($this->request->get['path']) && $data['current'] ? implode('-', $parts) . '-' . $item['category_id'] : $item['category_id'],
						'count'       => $data['count_status'] ? $this->model_catalog_product->getTotalProducts($filter_data) : '',
						'active'      => in_array($item['category_id'], $parts),
						'lvl2'        => $data['subitems'] ? $lvl2_data : '',
						'not_empty'   => $this->model_catalog_product->getTotalProducts($filter_data) == 0 && $data['hide_empty'] ? 0 : 1,
						'thumb'       => $this->model_tool_image->resize(($item['image'] == '' ? 'placeholder.png' : $item['image']), $data['parent_width'], $data['parent_height'])
						);
				}
			}

		} else {

			$this->load->model('catalog/manufacturer');

			if (isset($this->request->get['manufacturer_id'])) {
				$data['manufacturer_id'] = (int)$this->request->get['manufacturer_id'];
			} else {
				$data['manufacturer_id'] = 0;
			}

			if ($setting['showcase']['allbrands']) {
				$items =$this->model_catalog_manufacturer->getManufacturers();
			} else {
				if (!empty($setting['showcase']['fbrand'])) {
					$items = $setting['showcase']['fbrand'];
				} else {
					$items = array();
				}
			}

			foreach ($items as $item) {

				if (!$setting['showcase']['allbrands']) {
					$item = $this->model_catalog_manufacturer->getManufacturer($item);
				}

				if ($item) {
					$data['items'][] = array(
						'name'    => $item['name'],
						'href'    => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $item['manufacturer_id']),
						'active'  => $item['manufacturer_id'] == $data['manufacturer_id'] ? 1 : 0,
						'item_id' => $item['manufacturer_id'],
						'thumb'   => $this->model_tool_image->resize(($item['image'] == '' ? 'placeholder.png' : $item['image']), $data['parent_width'], $data['parent_height'])
						);
				}
			}
		}

		$data['module'] = $module++;

		if ($data['items']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/showcase.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/showcase.tpl', $data);
			} else {
				return $this->load->view('default/template/module/showcase.tpl', $data);
			}
		}
	}
}