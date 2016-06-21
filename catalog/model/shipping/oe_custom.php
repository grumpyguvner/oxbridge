<?php

class ModelShippingOeCustom extends Model {

	function getQuote($address) {
		$this->load->language('shipping/oe_custom');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('oe_custom_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		if (!$this->config->get('oe_custom_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		$method_data = array();
		if ($status) {
			if (isset($this->session->data['oe']['custom_shipping'])) {
				$title = $this->session->data['oe']['custom_shipping']['title'];
				if ($this->config->get('oe_custom_display_weight')) {
					$weight = $this->cart->getWeight();
					$description = $this->session->data['oe']['custom_shipping']['title'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')';
				} else {
					$description = $this->session->data['oe']['custom_shipping']['title'];
				}
				$cost = $this->session->data['oe']['custom_shipping']['cost'];
			} else {
				if ($this->config->get('oe_custom_shipping_desc')) {
					$desc = $this->config->get('oe_custom_shipping_desc');
				} else {
					$desc = $this->language->get('text_custom_shipping_desc');
				}
				if ($this->config->get('oe_custom_display_weight')) {
					$weight = $this->cart->getWeight();
					$description = sprintf($this->language->get('text_description'), $desc) . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')';
				} else {
					$description = sprintf($this->language->get('text_description'), $desc);
				}
				if ($this->config->get('oe_custom_shipping_title')) {
					$title = $this->config->get('oe_custom_shipping_title');
				} else {
					$title = $this->language->get('text_custom_shipping_title');
				}
				$cost = $this->config->get('oe_custom_cost');
			}
			$quote_data = array();
			$quote_data['oe_custom'] = array(
				'code'         => 'oe_custom.oe_custom',
				'title'        => $description,
				'cost'         => $cost,
				'tax_class_id' => $this->config->get('oe_custom_tax_class_id'),
				'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('oe_custom_tax_class_id'), $this->config->get('config_tax')))
			);
			$method_data = array(
				'code'       => 'oe_custom',
				'title'      => sprintf($this->language->get('text_title'), $title),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('oe_custom_sort_order'),
				'error'      => false
			);
		}
		return $method_data;
	}

}