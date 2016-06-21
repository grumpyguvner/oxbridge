<?php 
class ControllerModuleProEmail extends Controller {
	private $error = array(); 
  private $OC_V2;
  private $OC_V21;
  private $OC_V21X;
  private $OC_V22;
  private $OC_V22X;
	
  public function __construct($registry) {
		parent::__construct($registry);
    
    if (defined('JOOCART_SITE_URL')) {
      $this->OC_V2 = true;
    } else {
      $this->OC_V2 = substr(VERSION, 0, 1) == 2;
      $this->OC_V21 = substr(VERSION, 0, 3) == '2.1';
      $this->OC_V22 = substr(VERSION, 0, 3) == '2.2';
      $this->OC_V21X = version_compare(VERSION, '2.1', '>=');
      $this->OC_V22X = version_compare(VERSION, '2.2', '>=');
    }
    
    $this->load->model('tool/pro_email');
	}

	public function index() {
    // check tables
		$this->db_tables();
    
    $asset_path = 'view/pro_email/';

    $data['mijourl'] = $mijoshop_path = '';
    
    if (defined('JOOCART_SITE_URL')) {
      $data['mijourl'] = 'option=com_opencart&';
      $mijoshop_path = 'components/com_opencart/';
    } else if (defined('JPATH_MIJOSHOP_OC')) {
      $data['mijourl'] = 'option=com_mijoshop&';
      $mijoshop_path = 'components/com_mijoshop/opencart/';
    }

    if (defined('JPATH_MIJOSHOP_OC') && !$this->OC_V2) {

      $data['_img_path'] = 'admin/' . $asset_path . 'img/';

    } else if (defined('JOOCART_SITE_URL')) {
      $asset_path = JOOCART_COMPONENT_URL . 'admin/view/pro_email/';
      $data['_img_path'] = $asset_path . 'img/';
    } else {

      defined('JPATH_MIJOSHOP_OC') && $asset_path = 'admin/' . $asset_path;

      $data['_img_path'] = $asset_path . 'img/';

    }
    
		$data['_language'] = &$this->language;
		$data['_config'] = &$this->config;
		$data['_url'] = &$this->url;
		$data['token'] = $this->session->data['token'];
    $data['OC_V2'] = $this->OC_V2;
    $data['OC_V22X'] = $this->OC_V22X;
		
    // move img dir if not on v2
    if (!$this->OC_V2) {
      if(is_dir(DIR_IMAGE . 'catalog/pro_email')) {
        $this->dirmv(DIR_IMAGE . 'catalog/pro_email', DIR_IMAGE . 'data');
        if(is_dir(DIR_IMAGE . 'catalog/pro_email')) {
          $this->session->data['error'] = 'Auto move folder image failed: please move directory <b>/image/catalog/pro_email</b> into <b>/image/data</b>';
        }
      }
    }
    
    // reset temp config
    if (isset($this->session->data['tempPreviewConfig'])) {
      unset($this->session->data['tempPreviewConfig']);
    }
    
		if (!$this->OC_V2) {
			$this->document->addStyle($asset_path . 'awesome/css/font-awesome.min.css');
			$this->document->addStyle($asset_path . 'bootstrap.min.css');
			$this->document->addStyle($asset_path . 'bootstrap-theme.min.css');
			$this->document->addScript($asset_path . 'bootstrap.min.js');
		}
    
		$this->document->addScript($asset_path . 'selectize.js');
		$this->document->addStyle($asset_path . 'selectize.css');
		$this->document->addScript($asset_path . 'jquery.appear.js');
		$this->document->addScript($asset_path . 'itoggle.js');
    $this->document->addScript($asset_path . 'jquery.minicolors.min.js');
		$this->document->addStyle($asset_path . 'jquery.minicolors.css');
		$this->document->addStyle($asset_path . 'style.css');

		$this->language->load('module/pro_email');
    
    $this->load->model('localisation/language');
		
		$data['languages'] = $this->languages = $this->model_localisation_language->getLanguages();
    
    foreach ($data['languages'] as &$language) {
      if ($this->OC_V22X) {
        $language['image'] = 'language/'.$language['code'].'/'.$language['code'].'.png';
      } else {
        $language['image'] = 'view/image/flags/'. $language['image'];
      }
    }
    
		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

    // multi-stores management
		$this->load->model('setting/store');
		$data['stores'] = array();
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name')
		);

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$action = array();

			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		
		$data['store_id'] = $store_id = 0;
    
    // Overwrite store settings
		if (isset($this->request->get['store_id']) && $this->request->get['store_id']) {
			$data['store_id'] = $store_id = (int) $this->request->get['store_id'];
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '".$store_id."'");
			
			foreach ($query->rows as $setting) {
				if (!$setting['serialized']) {
					$this->config->set($setting['key'], $setting['value']);
        } else if ($this->OC_V21X) {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
				} else {
					$this->config->set($setting['key'], unserialize($setting['value']));
				}
			}
		}
    
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      // delete all
      $this->db->query("DELETE FROM " . DB_PREFIX . "proemail_content WHERE store = '".(int)$store_id."'");
      
      // then save content values in db
      foreach (array('proemail_type', 'proemail_status', 'proemail_custom') as $content_type) {
        if (isset($this->request->post[$content_type])) {
          foreach ($this->request->post[$content_type] as $type => $fields) {
            if($content_type == 'proemail_status') {
              $type = 'order.update.' . $type;
            }
            
            $insert_values = array();
            
            $insert_values = array();
            foreach ($fields as $field => $langs) {
              foreach ($langs as $lang => $value) {
                if (isset($insert_values[$lang])) {
                  $insert_values[$lang] .= $this->db->escape($field) . " = '" . $this->db->escape($value) . "', ";
                } else {
                  $insert_values[$lang] = $this->db->escape($field) . " = '" . $this->db->escape($value) . "', ";
                }
              }
            }
            foreach ($insert_values as $lang => $values) {
              $this->db->query("INSERT INTO " . DB_PREFIX . "proemail_content SET " . $values . " type = '" . $this->db->escape($type) . "', language_id = '" . (int) $lang . "', store = '".(int)$store_id."'");
            }
            
            unset($this->request->post[$content_type]);
          }
        }
      }
      
			$this->model_setting_setting->editSetting('proemail', $this->request->post, $store_id);				

			$this->session->data['success'] = $this->language->get('text_success');

      $redirect_store = '';
			if ($store_id) {
				$redirect_store = '&store_id=' . $store_id;
      }
      
      if ($this->OC_V2) {
				$this->response->redirect($this->url->link('module/pro_email', 'token=' . $this->session->data['token'] . $redirect_store, 'SSL'));
			} else {
				$this->redirect($this->url->link('module/pro_email', 'token=' . $this->session->data['token'] . $redirect_store, 'SSL'));
			}
		}

		$data['heading_title'] = strip_tags($this->language->get('heading_title'));

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

    if ($this->OC_V2) {
			$this->load->model('extension/extension');
			$extension_model = $this->model_extension_extension;
		} else {
			$this->load->model('setting/extension');
			$extension_model = $this->model_setting_extension;
		}

    $data['installed_modules'] = $extension_model->getInstalled('module');
    
    if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else $data['success'] = '';
		
		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else $data['error'] = '';
    
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),       		
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => strip_tags($this->language->get('heading_title')),
			'href'      => $this->url->link('module/pro_email', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('module/pro_email', 'token=' . $this->session->data['token'] . '&store_id=' . $store_id, 'SSL');
    
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

    if (is_file(DIR_SYSTEM.'../vqmod/xml/pro_email_template.xml')) {
			$data['module_version'] = simplexml_load_file(DIR_SYSTEM.'../vqmod/xml/pro_email_template.xml')->version;
		} else {
			$data['module_version'] = 'not found';
		}
    
    $data['templates'] = array();
		
		$layouts = glob(DIR_CATALOG . 'view/pro_email/layout/*.tpl');
    
		foreach ($layouts as $tpl) {
			$data['layouts'][] = array(
        'value' => basename($tpl, '.tpl'),
        'name' => ucwords(str_replace('_', ' ', basename($tpl, '.tpl'))),
        'img' => HTTP_CATALOG . $mijoshop_path . 'catalog/view/pro_email/layout/' . basename($tpl, '.tpl') . '.png'
        );
		}
		$data['json_layouts'] = json_encode($data['layouts']);
    
    $color_schemes = glob(DIR_CATALOG . 'view/pro_email/scheme/*.php');
    
    $data['color_schemes'] = array();
    
    foreach ($color_schemes as $file) {
      $scheme = include $file;
      $data['color_schemes'][] = array(
        'value' => json_encode($scheme),
        'name' => basename($file, '.php'),
        'scheme' => $scheme
        );
    }
		$data['color_schemes'] = json_encode($data['color_schemes']);
    
		if (isset($this->request->post['proemail_layout'])) {
			$data['proemail_layout'] = $this->request->post['proemail_layout'];
		} else {
			$data['proemail_layout'] = $this->config->get('proemail_layout');
		}
    
    $this->load->model('tool/image');
		
    $image_array = array('logo', 'bg_page', 'bg_top', 'bg_header', 'bg_body', 'bg_footer', 'bg_bottom');
    
    $config_theme = $this->config->get('proemail_theme');
    

    $data['proemail_theme']['width'] = isset($config_theme['width']) ? $config_theme['width'] : '';
    $data['proemail_theme']['width_unit'] = !empty($config_theme['width_unit']) ? $config_theme['width_unit'] : 'px';
      
    foreach ($image_array as $img) {
      
      if (isset($this->request->post['proemail_theme'][$img])) {
        $data['proemail_theme'][$img] = $this->request->post['proemail_theme'][$img];
      } else {
        $data['proemail_theme'][$img] = isset($config_theme[$img]) ? $config_theme[$img] : '';
      }
      
      if (isset($this->request->post['proemail_theme'][$img]) && file_exists(DIR_IMAGE . $this->request->post['proemail_theme'][$img])) {
        $data['thumb'][$img] = $this->model_tool_image->resize($this->request->post['proemail_theme'][$img], 200, 60);
      } elseif (!empty($config_theme[$img]) && file_exists(DIR_IMAGE . $config_theme[$img])) {
        $data['thumb'][$img] = $this->model_tool_image->resize($config_theme[$img], 200, 60);
      } else {
        if($this->OC_V2) {
          $data['thumb'][$img] = $this->model_tool_image->resize('no_image.png', 200, 60);
        } else {
          $data['thumb'][$img] = $this->model_tool_image->resize('no_image.jpg', 200, 60);
        }
      }
      
      if (isset($this->request->post['proemail_theme'][$img.'_repeat'])) {
        $data['proemail_theme'][$img.'_repeat'] = $this->request->post['proemail_theme'][$img.'_repeat'];
      } else {
        $data['proemail_theme'][$img.'_repeat'] = isset($config_theme[$img.'_repeat']) ? $config_theme[$img.'_repeat'] : '';
      }
    }
    
    if($this->OC_V2) {
      $data['no_image'] = $this->model_tool_image->resize('no_image.png', 200, 60);
    } else {
    $data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 200, 60);
    }
    
    if (isset($this->request->post['proemail_color'])) {
			$data['proemail_color'] = $this->request->post['proemail_color'];
		} else {
			$data['proemail_color'] = $this->config->get('proemail_color');
		}
    
    if (isset($this->request->post['proemail_from_name'])) {
			$data['proemail_from_name'] = $this->request->post['proemail_from_name'];
		} else {
			$data['proemail_from_name'] = $this->config->get('proemail_from_name');
		}
    
    if (isset($this->request->post['proemail_from_email'])) {
			$data['proemail_from_email'] = $this->request->post['proemail_from_email'];
		} else {
			$data['proemail_from_email'] = $this->config->get('proemail_from_email');
		}
    
    $data['from_name_placeholder'] = $data['proemail_from_name'];
    $data['from_email_placeholder'] = $data['proemail_from_email'];
    
    // Mail editor
    if (isset($this->request->get['store_id']) && $this->request->get['store_id']) {
      $store_config = $this->model_setting_setting->getSetting('config', $this->request->get['store_id']);
      $data['from_name_placeholder']['default'] = $store_config['config_name'];
      $data['from_email_placeholder']['default'] = $store_config['config_email'];
    } else {
      $data['from_name_placeholder']['default'] = $this->config->get('config_name');
      $data['from_email_placeholder']['default'] = $this->config->get('config_email');
    }
    
    $default_config = $this->getDefaultTplConfig();
    
    $data['mail_types'] = $data['mail_admin'] = array();
    
    $mail_types = glob(DIR_CATALOG . 'view/pro_email/content/*.tpl');
    
    // construct db array
    $rows = $this->db->query("SELECT * FROM `" . DB_PREFIX . "proemail_content` WHERE store = '".(int)$store_id."'")->rows;
    $db_mail_content = array();
    $db_status_content = array();
    
    foreach ($rows as $row) {
      if (substr($row['type'], 0, 12) == 'order.update') {
        $status_id = substr(strrchr($row['type'], '.'), 1);
        $db_status_content[$status_id]['subject'][$row['language_id']] = $row['subject'];
        $db_status_content[$status_id]['content'][$row['language_id']] = $row['content'];
        $db_status_content[$status_id]['from_name'][$row['language_id']] = $row['from_name'];
        $db_status_content[$status_id]['from_email'][$row['language_id']] = $row['from_email'];
        $db_status_content[$status_id]['file'][$row['language_id']] = $row['file'];
      } else {
        $db_mail_content[$row['type']]['subject'][$row['language_id']] = $row['subject'];
        $db_mail_content[$row['type']]['content'][$row['language_id']] = $row['content'];
        $db_mail_content[$row['type']]['from_name'][$row['language_id']] = $row['from_name'];
        $db_mail_content[$row['type']]['from_email'][$row['language_id']] = $row['from_email'];
        $db_mail_content[$row['type']]['file'][$row['language_id']] = $row['file'];
      }
    }
    
    
    $data['proemail_content'] = &$db_mail_content;
    
    $config_mail_types = $this->config->get('proemail_type');
    
    foreach ($mail_types as $type) {
      $type = basename($type, '.tpl');
      if ($type == 'order.update' || substr($type, 0, 5) == 'admin') continue;
      
      if (isset($this->request->post['proemail_type'][$type])) {
        $data['mail_types'][$type] = $this->request->post['proemail_type'][$type];
      } else if (isset($db_mail_content[$type])) {
        $data['mail_types'][$type] = $db_mail_content[$type];
      } else if (isset($config_mail_types[$type])) { // useless now, but kept to save old values
        $data['mail_types'][$type] = $config_mail_types[$type];
      } else {
        $data['mail_types'][$type] = $default_config[$type];
      }
    }
    
    foreach ($mail_types as $type) {
      $type = basename($type, '.tpl');
      if (substr($type, 0, 5) != 'admin') continue;
      
      if (isset($this->request->post['proemail_type'][$type])) {
        $data['mail_admin'][$type] = $this->request->post['proemail_type'][$type];
      } else if (isset($db_mail_content[$type])) {
        $data['mail_admin'][$type] = $db_mail_content[$type];
      } else {
        $data['mail_admin'][$type] = $default_config[$type];
      }
    }
    
    // custom content manager
    $data['mail_custom'] = array();
    
    foreach (glob(DIR_CATALOG . '../vqmod/xml/*.xml') as $xml) {
      //$custom_content = simplexml_load_file($xml);
      $custom_content = file_get_contents($xml);
      $pathinfo = pathinfo($xml);
      
      if (strpos($custom_content, '<proemail_custom/>')) {
        preg_match_all('#\'name\' => \'(.*?)\',#', $custom_content, $res);
        
        foreach ($res[1] as $custom_name) {
          $type = str_replace(array('"', "'", ' '), '_', $custom_name);
          
          if(!empty($db_mail_content['custom.'.$type])) {
            $data['mail_custom']['custom.'.$type] = $db_mail_content['custom.'.$type];
          }
          
          $data['mail_custom']['custom.'.$type]['name'] = $custom_name;
          //$data['mail_custom']['custom.'.$type]['file'] = $pathinfo['basename'];
        }
      }
      
    }
    
    $this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
    $config_mail_statuses = $this->config->get('proemail_status');
    
    foreach ($data['order_statuses'] as $key => $status) {
      if (isset($this->request->post['proemail_status'][$status['order_status_id']])) {
        $data['order_statuses'][$key] += $this->request->post['proemail_status'][$status['order_status_id']];
      } else if (isset($db_status_content[$status['order_status_id']])) {
        $data['order_statuses'][$key] += $db_status_content[$status['order_status_id']];
      } else if (isset($config_mail_statuses[$status['order_status_id']])) { // useless now, but kept to save old values
        $data['order_statuses'][$key] += $config_mail_statuses[$status['order_status_id']];
      } else {
        $data['order_statuses'][$key] += $default_config['order.update'];
      }
    }

		if ($this->OC_V2) {
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			
			$this->response->setOutput($this->load->view('module/pro_email.tpl', $data));
		} else {
			$data['column_left'] = '';
			$this->data = &$data;
			$this->template = 'module/pro_email.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
					
			$this->response->setOutput($this->render());
		}
	}

  public function modal_info() {
    $this->load->language('module/pro_email');
    
    $items = explode(',', $this->request->post['info']);
    
    $extra_class = $this->language->get('info_css_' . $items[0]) != 'info_css_' . $items[0] ? $this->language->get('info_css_' . $items[0]) : 'modal-lg';
    $title = $this->language->get('info_title_' . $items[0]) != 'info_title_' . $items[0] ? $this->language->get('info_title_' . $items[0]) : $this->language->get('info_title_default');
    
    $message = '';
    
    foreach ($items as $item) {
      $message .= $this->language->get('info_msg_' . trim($item)) != 'info_msg_' . trim($item) ? $this->language->get('info_msg_' . trim($item)) : $this->language->get('info_msg_default') .': ' . trim($item);
    }
      
    echo '<div class="modal-dialog ' . $extra_class . '">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-info-circle"></i> ' . $title . '</h4>
        </div>
        <div class="modal-body">' . $message . '</div>
      </div>
    </div>';
    
    die;
	}
  
  private function dirmv($source, $dest, $overwrite = true, $funcloc = NULL) {
    if(is_null($funcloc)){
      $dest .= '/' . strrev(substr(strrev($source), 0, strpos(strrev($source), '/')));
      $funcloc = '/';
    }

    if(!is_dir($dest . $funcloc))
      mkdir($dest . $funcloc); // make subdirectory before subdirectory is copied

    if($handle = opendir($source . $funcloc)){ // if the folder exploration is successful, continue
      while(false !== ($file = readdir($handle))){ // as long as storing the next file to $file is successful, continue
        if($file != '.' && $file != '..'){
          $path  = $source . $funcloc . $file;
          $path2 = $dest . $funcloc . $file;

          if(is_file($path)){
            if(!is_file($path2)){
              if(!@rename($path, $path2)){
                echo '<font color="red">File ('.$path.') could not be moved, likely a permissions problem.</font>';
              }
            } elseif($overwrite){
              if(!@unlink($path2)){
                echo 'Unable to overwrite file ("'.$path2.'"), likely to be a permissions problem.';
              } else
                if(!@rename($path, $path2)){
                  echo '<font color="red">File ('.$path.') could not be moved while overwritting, likely a permissions problem.</font>';
                }
            }
          } elseif(is_dir($path)){
            $this->dirmv($source, $dest, $overwrite, $funcloc . $file . '/'); //recurse!
            rmdir($path);
          }
        }
      }
      closedir($handle);
    }
    
    if($funcloc == '/') {
      @rmdir($source);
    }
  }

  public function getDefaultTplConfig() {
    $config = array();
    $contents = glob(DIR_CATALOG . 'view/pro_email/content/*.tpl');
    
    foreach ($this->languages as $lang) {
      if ($this->OC_V22) {
        $language = new ProEmailLanguage($lang['code']);
      } elseif (defined('_JEXEC')) {
        $language = new ProEmailLanguage($lang['locale']);
      } else {
        $language = new ProEmailLanguage($lang['directory']);
      }
      
      $replace = array();
      
      foreach ($contents as $tpl) {
        $type = basename($tpl, '.tpl');
        $html = file_get_contents($tpl);
        
        foreach ($language->data as $k => $v) {
          if(is_string($v)) {
            $replace['['.$k.']'] = $v;
          }
        }
        
        $config[$type]['subject'][$lang['language_id']] = str_replace(array_keys($replace), array_values($replace), $language->get('subject_'.$type));
        $config[$type]['content'][$lang['language_id']] = str_replace(array_keys($replace), array_values($replace), $html);
      }
    }

    return $config;
  }
  
  public function previewParams() {
    $this->session->data['tempPreviewConfig'] = $this->request->post;
    die;
  }
  
  public function saveColorScheme() {
    $this->language->load('module/pro_email');
    
    if (!$this->user->hasPermission('modify', 'module/pro_email')) {
      echo $this->language->get('error_permission');
      exit;
    }
    
    $x = 1;
    $filename = DIR_CATALOG . 'view/pro_email/scheme/scheme-'.$x.'.php';
    
    while (file_exists($filename)) {
      $x++;
      $filename = DIR_CATALOG . 'view/pro_email/scheme/scheme-'.$x.'.php';
    }
    
    file_put_contents($filename, '<?php return ' . var_export($this->request->post['proemail_color'], true) . ';');
    echo $this->language->get('text_color_scheme_saved');
    exit;
  }
  
	public function preview() {
    if(isset($this->session->data['tempPreviewConfig'])) {
      foreach ($this->session->data['tempPreviewConfig'] as $k => $v) {
        $this->config->set($k, $v);
      }
    } else {
      $type = 'customer.register';
    }
    
    if (!empty($this->request->get['type'])) {
      $type = $this->request->get['type'];
    } else {
      $type = 'customer.register';
    }
    
    if (strpos($type, '|')) {
      list($type, $param) = explode('|', $type);
    }
    
    $this->load->model('tool/pro_email');
    $params = array(
      'mode' => 'display',
      'type' => $type,
      'store_id' => $this->request->get['store_id'],
    );
    
    if (in_array($type, array('admin.order.confirm', 'order.confirm', 'order.update'))) {
    $last_order_id = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "order` ORDER BY order_id DESC")->row;
    
    if(!empty($last_order_id['order_id'])) {
      $last_order_id = $last_order_id['order_id'];
    }
    
      $params['order_id'] = $last_order_id;
    }

    if ($type == 'order.update') {
      $params['order_status_id'] = $param;
    }
    
	// email testing
    if (0) {
      $mail = new Mail($this->config->get('config_mail'));
      $mail->setTo('sirius_box-dev@yahoo.fr');
      $mail->setFrom($this->config->get('config_email'));
      $mail->setSender('Pro email template');
      $mail->setSubject('Test');
      
      $params['mail'] = $mail;
      $params['store_id'] = 0;
      
      $this->model_tool_pro_email->generate($params);
      
      unset($params['mail']);
    }
    
    echo $this->model_tool_pro_email->generate($params);
    exit;
  }
  
  public function restore_content() {
    $lang = '';
    if (isset($this->request->get['language_id'])) {
      $lang = "AND language_id = '".(int) $this->request->get['language_id']."'";
    }
      
    $this->db->query("DELETE FROM " . DB_PREFIX . "proemail_content WHERE type NOT LIKE 'custom.%' AND type NOT LIKE 'common.%' ".$lang);
    
    if ($this->OC_V2) {
      $this->response->redirect($this->url->link('module/pro_email', 'token=' . $this->session->data['token'] . $redirect_store, 'SSL'));
    } else {
      $this->redirect($this->url->link('module/pro_email', 'token=' . $this->session->data['token'] . $redirect_store, 'SSL'));
    }
  }
  
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/pro_email')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
  
  private function db_tables() {
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "proemail_content` (
        `content_id` int(11) NOT NULL AUTO_INCREMENT,
        `type` varchar(255) NOT NULL,
        `from_name` varchar(255) NOT NULL DEFAULT '',
        `from_email` varchar(255) NOT NULL DEFAULT '',
        `subject` varchar(255) NOT NULL,
        `content` text NOT NULL,
        `template` varchar(32) NOT NULL DEFAULT '',
        `file` varchar(255) NOT NULL DEFAULT '',
        `language_id` int(11) NOT NULL DEFAULT '0',
        `store` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`content_id`,`language_id`),
        KEY `type` (`type`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    
		if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order` LIKE 'date_invoice'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `date_invoice` DATETIME");
    if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "proemail_content` LIKE 'from_name'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "proemail_content` ADD `from_name` varchar(255) NOT NULL DEFAULT ''");
    if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "proemail_content` LIKE 'from_email'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "proemail_content` ADD `from_email` varchar(255) NOT NULL DEFAULT ''");
    if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "proemail_content` LIKE 'template'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "proemail_content` ADD `template` varchar(32) NOT NULL DEFAULT ''");
    if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "proemail_content` LIKE 'file'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "proemail_content` ADD `file` varchar(255) NOT NULL DEFAULT ''");
    if(!$this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "proemail_content` LIKE 'store'")->row)
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "proemail_content` ADD `store` int(4) NOT NULL DEFAULT '0'");
	}
  
  public function fileupload() {
		$this->load->language('catalog/download');
		//$this->load->language('module/pro_email');

		$json = array();

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'module/pro_email')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				// if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
					// $json['error'] = $this->language->get('error_filename');
				// }

				// Allowed file extension types
				$allowed = array();

				if($this->config->get('config_file_ext_allowed')) {
          $extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));
        } else {
          $extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_extension_allowed'));
        }

				$filetypes = explode("\n", $extension_allowed);

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Allowed file mime types
				$allowed = array();

				$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

				$filetypes = explode("\n", $mime_allowed);

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($this->request->files['file']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->language->get('error_filetype');
				}

				// Return any upload error
				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
				}
			} else {
				$json['error'] = $this->language->get('error_upload');
			}
		}

		if (!$json) {
			//$file = $filename . '.' . md5(mt_rand());
      
      if (!is_dir(DIR_DOWNLOAD . 'pro_email')) {
        mkdir(DIR_DOWNLOAD . 'pro_email');
      }
      
			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . 'pro_email/'. $filename);

			$json['filename'] = $filename;
			//$json['mask'] = $filename;

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
  public function install() {
    // check tables
		$this->db_tables();
    
		$this->load->model('setting/setting');
		/*
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		$ml_settings = array();
		foreach($languages as $language)
		{
			$ml_settings['pdf_invoice_filename_'.$language['language_id']] = 'Invoice';
		}
    */
		
		$this->model_setting_setting->editSetting('proemail', array(
			'proemail_layout' => 'simple_clean',
			'proemail_color' => include DIR_CATALOG . 'view/pro_email/scheme/light_opencart.php',
			'proemail_theme' => array(
        'logo' => $this->config->get('config_logo'),
        ),
      ));
	}
}
?>