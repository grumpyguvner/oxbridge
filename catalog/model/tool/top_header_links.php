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

class ModelToolTopHeaderLinks extends Model {
    
    

	
	public function getHeadermenu(){
      
        $links = array();
        
        $main_links = $this->db->query("SELECT * FROM " . DB_PREFIX . "header_group fg 
        LEFT JOIN " . DB_PREFIX . "header_group_description fgd ON fg.header_group_id = fgd.header_group_id 
        WHERE fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY fg.sort_order ASC
        ");

		
        foreach($main_links->rows as $main_link){
            
            $sub_link = null;
            
            $links[$main_link['header_group_id']] = array(
                'main_link_names' => $main_link['name'],
                'main_group_id' => $main_link['header_group_id'],
                'columns' => $main_link['columns'],
                'link' => $main_link['link']
            );
            
            
            $sub_links = $this->db->query("SELECT H.sort_order, HD.* FROM " . DB_PREFIX . "header H
                LEFT JOIN " . DB_PREFIX . "header_description HD ON HD.header_id = H.header_id 
                WHERE 
                H.header_group_id = '" . (int)$main_link['header_group_id'] . "' AND 
                HD.language_id = '" . (int)$this->config->get('config_language_id')."' 
                ORDER BY H.sort_order ASC");

             foreach($sub_links->rows as $sub_link){
            
                 $links[$main_link['header_group_id']][$main_link['header_group_id']][] = array(
                    'sub_link_name' => $sub_link['name'],
                    'sub_link' => $sub_link['link'],
                    'columns' => $links[$main_link['header_group_id']]['columns']
                );
             } 
        }
              
        return $links;
        
    }
			
}
     
	
       