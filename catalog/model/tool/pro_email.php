<?php
class ProEmailLanguage {
	private $default = 'english';
	private $directory;
	public $data = array();

	public function __construct($directory) {
		$this->directory = $directory;
		$this->load($directory);
		$this->load('module/pro_email');
	}

	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : $key);
	}

	public function load($filename) {
		$file = DIR_SYSTEM . '../catalog/language/' . $this->directory . '/' . $filename . '.php';
		
		if (file_exists($file)) {
			$_ = array();
			require($file);
			$this->data = array_merge($this->data, $_);
			return $this->data;
		}

		$file = DIR_SYSTEM . '../catalog/language/' . $this->default . '/' . $filename . '.php';

		if (file_exists($file)) {
			$_ = array();
			require($file);
			$this->data = array_merge($this->data, $_);
			return $this->data;
		} else {
			return $this->data;
			//trigger_error('Error: Could not load language ' . $filename . '!');
		}
	}
}

class ModelToolProEmail extends Model {

  private $language;
  private $basepath;
  private $http_image;
  private $order_model;
  private $order_model2;
  private $custom_field_model;
  private $template_path;
  private $admin_template;
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
    
    if (defined('PRO_EMAIL_ADMIN')) {
			$this->basepath = (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) ? HTTPS_CATALOG : HTTP_CATALOG;
			$this->load->model('sale/order');
			$this->order_model = 'model_sale_order';
			$this->order_model2 = 'model_sale_order';
      if ($this->config->get('proemail_custom_fields')) {
        $this->load->model('sale/custom_field');
        $this->custom_field_model = 'model_sale_custom_field';
      }
			$this->template_path = '../../../catalog/view/';
		} else {
      if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
        $this->basepath = ($this->config->get('config_ssl')) ? $this->config->get('config_ssl') : HTTPS_SERVER;
      } else {
        $this->basepath = ($this->config->get('config_url')) ? $this->config->get('config_url') : HTTP_SERVER;
      }
			$this->load->model('account/order');
			$this->order_model = 'model_checkout_order';
			$this->order_model2 = 'model_account_order';
			$this->load->model('checkout/order');
			if ($this->config->get('proemail_custom_fields')) {
        $this->load->model('account/custom_field');
        $this->custom_field_model = 'model_account_custom_field';
      }
			$this->template_path = '../';
		}
    
    $this->asset_path = DIR_SYSTEM . '../catalog/view/pro_email/';
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->http_image = defined('_JEXEC') ? HTTPS_IMAGE : $this->basepath . 'image/';
		} else {
			$this->http_image = defined('_JEXEC') ? HTTP_IMAGE : $this->basepath . 'image/';
		}
  }
  
  
	/**************************
	*
	* @orders: order numbers
	* @mode: display, file, backup
	* @type: invoice, packingslip
	*
	***************************/
	public function generate($params = array()) {
    $mijourl = defined('_JEXEC') ? 'option=com_mijoshop&' : '';
		$data['config'] = $this->config;
    // default config
    $default_params = array(
      'mode' => 'send',
    );
    
    $params = array_merge($default_params, $params);
    
    if (!empty($params['name'])) {
      $type = 'custom.' . str_replace(array('"', "'", ' '), '_', $params['name']);;
    } else {
      $type = $params['type'];
    }
    
    if (substr($type, 0, 5) == 'admin') {
      $this->admin_template = true;
    }
    
    // theme default config
    $data['theme'] = array(
      'logo' => '',
      'width' => '',
      'width_unit' => '',
      'bg_page' => '',
      'bg_page_repeat' => '',
      'bg_top' => '',
      'bg_top_repeat' => '',
      'bg_header' => '',
      'bg_header_repeat' => '',
      'bg_body' => '',
      'bg_body_repeat' => '',
      'bg_footer' => '',
      'bg_footer_repeat' => '',
      'bg_bottom' => '',
      'bg_bottom_repeat' => '',
    );
    // color default config
    $data['color'] = array(
      'text' => '',
      'text_top' => '',
      'text_head' => '',
      'text_foot' => '',
      'text_bottom' => '',
      'link' => '',
      'link_top' => '',
      'link_head' => '',
      'link_foot' => '',
      'link_bottom' => '',
      'btn' => '',
      'btn_text' => '',
      'bg_page' => '',
      'bg_top' => '',
      'bg_header' => '',
      'bg_body' => '',
      'bg_footer' => '',
      'bg_bottom' => '',
    );
    
    $replace = array();
    
    if (!empty($params['order_info'])) {
      $order_info = &$params['order_info'];
    } elseif (!empty($params['order_id'])) {
      $order_info = $this->{$this->order_model}->getOrder($params['order_id']);
    }
    
    // Overwrite store settings
    $store_id = 0;
    
    if (isset($params['store_id'])) {
      $store_id = $params['store_id'];
    } else if (!empty($order_info['store_id'])) {
      $store_id = $order_info['store_id'];
    }
    
    if (!empty($store_id)) {
      $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '".(int) $store_id."'");
      
      foreach ($query->rows as $setting) {
        if (!$setting['serialized']) {
          $this->config->set($setting['key'], $setting['value']);
        } else if ($this->OC_V21X) {
					$this->config->set($setting['key'], json_decode($setting['value'], true));
        } else {
          $this->config->set($setting['key'], unserialize($setting['value']));
        }
      }
      
      $this->basepath = $this->config->get('config_url');
    }
    
    $replace['{store_name}'] = $this->config->get('config_name');
    $replace['{store_url}'] = $this->config->get('config_url') ? $this->config->get('config_url') : HTTP_CATALOG;
    
    $data['theme'] = array_merge($data['theme'], (array) $this->config->get('proemail_theme'));
		$data['color'] = array_merge($data['color'], (array) $this->config->get('proemail_color'));

    // set language id
    if (!empty($params['lang'])) {
      $lang = $params['lang'];
    } elseif (!empty($order_info)) {
      $lang = $order_info['language_id'];
    } else {
      $lang = $this->config->get('config_language_id');
    }
    
    //language
    $this->load->model('localisation/language');
    
    $user_lang = $this->model_localisation_language->getLanguage($lang);

    if (defined('_JEXEC')) {
      $this->language = new ProEmailLanguage($user_lang['locale']);
    } else {
      $this->language = new ProEmailLanguage($user_lang['directory']);
    }
    
    //$data['language'] = $this->language;
    
    // get current config
    $tpl_conf = array();

    // fix order info status id when coming from order confirm
    if (!empty($params['order_status_id']) && !empty($order_info)) {
      $order_info['order_status_id'] = $params['order_status_id'];
    }
    
    if (!empty($params['order_status_id']) && $type == 'order.update') {
      if ($params['mode'] != 'display') {
        $tpl_conf = $this->db->query("SELECT from_name, from_email, subject, content, file FROM `" . DB_PREFIX . "proemail_content` WHERE type = 'order.update." . (int) $params['order_status_id'] . "' AND language_id = '". (int) $lang ."' AND store = '".(int)$store_id."'")->row;
      }
      
      if (!$tpl_conf) {
        $config_statuses = $this->config->get('proemail_status');
        
        if (is_array($config_statuses) && array_key_exists($params['order_status_id'], $config_statuses)) {
          $tpl_conf = $config_statuses[$params['order_status_id']];
          $tpl_conf['from_name'] = $tpl_conf['from_name'][$lang];
          $tpl_conf['from_email'] = $tpl_conf['from_email'][$lang];
          $tpl_conf['content'] = $tpl_conf['content'][$lang];
          $tpl_conf['subject'] = $tpl_conf['subject'][$lang];
          $tpl_conf['file'] = $tpl_conf['file'][$lang];
        }
      }
    } else {
      if ($params['mode'] != 'display') {
        $tpl_conf = $this->db->query("SELECT from_name, from_email, subject, content, file FROM `" . DB_PREFIX . "proemail_content` WHERE type = '" . $this->db->escape($type) . "' AND language_id = '". (int) $lang ."' AND store = '".(int)$store_id."'")->row;
      }
      
      if (!$tpl_conf) {
        if (strpos($type, 'custom.') !== false) {
          $config_types = (array) $this->config->get('proemail_custom');
        } else {
          $config_types = (array) $this->config->get('proemail_type');
        }
        
        if (array_key_exists($type, $config_types)) {
          $tpl_conf = $config_types[$type];
          $tpl_conf['from_name'] = $tpl_conf['from_name'][$lang];
          $tpl_conf['from_email'] = $tpl_conf['from_email'][$lang];
          $tpl_conf['content'] = $tpl_conf['content'][$lang];
          $tpl_conf['subject'] = $tpl_conf['subject'][$lang];
          $tpl_conf['file'] = $tpl_conf['file'][$lang];
        }
      }
    }
    
    if ($params['mode'] != 'display' || !$this->config->get('proemail_type')) {
      $common_query = $this->db->query("SELECT type, content FROM `" . DB_PREFIX . "proemail_content` WHERE type LIKE 'common.%' AND language_id = '". (int) $lang ."'")->rows;
      
      foreach($common_query as $val) {
        $value = html_entity_decode($val['content'], ENT_QUOTES, 'UTF-8');
        //if (strip_tags($value)) {
          $data[str_replace('common.', '', $val['type'])] = $value;
        //}
      }
    } else {
      $common_query = (array) $this->config->get('proemail_type');
      
      foreach($common_query as $key => $val) {
        if (strpos($key, 'common.') !== false) {
          $value = html_entity_decode($val['content'][$lang], ENT_QUOTES, 'UTF-8');
          //if (strip_tags($value)) {
            $data[str_replace('common.', '', $key)] = $value;
          //}
        }
      }
    }
    
		$this->load->model('setting/setting');
    
    $data['direction'] = $this->language->get('direction');
    
    $data['img_path'] = $this->http_image;
    
    if ($this->config->get('no-image')) {
      $data['img_path'] = '___';
    }
    
    //$data['logo'] = $this->http_image . $this->config->get('proemail_logo');
    $data['store_name'] = !empty($order_info['store_name']) ? $order_info['store_name'] : $this->config->get('config_name');
    $data['store_url'] = !empty($order_info['store_url']) ? $order_info['store_url'] : $this->config->get('config_url');
    
    // content forced / content from sql conf / content from tpl
    if (!empty($params['content'])) {
      $data['main_content'] = $params['content'];
    } else if (!empty($tpl_conf['content'])) {
      $data['main_content'] = html_entity_decode($tpl_conf['content'], ENT_QUOTES, 'UTF-8');
    } else {
      $data['main_content'] = html_entity_decode($this->getDefaultContent($type), ENT_QUOTES, 'UTF-8');
    }
    
    $tpl_file = str_replace('catalog/', '', DIR_APPLICATION) . '';
    
    if (file_exists(DIR_TEMPLATE . $this->template_path . 'pro_email/layout/' . $this->config->get('proemail_layout') . '.tpl')) {
      $tpl_file = $this->template_path . 'pro_email/layout/' . $this->config->get('proemail_layout') . '.tpl';
    }else{
      $tpl_file = $this->template_path . 'pro_email/layout/simple_clean.tpl';
    }
    
    if ($this->OC_V22X) {
      $template = new Template('basic');
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      $mail_html = $template->render($tpl_file);
    } elseif (method_exists($this->load, 'view')) {
      $mail_html = $this->load->view($tpl_file, $data);
    } else {
      $template = new Template();
      $template->data = &$data;
      $mail_html = $template->fetch($tpl_file);
    }
    
    // language tag replacement
    foreach ($this->language->data as $k => $v) {
      if (is_string($v)) {
        $replace['['.$k.']'] = $v;
      }
    }
    
    $mail_html = str_replace(array_keys($replace), array_values($replace), $mail_html);
    
    // customer information
    if (!empty($params['customer_id'])) {
      $customer = $this->db->query("SELECT firstname, lastname, email, telephone, customer_group_id FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$params['customer_id'] . "'")->row;
      
      foreach ($customer as $k => $v) {
        if (is_string($v)) {
          $replace['{'.$k.'}'] = $v;
        }
      }

      $customer_group = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int)$customer['customer_group_id'] . "' AND cgd.language_id = '" . (int)$lang . "'")->row;
      
      $replace['{customer_group}'] = $customer_group['name'];
      $replace['{customer_group_desc}'] = $customer_group['description'];
      
      $params['conditions']['approval'] = $customer_group['approval'];
    }
    
    // affiliate information
    if (!empty($params['affiliate_id'])) {
      $customer = $this->db->query("SELECT firstname, lastname, email, telephone, customer_group_id FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$params['customer_id'] . "'")->row;
      $affiliate = $this->db->query("SELECT firstname, lastname, email, telephone, website, company FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$params['affiliate_id'] . "'");
      
      foreach ($affiliate as $k => $v) {
        if (is_string($v)) {
          $replace['{'.$k.'}'] = $v;
        }
      }
    }
    
    // tags replacement
    if (!empty($params['data'])) {
      foreach ($params['data'] as $k => $v) {
        if (is_string($v)) {
          $replace['{'.$k.'}'] = $v;
        }
      }
    }
    
    if (!empty($params['conditions'])) {
      foreach ($params['conditions'] as $k => $v) {
        if ($v) {
          $replace['[if_'.$k.']'] = $replace['[/if_'.$k.']'] = '';
        } else {
          $replace['[if_not_'.$k.']'] = $replace['[/if_not_'.$k.']'] = '';
        }
      }
    }
    
    // $replace['{account_url}'] = $this->url->link('account/login', '', 'SSL');
    // $replace['{affiliate_url}'] = $this->url->link('affiliate/account', '', 'SSL');

    $replace['{order_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=account/order';
    
    $replace['{account_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=account/login';
    $replace['{affiliate_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=affiliate/account';
    
    $replace['{store_phone}'] = $this->config->get('config_telephone');
    $replace['{store_email}'] = $this->config->get('config_email');
      
    // order info handling
    if (!empty($order_info)) {
      foreach ($order_info as $k => $v) {
        if (is_string($v)) {
          $replace['{'.$k.'}'] = $v;
        }
      }

      if (strpos($mail_html, '{order_status}') !== false) {
        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_info['order_status_id'] . "' AND language_id = '" . (int)$lang . "'")->row;
        if (!empty($order_status_query['name'])) {
          $replace['{order_status}'] = $order_status_query['name'];
        } else {
          $replace['{order_status}'] = $this->language->get('text_no_order_status');
        }
      }
      
      if ($order_info['store_id']) {
        $store_info = $this->db->query("SELECT `key`, `value` FROM " . DB_PREFIX . "setting WHERE `key` IN ('config_telephone', 'config_email') AND store_id = '" . (int)$order_info['store_id'] . "'")->rows;
        if ($store_info) {
          $replace['{store_phone}'] = $store_info['config_telephone'];
          $replace['{store_email}'] = $store_info['config_email'];
        }
      }
    
      if ($this->config->get('ordIdMan_rand_ord_num')) {
        $replace['{order_id}'] = $order_info['order_id_user'];
        $replace['{order_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=account/order/info&order_id=' . $order_info['order_id_user'];
      } else {
        $replace['{order_url}'] = $this->basepath . 'index.php?'.$mijourl.'route=account/order/info&order_id=' . $order_info['order_id'];
      }
      
      $replace['{total}'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
      
      if ($order_info['customer_id']) {
        $replace['[if_customer]'] = $replace['[/if_customer]'] = '';
      }
      
      if (!empty($order_info['comment'])) {
        $replace['[if_comment]'] = $replace['[/if_comment]'] = '';
      }
      
      $replace['[if_payment:'.$order_info['payment_code'].']'] = $replace['[/if_payment:'.$order_info['payment_code'].']'] = '';
      
      // Quick status updater tags
      if (!empty($order_info['tracking_no'])) {
        $replace['[if_tracking]'] = $replace['[/if_tracking]'] = '';
      }
      
      if (!empty($order_info['tracking_url'])) {
        $replace['{tracking_link}'] = '<a href="' . $order_info['tracking_url'] . '">' . $order_info['tracking_url'] . '</a>';
      }
      
      // custom inputs
      if (isset($this->request->post['custom_inputs'])) {
        foreach($this->request->post['custom_inputs'] as $k => $v) {
          $replace['{'.$k.'}'] = $v;
        }
      }
            
      $replace['{download_url}'] = $order_info['store_url'] . 'index.php?'.$mijourl.'route=account/download';
      
      if (strpos($mail_html, '[if_download]') !== false) {
        if (substr(VERSION, 0, 1) == 2) {
          $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_info['order_id'] . "'");

          foreach ($order_product_query->rows as $order_product) {
            $product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");

            if ($product_download_query->row['total']) {
              $replace['[if_download]'] = $replace['[/if_download]'] = '';
              break;
            }
          }
        } else {
          if ($this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_info['order_id'] . "'")->num_rows) {
            $replace['[if_download]'] = $replace['[/if_download]'] = '';
          }
        }
      }
    
      if (strpos($mail_html, '{invoice}') !== false) {
        if (!empty($params['order_comment'])) {
          $order_info['order_comment'] = $params['order_comment'];
        }
        $replace['{invoice}'] = $this->getDefaultInvoice($order_info);
      }
    
    }
    
    if (!empty($params['order_status_id']) && $type == 'order.update') {
      if (!empty($params['order_status_name'])) {
        $replace['{order_status}'] = $params['order_status_name'];
      } else {
        $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$params['order_status_id'] . "' AND language_id = '" . (int)$lang . "'")->row;
        $replace['{order_status}'] = $order_status_query['name'];
      }
    }
    
    #custom_tags
    $mail_html = str_replace(array_keys($replace), array_values($replace), $mail_html);
    $mail_html = preg_replace('/\[button=(.*)\](.*)\[\/button\]/isU', '<a href="$1" class="button">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[button href="(.*)"\](.*)\[\/button\]/isU', '<a href="$1" class="button">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[link=(.*)\](.*)\[\/link\]/isU', '<a href="$1">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[link href="(.*)"\](.*)\[\/link\]/isU', '<a href="$1">$2</a>', $mail_html);
    $mail_html = preg_replace('/\[if_([\:\w]+)\](.*)\[\/if_([\:\w]+)\]/isU', '', $mail_html);
    if ($params['mode'] == 'display') {$replace['<a href='] = '<a target="_blank" href=';}
    $mail_html = str_replace(array_keys($replace), array_values($replace), $mail_html);

    if (!class_exists('Emogrifier')) {
      require_once(DIR_SYSTEM . 'library/Emogrifier.php');
    }

    if ($this->config->get('proemail_layout') == '_text_only') {
      require_once(DIR_SYSTEM . 'library/Html2Text.php');
      $mail_html = Html2Text::convert(str_replace('&', '&amp;', $mail_html));
    } else {
      $emogrifier = new Emogrifier($mail_html);
      $mail_html = $emogrifier->emogrify();
    }
    
    if (false) {
      $params['mail'] = new Mail();
      $params['mail']->setFrom($this->config->get('config_email'));
      $params['mail']->setSender($this->config->get('config_name'));
      $params['mail']->setTo('sirius_box-dev@yahoo.fr');
      $params['mail']->setSubject('Test');
    }
    
    if (!empty($params['mail'])) {
      if ($this->config->get('proemail_attachment___')) {
        $params['mail']->addAttachment($this->config->get('proemail_attachment___'));
      }
      
      if (!empty($tpl_conf['subject'])) {
        $params['mail']->setSubject(str_replace(array_keys($replace), array_values($replace), $tpl_conf['subject']));
      } else if (($this->language->get('subject_'.$type) != 'subject_'.$type) && $this->language->get('subject_'.$type)) {
        $params['mail']->setSubject(str_replace(array_keys($replace), array_values($replace), $this->language->get('subject_'.$type)));
      }
      
      $from_name = $this->config->get('proemail_from_name');
      $from_email = $this->config->get('proemail_from_email');
      
      if (!empty($tpl_conf['from_name'])) {
        $params['mail']->setSender($tpl_conf['from_name']);
      } else if (!empty($from_name[$lang])) {
        $params['mail']->setSender($from_name[$lang]);
      }
      
      if (!empty($tpl_conf['from_email'])) {
        $params['mail']->setFrom($tpl_conf['from_email']);
      } else if (!empty($from_email[$lang])) {
        $params['mail']->setFrom($from_email[$lang]);
      }
      
      $params['mail']->setHtml($mail_html);
      
      // attachement
      if (!empty($tpl_conf['file']) && file_exists(DIR_DOWNLOAD . 'pro_email/' . $tpl_conf['file'])) {
        $params['mail']->addAttachment(DIR_DOWNLOAD . 'pro_email/' . $tpl_conf['file']);
      }
      
      $params['mail']->send();
    } elseif ($params['mode'] == 'display') {
      if ($this->config->get('proemail_layout') == '_text_only') {
        $mail_html = '<html><body style="background:#fefefe;color:#444;font-family:arial,sans-serif;padding:15px;white-space: pre-wrap;">' . $mail_html . '</body></html>';
      }
      echo $mail_html; exit;
    } else {
      return $mail_html;
    }
  }
	
  public function getDefaultContent($type) {
    if (is_file($this->asset_path . 'content/' . $type . '.tpl')) {
      return file_get_contents($this->asset_path . 'content/' . $type . '.tpl');
    }
    
    return '';
  }
  
  private function getDefaultInvoice($order_info) {
    $data['config'] = $this->config;
    $data['order'] = $order_info;

    $data['language'] = $this->language;
    
    //data
    $data['title'] = $this->language->get('heading_title');

    $data['text_invoice'] = $this->language->get('text_invoice');

    $data['text_order_id'] = $this->language->get('text_order_id');
    $data['text_invoice_no'] = $this->language->get('text_invoice_no');
    $data['text_invoice_date'] = $this->language->get('text_invoice_date');
    $data['text_date_added'] = $this->language->get('text_date_added');
    $data['text_date_due'] = $this->language->get('text_date_due');
    $data['text_telephone'] = $this->language->get('text_telephone');
    $data['text_email'] = $this->language->get('text_email');
    $data['text_fax'] = $this->language->get('text_fax');
    $data['text_url'] = $this->language->get('text_url');
    $data['text_company_id'] = $this->language->get('text_company_id');
    $data['text_tax_id'] = $this->language->get('text_tax_id');		
    $data['text_payment_method'] = $this->language->get('text_payment_method');
    $data['text_shipping_method'] = $this->language->get('text_shipping_method');

    $data['text_product'] = $this->language->get('column_product');
    $data['text_model'] = $this->language->get('column_model');
    $data['text_quantity'] = $this->language->get('column_quantity');
    $data['text_weight'] = $this->language->get('column_weight');
    $data['text_price'] = $this->language->get('column_price');
    $data['text_tax'] = $this->language->get('column_tax');
    $data['text_total'] = $this->language->get('column_total');
    
    //missing values
    $data['text_customer_id'] = $this->language->get('text_customer_id');
    $data['text_order_detail'] = $this->language->get('text_order_detail');
    $data['text_payment_address'] = $this->language->get('text_payment_address');
    $data['text_shipping_address'] = $this->language->get('text_shipping_address');
    $data['text_email'] = $this->language->get('text_email');
    $data['base'] = $this->basepath;
    
    //comment
    $data['text_instruction'] =  $this->language->get('text_instruction');
    $data['comment'] = '';
    if (!empty($order_info['order_comment'])) {
      $data['comment'] = $order_info['order_comment'];
    }
    
    $store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);
    
    if ($store_info) {
      $store_address = $store_info['config_address'];
      $store_email = $store_info['config_email'];
      $store_telephone = $store_info['config_telephone'];
      $store_fax = $store_info['config_fax'];
    } else {
      $store_address = $this->config->get('config_address');
      $store_email = $this->config->get('config_email');
      $store_telephone = $this->config->get('config_telephone');
      $store_fax = $this->config->get('config_fax');
    }
    
    if ($order_info['shipping_address_format']) {
      $format = $order_info['shipping_address_format'];
    } else {
      $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
    }

    $find = array(
      '{firstname}',
      '{lastname}',
      '{company}',
      '{address_1}',
      '{address_2}',
      '{city}',
      '{postcode}',
      '{zone}',
      '{zone_code}',
      '{country}'
    );

    $replace = array(
      'firstname' => $order_info['shipping_firstname'],
      'lastname'  => $order_info['shipping_lastname'],
      'company'   => $order_info['shipping_company'],
      'address_1' => $order_info['shipping_address_1'],
      'address_2' => $order_info['shipping_address_2'],
      'city'      => $order_info['shipping_city'],
      'postcode'  => $order_info['shipping_postcode'],
      'zone'      => $order_info['shipping_zone'],
      'zone_code' => $order_info['shipping_zone_code'],
      'country'   => $order_info['shipping_country']
    );

    $shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

    if ($order_info['payment_address_format']) {
      $format = $order_info['payment_address_format'];
    } else {
      $format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
    }

    $find = array(
      '{firstname}',
      '{lastname}',
      '{company}',
      '{address_1}',
      '{address_2}',
      '{city}',
      '{postcode}',
      '{zone}',
      '{zone_code}',
      '{country}'
    );

    $replace = array(
      'firstname' => $order_info['payment_firstname'],
      'lastname'  => $order_info['payment_lastname'],
      'company'   => $order_info['payment_company'],
      'address_1' => $order_info['payment_address_1'],
      'address_2' => $order_info['payment_address_2'],
      'city'      => $order_info['payment_city'],
      'postcode'  => $order_info['payment_postcode'],
      'zone'      => $order_info['payment_zone'],
      'zone_code' => $order_info['payment_zone_code'],
      'country'   => $order_info['payment_country']
    );

    $payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

    $product_data = array();
    
    $data['columns'] = array('image', 'product', 'model', 'price');
    
    $products = $this->{$this->order_model2}->getOrderProducts($order_info['order_id']);
    
    foreach ($products as $product) {
      $option_data = array();

      $options = $this->{$this->order_model2}->getOrderOptions($order_info['order_id'], $product['order_product_id']);
      
      $get_full_product = true;
      $full_product = array(
        'image' => null,
        'mpn' => null,
        'manufacturer_id' => null,
        'location' => null,
        'sku' => null,
        'weight' => null,
        'weight_class_id' => null,
      );
      
      if ($get_full_product) {
        $this->load->model('catalog/product');
        $full_product = array_merge($full_product, $this->model_catalog_product->getProduct($product['product_id']));
      }
      
      if (1) {
        $manufacturer = $this->getManufacturer($full_product['manufacturer_id']);
      }
        
      if (1) {
        $this->load->model('tool/image');
        $full_product['image'] = $this->model_tool_image->resize($this->getProductImage($product['product_id']), $this->config->get('proemail_thumbwidth') ? $this->config->get('proemail_thumbwidth') : 40, $this->config->get('proemail_thumbheight') ? $this->config->get('proemail_thumbheight'): 40);
      }
      
      foreach ($options as $option) {
        if ($option['type'] != "file") {
          $value = $option['value'];
        } else {
          $value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
        }
        
        $option_data[] = array(
          'name'  => $option['name'],
          'value' => $value
        );
      }
      
      $product_data[] = array(
        'product_id'=> $product['product_id'],
        'image'		=> $full_product['image'],
        'name'		=> $product['name'],
        'model'		=> $product['model'],
        'manufacturer'=> $manufacturer,
        'option'		=> $option_data,
        'quantity'	=> $product['quantity'],
        'weight'		=> $full_product['weight'] ? $this->weight->format($full_product['weight'], $full_product['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point')) : null,
        'price'		=> $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value']),
        'price_tax'	=> $this->currency->format($product['price'] + $product['tax'], $order_info['currency_code'], $order_info['currency_value']),
        'tax'			=> $this->currency->format($product['tax'], $order_info['currency_code'], $order_info['currency_value']),
        'tax_total'	=> $this->currency->format($product['tax'] * $product['quantity'], $order_info['currency_code'], $order_info['currency_value']),
        'tax_rate'	=> ($product['price'] > 0) ? round($product['tax']  / abs($product['price']) * 1, 2) * 100 . '%' : '',
        'total'		=> $this->currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']),
        'total_tax'	=> $this->currency->format($product['total'] + ($this->config->get('proemail_total_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
        'mpn'		=> $full_product['mpn'],
        'location'	=> $full_product['location'],
        'sku'			=> $full_product['sku'],
        'upc'			=> $full_product['upc'],
      );
    }
    
    $voucher_data = $vouchers = array();
    
    // 1.5.0 - 1.5.1 compatibility
    if (method_exists($this->{$this->order_model2}, 'getOrderVouchers')) {
      $vouchers = $this->{$this->order_model2}->getOrderVouchers($order_info['order_id']);
    }

    foreach ($vouchers as $voucher) {
      $voucher_data[] = array(
        'description' => $voucher['description'],
        'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])			
      );
    }
      
      $totals = $this->{$this->order_model2}->getOrderTotals($order_info['order_id']);
      $total_data = array();
    
    // strip html tags in total desc
    foreach ($totals as $total) {
      $total_data[] = array(
        'title' =>  strip_tags(html_entity_decode($total['title'], ENT_QUOTES, 'UTF-8')),
        'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
      );
    }
    
    $date_format = $this->language->get('date_format');
		if ($date_format == 'date_format') $date_format = 'd/m/Y';
      
    $data = array_merge($data, array(
      'order_id'	         => $this->config->get('ordIdMan_rand_ord_num') ? $order_info['order_id_user'] : $order_info['order_id'],
      'invoice_no'	       => $this->config->get('ordIdMan_rand_inv_num') ? $order_info['order_id_user'] : $order_info['invoice_no'],
      'invoice_prefix'     => $order_info['invoice_prefix'],
      'date_added'         => date($date_format, strtotime($order_info['date_added'])),
      'store_name'         => $order_info['store_name'],
      'store_url'          => rtrim($order_info['store_url'], '/'),
      'store_address'      => nl2br($store_address),
      'store_email'        => $store_email,
      'store_telephone'    => $store_telephone,
      'store_fax'          => $store_fax,
      'email'              => $order_info['email'],
      'telephone'          => $order_info['telephone'],
      'shipping_address'   => $shipping_address,
      'shipping_method'    => $order_info['shipping_method'],
      'payment_address'    => $payment_address,
      'payment_company_id' => isset($order_info['payment_company_id']) ? $order_info['payment_company_id'] : '',
      'payment_tax_id'     => isset($order_info['payment_tax_id']) ? $order_info['payment_tax_id'] : '',
      'payment_method'     => $order_info['payment_method'],
      'products'            => $product_data,
      'vouchers'            => $voucher_data,
      'totals'              => $total_data,
      //'comment'            => nl2br($order_info['comment'])
    ));
    
    if (file_exists(DIR_TEMPLATE . $this->template_path . 'pro_email/invoice/' . $this->config->get('proemail_invoice') . '.tpl')) {
      $tpl_file = $this->template_path . 'pro_email/invoice/' . $this->config->get('proemail_invoice') . '.tpl';
    }else{
      $tpl_file = $this->template_path . 'pro_email/invoice/default.tpl';
    }
    
    if ($this->OC_V22X) {
      $template = new Template('basic');
      foreach ($data as $key => $value) {
        $template->set($key, $value);
      }
      $invoice_html = $template->render($tpl_file);
    } elseif (method_exists($this->load, 'view')) {
      $invoice_html = $this->load->view($tpl_file, $data);
    } else {
      $template = new Template();
      $template->data = &$data;
      $invoice_html = $template->fetch($tpl_file);
    }
    
    return $invoice_html;
  }
    
	private function getProductImage($product_id) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "' LIMIT 1");
		return isset($query->row['image']) ? $query->row['image'] : '';
	}
	
	private function getManufacturer($manufacturer_id) {
		if (empty($manufacturer_id)) return '';
		
		$query = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

    if (isset($query->row['name'])) {
      return $query->row['name'];
    }
    
    return '';
	}
}