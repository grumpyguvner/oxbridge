<?php

class ModelSaleOrderEntry extends Model {

	public function checkEmail($email) {
		$query = $this->db->query("SELECT `email` FROM `" . DB_PREFIX . "customer` WHERE LCASE(`email`) = '" . $this->db->escape(strtolower($email)) . "'");
		if ($query->num_rows) {
			return 1;
		} else {
			return 0;
		}
	}

	public function getModules() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oe_modules` ORDER BY `module_name`");
		return $query->rows;
	}

	public function enable($module_id) {
		$module_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oe_modules` WHERE `oe_module_id` = '" . (int)$module_id . "'");
		if ($module_query->num_rows) {
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = '1' WHERE `key` = '" . $module_query->row['module_code'] . "_status'");
			return 1;
		} else {
			return 0;
		}
	}
	
	public function disable($module_id) {
		$module_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oe_modules` WHERE `oe_module_id` = '" . (int)$module_id . "'");
		if ($module_query->num_rows) {
			$this->db->query("UPDATE `" . DB_PREFIX . "setting` SET `value` = '0' WHERE `key` = '" . $module_query->row['module_code'] . "_status'");
			return 1;
		} else {
			return 0;
		}
	}

	public function getProducts($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$sql .= " AND (pd.name LIKE '" . $this->db->escape($data['name']) . "%'";
		$sql .= " OR p.model LIKE '" . $this->db->escape($data['name']) . "%'";
		$sql .= " OR p.sku LIKE '" . $this->db->escape($data['name']) . "%')";
		$sql .= " GROUP BY p.product_id";
		$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function updateOrders() {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order`");
		if ($order_query->num_rows) {
			foreach ($order_query->rows as $order) {
				$existing_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oe_order` WHERE `order_id` = '" . (int)$order['order_id'] . "'");
				if ($existing_query->num_rows < 1) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "oe_order` SET `order_id` = '" . (int)$order['order_id'] . "'");
					$oe_order_id = $this->db->getLastId();
				} else {
					$oe_order_id = $existing_query->row['oe_order_id'];
				}
				$order_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = '" . (int)$order['order_id'] . "'");
				if ($order_product_query->num_rows) {
					$new_product_id = 500000;
					foreach ($order_product_query->rows as $order_product) {
						$existing_op_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "oe_order_product` WHERE `oe_order_id` = '" . (int)$oe_order_id . "' AND `order_product_id` = '" . (int)$order_product['order_product_id'] . "'");
						if ($existing_op_query->num_rows < 1) {
							if ($order_product['product_id'] == 0) {
								$product_id = $new_product_id;
								$custom_product = 1;
								$new_product_id++;
							} else {
								$product_id = $order_product['product_id'];
								$custom_product = 0;
							}
							$this->db->query("INSERT INTO `" . DB_PREFIX . "oe_order_product` SET `oe_order_id` = '" . (int)$oe_order_id . "', `order_product_id` = '" . (int)$order_product['order_product_id'] . "', `order_id` = '" . (int)$order['order_id'] . "', `product_id` = '" . (int)$product_id . "', `notax` = '0', `custom_product` = '" . (int)$custom_product . "'");
						}
					}
				}
			}
		}
		return;
	}

	public function install() {
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "modification` MODIFY COLUMN `xml` longtext COLLATE utf8_general_ci NOT NULL");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oe_order` (
			`oe_order_id` int(11) NOT NULL auto_increment,
			`order_id` int(11) NOT NULL UNIQUE,
			PRIMARY KEY (`oe_order_id`)
		);");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oe_order_product` (
			`oe_order_product_id` int(11) NOT NULL auto_increment,
			`oe_order_id` int(11) NOT NULL,
			`order_product_id` int(11) NOT NULL,
			`order_id` int(11) NOT NULL,
			`product_id` int(11) NOT NULL,
			`notax` tinyint(1) NOT NULL,
			`custom_product` tinyint(1) NOT NULL,
			PRIMARY KEY (`oe_order_product_id`)
		);");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "oe_modules` (
			`oe_module_id` int(11) NOT NULL auto_increment,
			`module_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
			`module_code` varchar(255) COLLATE utf8_general_ci NOT NULL,
			PRIMARY KEY (`oe_module_id`)
		);");
		$start = 0;
		do {
			$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` LIMIT " . $start . ",1000");
			$start += 1000;
			$count = 0;
			if ($order_query->num_rows) {
				foreach ($order_query->rows as $order) {
					$count++;
					$this->db->query("INSERT INTO `" . DB_PREFIX . "oe_order` SET `order_id` = '" . (int)$order['order_id'] . "'");
					$oe_order_id = $this->db->getLastId();
					$order_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = '" . (int)$order['order_id'] . "'");
					if ($order_product_query->num_rows) {
						$new_product_id = 500000;
						foreach ($order_product_query->rows as $order_product) {
							if ($order_product['product_id'] == 0) {
								$product_id = $new_product_id;
								$custom_product = 1;
								$new_product_id++;
							} else {
								$product_id = $order_product['product_id'];
								$custom_product = 0;
							}
							$this->db->query("INSERT INTO `" . DB_PREFIX . "oe_order_product` SET `oe_order_id` = '" . (int)$oe_order_id . "', `order_product_id` = '" . (int)$order_product['order_product_id'] . "', `order_id` = '" . (int)$order['order_id'] . "', `product_id` = '" . (int)$product_id . "', `notax` = '0', `custom_product` = '" . (int)$custom_product . "'");
						}
					}
				}
			}
		} while ($order_query->num_rows > 0);
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "modification` MODIFY COLUMN xml longtext COLLATE utf8_general_ci NOT NULL");
		return;
	}
	
	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oe_order`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oe_order_product`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "oe_modules`");
		return;
	}

}

?>