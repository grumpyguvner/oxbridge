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

class ModelModuleSupportDepartaments extends Model {
	
	public function addDepartament($data) {
		

		$this->db->query("INSERT INTO `" . DB_PREFIX . "departament_group` SET sort_order = '" . (int)$data['sort_order'] . "'");

		$departament_group_id = $this->db->getLastId();

		foreach ($data['departament_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "departament_group_description SET departament_group_id = '" . (int)$departament_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', `email` = '" . $this->db->escape($value['email']) . "'");
		}
        
        
        

		if (isset($data['departament'])) {
			foreach ($data['departament'] as $departament) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "departament SET departament_group_id = '" . (int)$departament_group_id . "', sort_order = '" . (int)$departament['sort_order'] . "'");

                
				$departament_id = $this->db->getLastId();

				foreach ($departament['departament_description'] as $language_id => $departament_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "departament_description SET departament_id = '" . (int)$departament_id . "', language_id = '" . (int)$language_id  . "', departament_group_id = '" . (int)$departament_group_id . "', name = '" . $this->db->escape($departament_description['name']) . "', email = '" . $this->db->escape($departament['departament_email'][$language_id]['name']) . "'");
                    
                    
				}
			}
		}
       

		return $departament_id;
	}

	public function editDepartament($departament_group_id, $data) {
		
		
		$this->db->query("UPDATE `" . DB_PREFIX . "departament_group` SET sort_order = '" . (int)$data['sort_order'] . "'  WHERE departament_group_id = '" . (int)$departament_group_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "departament_group_description WHERE departament_group_id = '" . (int)$departament_group_id . "'");


        
		foreach ($data['departament_group_description'] as $language_id => $value) {
			
            $this->db->query("INSERT INTO " . DB_PREFIX . "departament_group_description SET departament_group_id = '" . (int)$departament_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', `email` = '" . $this->db->escape($value['email']) . "'");
            
            
        
          

            
    
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "departament WHERE departament_group_id = '" . (int)$departament_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "departament_description WHERE departament_group_id = '" . (int)$departament_group_id . "'");


		


		if (isset($data['departament'])) {
			foreach ($data['departament'] as $departament) {
				

				if ($departament['departament_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "departament SET departament_id = '" . (int)$departament['departament_id'] . "', departament_group_id = '" . (int)$departament_group_id . "', sort_order = '" . (int)$departament['sort_order'] . "'");
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "departament SET departament_group_id = '" . (int)$departament_group_id . "', sort_order = '" . (int)$departament['sort_order'] . "'");
				}

				$departament_id = $this->db->getLastId();


				foreach ($departament['departament_description'] as $language_id => $departament_description) {
					
					$this->db->query("INSERT INTO " . DB_PREFIX . "departament_description SET departament_id = '" . (int)$departament_id . "', language_id = '" . (int)$language_id . "', departament_group_id = '" . (int)$departament_group_id . "', name = '" . $this->db->escape($departament_description['name']) . "', email = '" . $this->db->escape($departament['departament_email'][$language_id]['name']) . "'");
 
				}
			}
		}

	}

	public function deleteDepartament($departament_group_id) {

		$this->db->query("DELETE FROM `" . DB_PREFIX . "departament_group` WHERE departament_group_id = '" . (int)$departament_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "departament_group_description` WHERE departament_group_id = '" . (int)$departament_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "departament` WHERE departament_group_id = '" . (int)$departament_group_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "departament_description` WHERE departament_group_id = '" . (int)$departament_group_id . "'");

	}

	public function getDepartamentGroup($departament_group_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "departament_group` fg LEFT JOIN " . DB_PREFIX . "departament_group_description fgd ON (fg.departament_group_id = fgd.departament_group_id) WHERE fg.departament_group_id = '" . (int)$departament_group_id . "' AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDepartamentGroups($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "departament_group` fg LEFT JOIN " . DB_PREFIX . "departament_group_description fgd ON (fg.departament_group_id = fgd.departament_group_id) WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

	public function getDepartamentGroupDescriptions($departament_group_id) {
		$departament_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "departament_group_description WHERE departament_group_id = '" . (int)$departament_group_id . "'");

		foreach ($query->rows as $result) {
			$departament_group_data[$result['language_id']] = array('name' => $result['name'], 'email' => $result['email']);
		}

		return $departament_group_data;
	}
    
    public function getDepartamentGroupEmails($departament_group_id) {
		$departament_group_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "departament_group_description WHERE departament_group_id = '" . (int)$departament_group_id . "'");

		foreach ($query->rows as $result) {
			$departament_group_data[$result['language_id']] = array('email' => $result['email']);
		}

		return $departament_group_data;
	}

	public function getDepartament($departament_id) {
		$query = $this->db->query("SELECT *, (SELECT name FROM " . DB_PREFIX . "departament_group_description fgd WHERE f.departament_group_id = fgd.departament_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "departament f LEFT JOIN " . DB_PREFIX . "departament_description fd ON (f.departament_id = fd.departament_id) WHERE f.departament_id = '" . (int)$departament_id . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getDepartaments($data) {
		$sql = "SELECT *, (SELECT name FROM " . DB_PREFIX . "departament_group_description fgd WHERE f.departament_group_id = fgd.departament_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS `group` FROM " . DB_PREFIX . "departament f LEFT JOIN " . DB_PREFIX . "departament_description fd ON (f.departament_id = fd.departament_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['departament_name'])) {
			$sql .= " AND fd.name LIKE '" . $this->db->escape($data['departament_name']) . "%'";
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

	public function getDepartamentDescriptions($departament_group_id) {
		$departament_data = array();

		$departament_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "departament WHERE departament_group_id = '" . (int)$departament_group_id . "' ORDER BY sort_order ASC");

		foreach ($departament_query->rows as $departament) {
			$departament_description_data = array();

			$departament_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "departament_description WHERE departament_id = '" . (int)$departament['departament_id'] . "'");

			foreach ($departament_description_query->rows as $departament_description) {
				$departament_description_data[$departament_description['language_id']] = array('name' => $departament_description['name']);
				$departament_email[$departament_description['language_id']] = array('name' => $departament_description['email']);
			}

			$departament_data[] = array(
				'departament_id'          => $departament['departament_id'],
				'departament_description' => $departament_description_data,
				'departament_email' 		 => $departament_email,
				'sort_order'         => $departament['sort_order']
			);
		}

		return $departament_data;
	}

	public function getTotalDepartamentGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "departament_group`");

		return $query->row['total'];
	}
}