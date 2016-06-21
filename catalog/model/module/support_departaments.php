<?php
class ModelModuleSupportDepartaments extends Model {
	public function getDepartamentById($departament_id) {
		$query = $this->db->query("SELECT dd.*, d.* 
        FROM " . DB_PREFIX . "departament_description dd
        LEFT JOIN " . DB_PREFIX . "departament d ON d.departament_id = dd.departament_id
        WHERE dd.departament_group_id = '" . (int)$departament_id . "' AND dd.language_id ='". (int)$this->config->get('config_language_id')."'
        ORDER BY d.sort_order ASC");

		return $query->rows;
	}
 
public function checkInstalled() {
	
    $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "extension` WHERE `code` = 'support_departaments'");

    return $query->num_rows;
}
    
    
    
  


public function getDepartament($departament_id) {
		$query = $this->db->query("SELECT dd.*, d.* 
        FROM " . DB_PREFIX . "departament_description dd
        LEFT JOIN " . DB_PREFIX . "departament d ON d.departament_id = dd.departament_id
        WHERE dd.departament_group_id = '" . (int)$departament_id . "' AND dd.language_id ='". (int)$this->config->get('config_language_id')."'
        ORDER BY d.sort_order ASC");

		return $query->row;
	}

    
public function getDepartamentByEmail($departament_id) {
		$query = $this->db->query("SELECT `email`
        FROM " . DB_PREFIX . "departament_description
        WHERE departament_id = '" . (int)$departament_id . "' AND language_id ='". (int)$this->config->get('config_language_id')."'");

		return $query->row;
	}   

public function getDepartamentByMasterEmail($departament_id) {
		$query = $this->db->query("SELECT `email`
        FROM " . DB_PREFIX . "departament_group_description
        WHERE departament_group_id = '" . (int)$departament_id . "' AND language_id ='". (int)$this->config->get('config_language_id')."'");

		return $query->row;
	} 
    
    
	public function getDepartaments() {
		//$country_data = $this->cache->get('country.status');

		//if (!$country_data) {
			$query = $this->db->query("SELECT dg.*, dgd.*
            FROM " . DB_PREFIX . "departament_group dg
            LEFT JOIN " . DB_PREFIX . "departament_group_description dgd ON dgd.departament_group_id = dg.departament_group_id
            WHERE dgd.language_id ='". (int)$this->config->get('config_language_id')."'   ORDER BY dg.sort_order ASC");

			$departaments_data = $query->rows;

			//$this->cache->set('country.status', $country_data);
		//}

		return $departaments_data;
	}
}