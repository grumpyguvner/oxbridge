<?php
class ControllerModuleAbandonedcarts extends Controller {
	// Main variables
	private $error 			= array();
	private $version 		= '4.1.2';
	private $moduleName 	= 'abandonedcarts';
	private $moduleModel	= 'model_module_abandonedcarts';
	
	// Main controller
	public function index() {   
		// Language
		$this->language->load('module/'.$this->moduleName);

		// Module variables
		$data['moduleName'] 		= $this->moduleName;
		$data['moduleNameSmall'] 	= $this->moduleName;
		$data['moduleModel'] 		= $this->moduleModel;
		
		// Models loading
		$this->load->model('setting/setting');
		$this->load->model('setting/store');
		$this->load->model('localisation/language');
		$this->load->model('design/layout');
		$this->load->model('module/'.$this->moduleName);
		
		// Title
		$this->document->setTitle($this->language->get('heading_title') . ' ' . $this->version);

		// Styles & scripts		
		$this->document->addStyle('view/stylesheet/'.$this->moduleName.'.css');		
		$this->document->addScript('view/javascript/'.$this->moduleName.'/cron.js');
		$this->document->addScript('view/javascript/'.$this->moduleName.'/nprogress.js');
		
		// Store data
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0;
        } 
		$store = $this->getCurrentStore($this->request->get['store_id']);
		
		// New fields
		$check_update = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "".$this->moduleName."` LIKE 'notified'");
		if (!$check_update->rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "".$this->moduleName."` ADD `notified` SMALLINT NOT NULL DEFAULT 0");
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "".$this->moduleName."` ADD `ordered` TINYINT NOT NULL DEFAULT 0");
		}
		
		// Saving data		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if (!empty($this->request->post['OaXRyb1BhY2sgLSBDb21'])) {
				$this->request->post[$this->moduleName]['LicensedOn'] = $this->request->post['OaXRyb1BhY2sgLSBDb21'];
			}
			if (!empty($this->request->post['cHRpbWl6YXRpb24ef4fe'])) {
				$this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($this->request->post['cHRpbWl6YXRpb24ef4fe']),true);
			}
			$store = $this->getCurrentStore($this->request->post['store_id']);
			
			$this->model_setting_setting->editSetting($this->moduleName, $this->request->post, $this->request->post['store_id']);
			$this->session->data['success'] = $this->language->get('text_success');

			if ($this->request->post[$this->moduleName]["ScheduleEnabled"] == 'yes') {
                $this->editCron($this->request->post, $store['store_id']);
            }
			
			$this->response->redirect($this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'] . '&store_id='.$store['store_id'], 'SSL'));
		}
		
		// Sucess & Error messages
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		// Language-dependant variables
		$languageVariables = array(
			'heading_title',
			'text_enabled',
			'text_disabled',
			'text_default',
			'entry_code', 
			'button_save',
			'button_cancel', 
			'button_add_module', 
			'button_remove'
			);

		foreach ($languageVariables as $languageVariable) {
			$data[$languageVariable] = $this->language->get($languageVariable);
		}
		$data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->version;	
		
		// Breadcrumbs
  		$data['breadcrumbs'] = array();
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title') . ' ' . $this->version,
			'href'      => $this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		// Variables
		$data['currency']				= $this->config->get('config_currency');
		$data['stores']					= array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $data['text_default'].')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
		$languages						= $this->model_localisation_language->getLanguages();
		$data['languages']				= $languages;
		$firstLanguage					= array_shift($languages);
		$data['firstLanguageCode']		= $firstLanguage['code'];
		$data['store']					= $store;
		$data['action']					= $this->url->link('module/'.$this->moduleName, 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel']					= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['moduleSettings']			= $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
        $data['moduleData']				= (isset($data['moduleSettings'][$this->moduleName])) ? $data['moduleSettings'][$this->moduleName] : array();
		$data['usedCoupons']			= $this->{$this->moduleModel}->getTotalUsedCoupons(); 
		$data['givenCoupons']			= $this->{$this->moduleModel}->getTotalGivenCoupons();
		$data['registeredCustomers']	= $this->{$this->moduleModel}->getTotalRegisteredCustomers();
		$data['totalCustomers']			= $this->{$this->moduleModel}->getTotalCustomers();
		$data['mostVisitedPages']		= $this->{$this->moduleModel}->getMostVisitedPages();
		$data['token']					= $this->session->data['token'];
		$data['e_mail']					= $this->config->get('config_email');
		
		$data['cronPhpPath'] = '0 0 * * *';
		if (function_exists('shell_exec') && trim(shell_exec('echo EXEC')) == 'EXEC') {
			$data['cronPhpPath'] .= shell_exec("which php"). ' ';
        } else {
			$data['cronPhpPath'] .= 'php ';
        }
		$data['cronPhpPath'] .= dirname(DIR_APPLICATION) . '/vendors/'.$this->moduleName.'/';
		$data['cronPhpPath'] .= 'vendors/abandonedcarts/sendReminder.php';
		
		// Template data
		$data['header']					= $this->load->controller('common/header');
		$data['column_left']			= $this->load->controller('common/column_left');
		$data['footer']					= $this->load->controller('common/footer');
		
		// Template load
		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'.tpl', $data));
	}
	
	// Get mail template data
	public function get_mailtemplate_settings() {
        $this->load->model('module/'.$this->moduleName);
        $this->load->model('setting/store');
		$this->load->model('setting/setting');
        $this->load->model('localisation/language');
		
 		$data['currency']						= $this->config->get('config_currency');	
		$data['languages']						= $this->model_localisation_language->getLanguages();
		$data['mailtemplate']['id']				= $this->request->get['mailtemplate_id'];
		$store_id								= $this->request->get['store_id'];
		$data['data']							= $this->model_setting_setting->getSetting($this->moduleName, $store_id);
		$data['moduleName']						= $this->moduleName;
		$data['moduleData']						= (isset($data['data'][$this->moduleName])) ? $data['data'][$this->moduleName] : array();
		$data['newAddition']					= true;
		
		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'/tab_mailtab.php', $data));
	}
	
	// Validation against users with no permissions	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'module/'.$this->moduleName)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	// Function that edits the cron jobs
	private function editCron($data=array(), $store_id) {
		if (function_exists('shell_exec') && trim(shell_exec('echo EXEC')) == 'EXEC') {
			$phpPath = shell_exec("which php");
        } else {
            $phpPath = 'php';
        }
		
        $cronCommands   = array();
        $cronFolder     = dirname(DIR_APPLICATION) . '/vendors/'.$this->moduleName.'/';
        $dateForSorting = array();
        if (isset($data[$this->moduleName]["ScheduleType"]) && $data[$this->moduleName]["ScheduleType"] == 'F') {
            if (isset($data[$this->moduleName]["FixedDates"])) {
                foreach ($data[$this->moduleName]["FixedDates"] as $date) {
                    $buffer           = explode('/', $date);
                    $bufferDate       = explode('.', $buffer[0]);
                    $bufferTime       = explode(':', $buffer[1]);
                    $cronCommands[]   = (int) $bufferTime[1] . ' ' . (int) $bufferTime[0] . ' ' . (int) $bufferDate[0] . ' ' . (int) $bufferDate[1] . ' * '.$phpPath.' ' . $cronFolder . 'sendReminder.php';
                    $dateForSorting[] = $bufferDate[2] . '.' . $bufferDate[1] . '.' . $bufferDate[0] . '.' . $buffer[1];
                }
                asort($dateForSorting);
                $sortedDates = array();
                foreach ($dateForSorting as $date) {
                    $newDate       = explode('.', $date);
                    $sortedDates[] = $newDate[2] . '.' . $newDate[1] . '.' . $newDate[0] . '/' . $newDate[3];
                }
                $data = $sortedDates;
            }
        }
        if (isset($data[$this->moduleName]["ScheduleType"]) && $data[$this->moduleName]["ScheduleType"] == 'P') {
            $cronCommands[] = $data[$this->moduleName]['PeriodicCronValue'] . ' '.$phpPath.' ' . $cronFolder . 'sendReminder.php';
        }
        if (isset($cronCommands)) {
            $cronCommands      = implode(PHP_EOL, $cronCommands);
            $currentCronBackup = shell_exec('crontab -l');
            $currentCronBackup = explode(PHP_EOL, $currentCronBackup);
            foreach ($currentCronBackup as $key => $command) {
                if (strpos($command, $phpPath.' ' . $cronFolder . 'sendReminder.php') || empty($command)) {
                    unset($currentCronBackup[$key]);
                }
            }
            $currentCronBackup = implode(PHP_EOL, $currentCronBackup);
            file_put_contents($cronFolder . 'cron.txt', $currentCronBackup . PHP_EOL . $cronCommands . PHP_EOL);
            exec('crontab -r');
            exec('crontab ' . $cronFolder . 'cron.txt');
        }
    }
	
	// Gets catalog url
	private function getCatalogURL(){
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }
	
	// Install module
	public function install() {
	    $this->load->model('module/'.$this->moduleName);
	    $this->{$this->moduleModel}->install();
    }
	
	// Uninstall module
	public function uninstall() {
        $this->load->model('module/'.$this->moduleName);
        $this->load->model('setting/store');
		
		$this->model_setting_setting->deleteSetting($this->moduleName,0);
		$stores=$this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$this->model_setting_setting->deleteSetting($this->moduleName, $store['store_id']);
		}
        $this->load->model('module/'.$this->moduleName);
        $this->{$this->moduleModel}->uninstall();
    }
	
	// Get the current abandoned carts
	public function getabandonedcarts() {
        if (!empty($this->request->get['page'])) {
            $page = (int) $this->request->get['page'];
        } else {
			$page = 1;	
		}
			
		if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0;
        } 
		
		if (isset($this->request->get['notified']) && $this->request->get['notified']=='1') {
		   	$data['notified'] = true;
		   	$data['forFilter'] = 'notified';
        } else {
			$data['notified'] = false;
		  	$data['forFilter'] = 'default';
		}
		
		if(isset($this->request->get['ordered']) && $this->request->get['ordered']=='1') {
		   	$data['ordered'] = true;
		  	$data['forFilter'] = 'ordered';
        } else {
			$data['ordered'] = false;
		}
		$url_link = '&store_id='.$this->request->get['store_id'];
		$data['filterURL'] = $this->url->link('module/'.$this->moduleName.'/getabandonedcarts','token=' . $this->session->data['token'].$url_link, 'SSL');
		
        $this->load->model('module/'.$this->moduleName);
		$this->load->model('tool/image');
		$this->load->model('setting/setting');
		
		if (VERSION >= '2.1.0.1'){
			$this->load->model('customer/customer');
			$data['this->model_sale_customer'] 	= $this->model_customer_customer;	
		}else {
			$this->load->model('sale/customer');	
			$data['this->model_sale_customer'] 	= $this->model_sale_customer;	
		}
		
		
		$data['this->model_tool_image'] 	= $this->model_tool_image;
		$data['this->currency'] 			= $this->currency;
		$data['this->url'] 					= $this->url;

		$data['store_id']			= $this->request->get['store_id'];
		$data['token']				= $this->session->data['token'];
		$data['limit']				= 8; // $this->config->get('config_limit_admin')
		$data['total']				= $this->{$this->moduleModel}->getTotalAbandonedCarts($data['store_id'], $data['notified'], $data['ordered']);
		
		$moduleSettings				= $this->model_setting_setting->getSetting($this->moduleName, $data['store_id']);
		$moduleSettings				= (isset($moduleSettings[$this->moduleName])) ? $moduleSettings[$this->moduleName] : array();
		
		$data['usable_templates']	= array();
		if (isset($moduleSettings['MailTemplate']) && sizeof($moduleSettings['MailTemplate'])>0) {
			foreach ($moduleSettings['MailTemplate'] as $template) {
				if (isset($template['Enabled']) && $template['Enabled']=='yes') {
					$data['usable_templates'][$template['id']] = $template['Name'];
				}
			}
		}
		
		if (sizeof($data['usable_templates'])==0) {
			$data['usable_templates'][0] = 'No active template!';
		}
		
	    $pagination					= new Pagination();
        $pagination->total			= $data['total'];
        $pagination->page			= $page;
        $pagination->limit			= $data['limit']; 
        $pagination->url			= $this->url->link('module/'.$this->moduleName.'/getabandonedcarts','token=' . $this->session->data['token'].'&page={page}&store_id='.$data['store_id'].'&notified='.$data['notified'].'&ordered='.$data['ordered'], 'SSL');
		$data['pagination']			= $pagination->render();

        $data['sources']			= $this->{$this->moduleModel}->viewAbandonedCarts($page, $data['limit'], $data['store_id'],  $data['notified'], $data['ordered']);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($data['total']) ? (($page - 1) * $data['limit']) + 1 : 0, ((($page - 1) * $data['limit']) > ($data['total'] - $data['limit'])) ? $data['total'] : ((($page - 1) * $data['limit']) + $data['limit']), $data['total'], ceil($data['total'] / $data['limit']));

		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'/view_abandonedcarts.tpl', $data));
    }

	// Send reminder popup show
	public function sendreminder() {
		$this->load->model('module/'.$this->moduleName);
		$this->load->model('design/layout');
		$this->load->model('setting/setting');
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		
		$data['newAddition']			= true;
		$languages						= $this->model_localisation_language->getLanguages();
		$data['languages']				= $languages;
		$firstLanguage					= array_shift($languages);
		$data['firstLanguageCode']		= $firstLanguage['code'];
		$data['data']					= $this->model_setting_setting->getSetting($this->moduleName, $this->request->get['store_id']);
		$data['id']						= $this->request->get['id'];
		$data['store_id']				= $this->request->get['store_id'];
		$data['currency']				= $this->config->get('config_currency');
		$data['result']					= $this->{$this->moduleModel}->getCartInfo($data['id']);
		$data['result']['customer_info']= json_decode($data['result']['customer_info'], true); 
		$data['language_id']			= $this->{$this->moduleModel}->getLanguageId($data['result']['customer_info']['language']);
		$data['mailtemplate']['id']		= $this->request->get['template_id'];
		$data['moduleName']				= $this->moduleName;
		$data['moduleData']				= (isset($data['data'][$this->moduleName])) ? $data['data'][$this->moduleName] : array();

		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'/send_reminder.tpl', $data));
	}
	
	// Send manual email to the customers
	public function sendcustomemail() {
		
		if (isset($this->request->post) && isset($this->request->post['ABcart_id']) && isset($this->request->post['AB_template_id'])) {	
			$this->load->model('module/'.$this->moduleName);
			$this->load->model('marketing/coupon');
			$this->load->model('tool/image');
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			$this->load->model('catalog/product');
			
			$this->language->load('module/'.$this->moduleName);
			
			/*require_once(DIR_SYSTEM.'library/tax.php');
			require_once(DIR_SYSTEM.'library/customer.php');*/
			
			$result							= $this->{$this->moduleModel}->getCartInfo($this->request->post['ABcart_id']);
			$this->request->get['store_id'] = $result['store_id'];
			$template_id					= $this->request->post['AB_template_id'];
			$language_id					= $this->request->post['AB_language_id'];
			$setting						= $this->model_setting_setting->getSetting($this->moduleName, $result['store_id']);
			$moduleData						= (isset($setting[$this->moduleName])) ? $setting[$this->moduleName] : array();
			$settingTemplate				= $this->request->post[$this->moduleName]['MailTemplate'][$template_id];
			$result['customer_info']		= json_decode($result['customer_info'], true);
			$Message						= html_entity_decode($settingTemplate['Message'][$language_id]);
			$width							= $settingTemplate['ProductWidth'];
			$height							= $settingTemplate['ProductHeight'];
			$result['cart']					= json_decode($result['cart'], true);
			$catalog_link					= "";
			$store_data						= $this->getCurrentStore($result['store_id']);
			$catalog_link					= $store_data['url'];
			
			$CartProducts = '<table style="width:100%">';
			$CartProducts .= '<tr>
								  <td class="left" width="70%"><strong>'.$this->language->get('text_product').'</strong></td>
								  <td class="left" width="15%"><strong>'.$this->language->get('text_qty').'</strong></td>
								  <td class="left" width="15%"><strong>'.$this->language->get('text_price').'</strong></td>
								</tr>';
			foreach ($result['cart'] as $product) { 
				if ($product['image']) {
					$image_thumb = $this->model_tool_image->resize($product['image'], $width, $height);
				} else {
					$image = false;
				}
				$CartProducts .='<tr>';
				$CartProducts .='<td><div style="float:left;padding-right:3px;"><a href="'.$catalog_link.'index.php?route=product/product&product_id='. $product['product_id'].'" target="_blank"><img src="'.str_replace(' ', '%20', $image_thumb).'" /></a></div> <a href="'.$catalog_link.'index.php?route=product/product&product_id='. $product['product_id'].'" target="_blank">'.$product['name'].'</a><br />';
				foreach ($product['option'] as $option) {
                       $CartProducts .= '- <small>'.$option['name'].' '.$option['value'].'</small><br />';
                }
				if ($moduleData['Taxes']=='yes') {
					$product_info = $this->model_catalog_product->getProduct($product['product_id']);
					global $registry;
					$registry->set('customer',new Customer($registry));
					$registry->set('tax', new Tax($registry));
					$this->customer->login($result['customer_info']['email'],'123',true);
					$price = $this->tax->calculate($product['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
					$this->customer->logout();
				} else {
					$price = $product['price'];
				}
				//
                $CartProducts .= '</td>
                          <td>x&nbsp;'.$product['quantity'].'</td>
						  <td>'.($this->currency->format($price)).'</td>
                        </tr>';
			}
			$CartProducts .='</table>';
			
			if ($settingTemplate['DiscountType']=='N') {
				// do nothing here
			} else {
				if ($settingTemplate['DiscountApply']=='all_products') {
					$DiscountCode		= $this->{$this->moduleModel}->generateuniquerandomcouponcode();
					$TimeEnd			=  time() + $settingTemplate['DiscountValidity'] * 24 * 60 * 60;
					$CouponData			= array('name' => 'AbCart [' . $result['customer_info']['email'].']',
					'code'				=> $DiscountCode, 
					'discount'			=> $settingTemplate['Discount'],
					'type'				=> $settingTemplate['DiscountType'],
					'total'		   		=> $settingTemplate['TotalAmount'],
					'logged'			=> '0',
					'shipping'			=> '0',
					'date_start'	 	 => date('Y-m-d', time()),
					'date_end'			=> date('Y-m-d', $TimeEnd),
					'uses_total'	  	=> '1',
					'uses_customer'   	=> '1',
					'status'		  	=> '1');
					$this->model_marketing_coupon->addCoupon($CouponData);
				} else if ($settingTemplate['DiscountApply']=='cart_products') {
					$cart_products		= array();
					foreach ($result['cart'] as $product) { 
					  $cart_products[]  = $product['product_id'];
					}
					$DiscountCode		= $this->{$this->moduleModel}->generateuniquerandomcouponcode();
					$TimeEnd			=  time() + $settingTemplate['DiscountValidity'] * 24 * 60 * 60;
					$CouponData	   		= array('name' => 'AbCart [' . $result['customer_info']['email'].']',
					'code'				=> $DiscountCode, 
					'discount'			=> $settingTemplate['Discount'],
					'type'				=> $settingTemplate['DiscountType'],
					'total'		  		=> $settingTemplate['TotalAmount'],
					'logged'		 	=> '0',
					'shipping'			=> '0',
					'coupon_product' 	=> $cart_products,
					'date_start'	  	=> date('Y-m-d', time()),
					'date_end'			=> date('Y-m-d', $TimeEnd),
					'uses_total'	  	=> '1',
					'uses_customer'   	=> '1',
					'status'		  	=> '1');
					$this->model_marketing_coupon->addCoupon($CouponData);
				}
			}
			
			$patterns = array();
			$patterns[0] = '{firstname}';
			$patterns[1] = '{lastname}';
			$patterns[2] = '{cart_content}';
			if (!($settingTemplate['DiscountType']=='N')) {
				$patterns[3] = '{discount_code}';
				$patterns[4] = '{discount_value}';
				$patterns[5] = '{total_amount}';
				$patterns[6] = '{date_end}';
			}
			$patterns[7] = '{unsubscribe_link}';
			$replacements = array();
			$replacements[0] = $result['customer_info']['firstname'];
			$replacements[1] = $result['customer_info']['lastname'];
			$replacements[2] = $CartProducts;
			if (!($settingTemplate['DiscountType']=='N')) {
				$replacements[3] = $DiscountCode;
				$replacements[4] = $settingTemplate['Discount'];
				$replacements[5] = $settingTemplate['TotalAmount'];
				$replacements[6] = date($moduleData['DateFormat'], $TimeEnd);
			}
			$replacements[7] = '<a href="'.$this->getCatalogURL().'index.php?route=module/' . $this->moduleName . '/removeCart&id='.$this->request->post['ABcart_id'].'">'.$this->language->get('text_unsubscribe').'</a>';
			$HTMLMail = str_replace($patterns, $replacements, $Message);
			$MailData = array(
				'email' =>  $result['customer_info']['email'],
				'message' => $HTMLMail, 
				'subject' => $settingTemplate['Subject'][$language_id],
				'store_id' => $result['store_id']);
			$emailResult = $this->{$this->moduleModel}->sendMail($MailData);
			$run_query = $this->db->query("UPDATE `" . DB_PREFIX . "".$this->moduleName."` SET notified = (notified + 1) WHERE `id`=".(int)$this->request->post['ABcart_id']);
 			if ($emailResult) {
				echo "The email is sent successfully.";
				if (isset($settingTemplate['RemoveAfterSend']))
					$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "".$this->moduleName."` WHERE `id`=".(int)$this->request->post['ABcart_id']);
			} else {
				echo "There is an error with the provided data in the form below.";
			}
		} else {
			echo "There is an error with the provided data in the form below.";	
		}
	}
	
	// Function that tests cron functionality
	public function testcron()
    {
        if (function_exists('shell_exec') && trim(shell_exec('echo EXEC')) == 'EXEC') {
            $data['shell_exec_status'] = 'Enabled';
        } else {
            $data['shell_exec_status'] = 'Disabled';
        }
        if ($data['shell_exec_status'] == 'Enabled') {
		   $cronFolder = dirname(DIR_APPLICATION) . '/vendors/'.$this->moduleName.'/';
            if (shell_exec('crontab -l')) {
                $data['cronjob_status']    = 'Enabled';
                $curentCronjobs                  = shell_exec('crontab -l');
                $data['current_cron_jobs'] = explode(PHP_EOL, $curentCronjobs);
                file_put_contents($cronFolder . 'cron.txt', '* * * * * echo "test" ' . PHP_EOL);
            } else {
				file_put_contents($cronFolder . 'cron.txt', '* * * * * echo "test" ' . PHP_EOL);
                if (file_exists($cronFolder . 'cron.txt')) {
                    exec('crontab ' . $cronFolder . 'cron.txt');
                    if (shell_exec('crontab -l')) {
                        $data['cronjob_status'] = 'Enabled';
                        shell_exec('crontab -r');
                    } else {
                        $data['cronjob_status'] = 'Disabled';
                    }
                }
            }
            if (file_exists($cronFolder . 'cron.txt')) {
                $data['folder_permission'] = "Writable";
                unlink($cronFolder . 'cron.txt');
            } else {
                $data['folder_permission'] = "Unwritable";
            }
        }

        $data['cron_folder']	= $cronFolder;
		$data['token']			= $this->session->data['token'];

		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'/test_cron.php', $data));
    }
	
	// Remove all records
	public function removeallrecords() {
		if (isset($this->request->post['remove']) && ($this->request->post['remove']==true) && isset($this->request->post['store']) ) {
				$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "".$this->moduleName."` WHERE `store_id`='".$this->request->post['store']."'");
				if ($run_query) echo "Success!";
		}
	}
	
	// Remove all expired coupons
	public function removeallexpiredcoupons() {
		$date_end = date('Y-m-d', time() - 60 * 60 * 24);
		if (isset($this->request->post['remove']) && ($this->request->post['remove']==true)) {
			$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "coupon` WHERE `name` LIKE '%AbCart [%' AND `date_end`<='".$date_end."'");
			if ($run_query) echo "Success!";
		}
	}
	
	// Remove all empty records
	public function removeallemptyrecords() {
		if (isset($this->request->post['remove']) && ($this->request->post['remove']==true) && isset($this->request->post['store']) ) {
				$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "".$this->moduleName."` WHERE `store_id`='".$this->request->post['store']."' AND `customer_info` NOT LIKE '%email%'");
				if ($run_query) echo "Success!";
		}
	}
	
	// Remove single record
	public function removeabandonedcart() {
		if (isset($this->request->post['cart_id'])) {
			$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "".$this->moduleName."` WHERE `id`=".(int)$this->request->post['cart_id']);
			if ($run_query) echo "Success!";
		}
	}
	
	// Get current store
	private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL();
        }
        return $store;
    }
	
	// Show given coupons
	public function givenCoupons() {		
		$this->load->model('module/'.$this->moduleName);
		$this->listCoupons('givenCoupons');	
	}
	
	// Show used coupons
	public function usedCoupons() {		
		$this->load->model('module/'.$this->moduleName);
		$this->listCoupons('usedCoupons');	
	}
	
	// Function to list the coupon codes
	private function listCoupons($action) { 
		$this->load->language('module/'.$this->moduleName);
	
		if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
		} else {
				$sort = 'name';
		}
		if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
		} else {
				$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
		} else {
				$page = 1;
		}

		$url = '';
		if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
		}

		$data['givenCoupons'] = array();

		$dataInfo = array(
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * 15,
				'limit' => 15
		);
		
		if($action == 'usedCoupons') {
			$coupon_total = $this->{$this->moduleModel}->getTotalUsedCoupons(); 
			$coupons  = $this->{$this->moduleModel}->getUsedCoupons($dataInfo);
		
		} else { 
			$coupon_total  = $this->{$this->moduleModel}->getTotalGivenCoupons();
			$coupons  =      $this->{$this->moduleModel}->getGivenCoupons($dataInfo);
		}
		if(!empty($coupons)) {
			foreach ($coupons as $coupon) {
				$data['coupons'][] = array(
					'coupon_id' => $coupon['coupon_id'],
					'name' => $coupon['name'],
					'code' => $coupon['code'],
					'discount' => $coupon['discount'],
					'date_start' => date($this->language->get('date_format_short'), strtotime($coupon['date_start'])),
					'date_end' => date($this->language->get('date_format_short'), strtotime($coupon['date_end'])),
					'status' => ($coupon['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
					'date_added' => $coupon['date_added']
				);
			}
		}

		$languageVariables = array(
			'heading_title',  
			'text_no_results',
			'column_coupon_name',
			'column_code',   
			'column_discount',  
			'column_date_start',
			'column_date_end',  
			'column_status',  
			'button_insert',    
			'button_delete',    
			'column_email',    
			'column_date_added'
			);
			
		foreach ($languageVariables as $languageVariable) {
			$data[$languageVariable] = $this->language->get($languageVariable);
		}

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

		$url = '';
		if ($order == 'ASC') {
				$url .= '&order=DESC';
		} else {
				$url .= '&order=ASC';
		}
		if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_name']       = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$data['sort_code']       = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=code' . $url;
		$data['sort_discount']   = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=discount' . $url;
		$data['sort_date_start'] = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=date_start' . $url;
		$data['sort_date_end']   = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=date_end' . $url;
		$data['sort_status']     = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=status' . $url;
		$data['sort_email']      = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=email' . $url;
		$data['sort_discount_type'] = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=discount_type' . $url;
		$data['sort_date_added']   = 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . '&sort=date_added' . $url;
		$url = '';
		if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
		}
		
		$data['total']				= $coupon_total;
		$data['limit']				= 15;
		$pagination					= new Pagination();
		$pagination->total			= $data['total'];
		$pagination->page			= $page;
		$pagination->limit			= $data['limit'];
		$pagination->text			= $this->language->get('text_pagination');
		$pagination->url			= 'index.php?route=module/'.$this->moduleName.'/'.$action.'&token=' . $this->session->data['token'] . $url . '&page={page}';
		$data['pagination']			= $pagination->render();
		$data['sort']				= $sort;
		$data['order']				= $order;
		$data['token']				= $this->session->data['token'];
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($data['total']) ? (($page - 1) * $data['limit']) + 1 : 0, ((($page - 1) * $data['limit']) > ($data['total'] - $data['limit'])) ? $data['total'] : ((($page - 1) * $data['limit']) + $data['limit']), $data['total'], ceil($data['total'] / $data['limit']));
	
		$this->response->setOutput($this->load->view('module/'.$this->moduleName.'/coupon.tpl', $data));
	}
	
}
?>