<?php
#################################################################
## Open Cart Module:  ULTIMATE TOP HEADER MENU LINKS MANAGER   ##
##-------------------------------------------------------------##
## Copyright © 2014 MB "Programanija" All rights reserved.     ##
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

class ModelModuleTopHeaderLinks extends Model {
	
	public function addHeader($data) {
		$this->event->trigger('pre.admin.add.header', $data);

		$this->db->query("INSERT INTO `" . DB_PREFIX . "header_group` SET sort_order = '" . (int)$data['sort_order'] . "', columns = '" . (int)$data['columns'] . "'");
        
        
        

		$header_group_id = $this->db->getLastId();
        
        

		foreach ($data['header_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "header_group_description SET header_group_id = '" . (int)$header_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', link = '" . $this->db->escape($data['header_group'][$language_id]['link']) . "'");
		}
        
        if (isset($data['link_store'])) {
			foreach ($data['link_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "header_group_to_store SET header_group_id = '" . (int)$header_group_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
        
        

		if (isset($data['header'])) {
			foreach ($data['header'] as $header) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "header SET header_group_id = '" . (int)$header_group_id . "', sort_order = '" . (int)$header['sort_order'] . "'");

                
				$header_id = $this->db->getLastId();

				foreach ($header['header_description'] as $language_id => $header_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "header_description SET header_id = '" . (int)$header_id . "', language_id = '" . (int)$language_id  . "', header_group_id = '" . (int)$header_group_id . "', name = '" . $this->db->escape($header_description['name']) . "', link = '" . $this->db->escape($header['header_link'][$language_id]['name']) . "'");
                    
                    
				}
			}
		}
       
		$this->event->trigger('post.admin.add.header', $header_id);

		return $header_id;
	}

	public function editHeader($header_group_id, $data) {
		
	
		
		$this->event->trigger('pre.admin.edit.header', $data);
		
     
	

		$this->db->query("UPDATE `" . DB_PREFIX . "header_group` SET sort_order = '" . (int)$data['sort_order'] . "', columns = '" . (int)$data['columns'] . "' WHERE header_group_id = '" . (int)$header_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "header_group_description WHERE header_group_id = '" . (int)$header_group_id . "'");
        
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "header_group_to_store WHERE header_group_id = '" . (int)$header_group_id . "'");
        
       

		if (isset($data['link_store'])) {
			foreach ($data['link_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "header_group_to_store SET header_group_id = '" . (int)$header_group_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
        
        

		foreach ($data['header_group_description'] as $language_id => $value) {
			
            $this->db->query("INSERT INTO " . DB_PREFIX . "header_group_description SET header_group_id = '" . (int)$header_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', link = '" . $this->db->escape($data['header_group'][$language_id]['link']) . "'");
            
            
    
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "header WHERE header_group_id = '" . (int)$header_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "header_description WHERE header_group_id = '" . (int)$header_group_id . "'");


		


		if (isset($data['header'])) {
			foreach ($data['header'] as $header) {
				

				if ($header['header_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "header SET header_id = '" . (int)$header['header_id'] . "', header_group_id = '" . (int)$header_group_id . "', sort_order = '" . (int)$header['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "header SET header_group_id = '" . (int)$header_group_id . "', sort_order = '" . (int)$header['sort_order'] . "'");
				}

				$header_id = $this->db->getLastId();


				foreach ($header['header_description'] as $language_id => $header_description) {
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "header_description SET header_id = '" . (int)$header_id . "', language_id = '" . (int)$language_id . "', header_group_id = '" . (int)$header_group_id . "', name = '" . $this->db->escape($header_description['name']) . "', link = '" . $this->db->escape($header['header_link'][$language_id]['name']) . "'");
 
				}
			}
		}

		$this->event->trigger('post.admin.edit.header', $header_group_id);
	}

	public function deleteHeader($header_group_id) {
		$this->event->trigger('pre.admin.delete.header', $header_group_id);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "header_group` WHERE header_group_id = '" . (int)$header_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "header_group_description` WHERE header_group_id = '" . (int)$header_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "header` WHERE header_group_id = '" . (int)$header_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "header_description` WHERE header_group_id = '" . (int)$header_group_id . "'");

		$this->event->trigger('post.admin.delete.header', $header_group_id);
	}

	public function getHeaderGroup($header_group_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "header_group` fg LEFT JOIN " . DB_PREFIX . "header_group_description fgd ON (fg.header_group_id = fgd.header_group_id) WHERE fg.header_group_id = '" . (int)$header_group_id . "' AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}
    
    

    
    
    public function getHeaderGroupStoresNames($header_group_id) {
		$store_data = array();

		$query = $this->db->query("SELECT hg2s.*, s.name 
        FROM " . DB_PREFIX . "header_group_to_store hg2s 
        LEFT JOIN " . DB_PREFIX . "store s ON s.store_id = hg2s.store_id
        WHERE hg2s.header_group_id = '" . (int)$header_group_id . "'");

		foreach ($query->rows as $result) {
            if($result['store_id'] == 0){
                
                $result['name'] = 'Default';
            }
			$store_data[] = $result['name'];
		}

		return $store_data;
	}
    
    
    
    
    

	public function getHeaderGroups($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "header_group` fg LEFT JOIN " . DB_PREFIX . "header_group_description fgd ON (fg.header_group_id = fgd.header_group_id) WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sort_data = array(
			'fgd.name',
			'fg.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY fgd.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

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

	public function getHeaderGroupDescriptions($header_group_id) {
		$header_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "header_group_description WHERE header_group_id = '" . (int)$header_group_id . "'");

		foreach ($query->rows as $result) {
			$header_group_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $header_group_data;
	}
    
    public function getHeaderGroupLinks($header_group_id) {
		$header_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "header_group_description WHERE header_group_id = '" . (int)$header_group_id . "'");

		foreach ($query->rows as $result) {
			$header_group_data[$result['language_id']] = array('link' => $result['link']);
		}

		return $header_group_data;
	}

	public function getHeader($header_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "header_group_description fgd WHERE f.header_group_id = fgd.header_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "header f LEFT JOIN " . DB_PREFIX . "header_description fd ON (f.header_id = fd.header_id) WHERE f.header_id = '" . (int)$header_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getHeaders($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "header_group_description fgd WHERE f.header_group_id = fgd.header_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "header f LEFT JOIN " . DB_PREFIX . "header_description fd ON (f.header_id = fd.header_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['header_name'])) {
			$sql .= " AND fd.name LIKE '" . $this->db->escape($data['header_name']) . "%'";
		}

		$sql .= " ORDER BY f.sort_order ASC";

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

	public function getHeaderDescriptions($header_group_id) {
		$header_data = array();

		$header_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "header WHERE header_group_id = '" . (int)$header_group_id . "' ORDER BY sort_order ASC");

		foreach ($header_query->rows as $header) {
			$header_description_data = array();

			$header_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "header_description WHERE header_id = '" . (int)$header['header_id'] . "'");

			foreach ($header_description_query->rows as $header_description) {
				$header_description_data[$header_description['language_id']] = array('name' => $header_description['name']);
				$header_link[$header_description['language_id']] = array('name' => $header_description['link']);
			}

			$header_data[] = array(
				'header_id'          => $header['header_id'],
				'header_description' => $header_description_data,
				'header_link' 		 => $header_link,
				'sort_order'         => $header['sort_order']
			);
		}

		return $header_data;
	}

	public function getTotalHeaderGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "header_group`");

		return $query->row['total'];
	}
    
    
    public function getLinkStores($header_id) {
		$link_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "header_group_to_store WHERE header_group_id = '" . (int)$header_id . "'");

		foreach ($query->rows as $result) {
			$link_store_data[] = $result['store_id'];
		}

		return $link_store_data;
	}
    
}