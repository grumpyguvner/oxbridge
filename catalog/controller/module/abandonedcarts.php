<?php
class ControllerModuleAbandonedcarts extends Controller
{
	private $moduleName = 'abandonedcarts';
	private $moduleModel = 'model_module_abandonedcarts';
	
    public function sendReminder()  {
		$log = new Log($this->moduleName."_log.txt");
		$log->write("Executing cron job functionality");

        $this->load->model('setting/setting');
        $this->load->model('tool/image');
        $this->load->model('module/'.$this->moduleName);
		$this->load->model('catalog/product');
		
        $this->language->load('product/product');
		$this->language->load('module/'.$this->moduleName);
		
		$data['text_price'] = $this->language->get('text_price');
		$data['text_qty'] = $this->language->get('text_qty');

		$stores = array_merge(array(0 => $this->{$this->moduleModel}->getStore(0)), $this->{$this->moduleModel}->getStores());
		foreach ($stores as $store) {
			$setting = $this->model_setting_setting->getSetting($this->moduleName, $store['store_id']);
			$moduleData = isset($setting[$this->moduleName]) ? $setting[$this->moduleName] : array();
			if (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes' && isset($moduleData['ScheduleEnabled']) && $moduleData['ScheduleEnabled']='yes' && isset($moduleData['MailTemplate'])) {
				foreach ($moduleData['MailTemplate'] as $mailtemplate) {
					if ($mailtemplate['Enabled']=='yes') {
						$results = $this->{$this->moduleModel}->getCarts($mailtemplate['Delay']);

						$usedEmails = array();
						foreach ($results as $result) {
							$result['customer_info'] = json_decode($result['customer_info'], true);
							if (isset($result['customer_info']['email']) && isset($result['customer_info']['firstname']) && isset($result['customer_info']['lastname'])) {
								
								// If invalid email, delete record and continue with the execution
								if (!filter_var($result['customer_info']['email'], FILTER_VALIDATE_EMAIL)) {
									$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "abandonedcarts` WHERE `id`=".(int)$result['id']);
									continue;
								}
								
								if (!in_array($result['customer_info']['email'], $usedEmails,true)) {
									// Subject and message language
									if (isset($result['customer_info']['language'])) {
										$language_id = $this->{$this->moduleModel}->getLanguageId($result['customer_info']['language']);
										$Subject = $mailtemplate['Subject'][$language_id];
										$Message = html_entity_decode($mailtemplate['Message'][$language_id]);
									} else {
										$languages = $this->getLanguages();
										$firstLanguage = array_shift($languages);
										$firstLanguageCode = $firstLanguage['language_id'];
										$Subject = $mailtemplate['Subject'][$firstLanguageCode];
										$Message = html_entity_decode($mailtemplate['Message'][$firstLanguageCode]);						
									}
						
									$result['cart']			= json_decode($result['cart'], true);
									$catalog_link			= "";
									$store_data				= $this->{$this->moduleModel}->getStore($store['store_id']);
									$catalog_link			= $store_data['url'];
									$width					= (isset($mailtemplate['ProductWidth'])) ? $mailtemplate['ProductWidth'] : '60';
									$height					= (isset($mailtemplate['ProductWidth'])) ? $mailtemplate['ProductHeight'] : '60';
						
									$CartProducts = '<table width="100%">';
									$CartProducts .= '<thead>
														<tr class="table-header">
														  <td class="left" width="70%"><strong>Product</strong></td>
														  <td class="left" width="15%"><strong>'.$data['text_qty'].'</strong></td>
														  <td class="left" width="15%"><strong>'.$data['text_price'].'</strong></td>
														</tr>
													 </thead>';
									foreach ($result['cart'] as $product) { 
										if ($product['image']) {
											$image_thumb = $this->model_tool_image->resize($product['image'], $width, $height);
										} else {
											$image = false;
										}
										$CartProducts .='<tr>';
										$CartProducts .='<td class="name"><div id="picture" style="float:left;padding-right:3px;"><a href="'.$this->url->link('product/product','product_id='.$product['product_id']).'" target="_blank"><img src="'.$image_thumb.'" /></a></div> <a href="'.$this->url->link('product/product','product_id='.$product['product_id']).'" target="_blank">'.$product['name'].'</a><br />';
										foreach ($product['option'] as $option) {
											   $CartProducts .= '- <small>'.$option['name'].' '.$option['value'].'</small><br />';
										}
										//
										if ($moduleData['Taxes']=='yes') {
											$product_info = $this->model_catalog_product->getProduct($product['product_id']);
											$price = $this->tax->calculate($product['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
										} else {
											$price = $product['price'];
										}
										//
										$CartProducts .= '</td>
												  <td class="quantity">x&nbsp;'.$product['quantity'].'</td>
												  <td class="price">'.($this->currency->format($price)).'</td>
												</tr>';
									}
									$CartProducts .='</table>';
						
						
									if ($mailtemplate['DiscountType']=='N') {
										// do nothing here
									} else {
										if ($mailtemplate['DiscountApply']=='all_products') {
											$DiscountCode			= $this->{$this->moduleModel}->generateuniquerandomcouponcode();
											$TimeEnd				=  time() + $mailtemplate['DiscountValidity'] * 24 * 60 * 60;
											$CouponData				= array('name' => 'AbCart [' . $result['customer_info']['email'].']',
											'code'					=> $DiscountCode, 
											'discount'				=> $mailtemplate['Discount'],
											'type'					=> $mailtemplate['DiscountType'],
											'total'		   			=> $mailtemplate['TotalAmount'],
											'logged'		  		=> '0',
											'shipping'				=> '0',
											'date_start'	  		=> date('Y-m-d', time()),
											'date_end'				=> date('Y-m-d', $TimeEnd),
											'uses_total'	  		=> '1',
											'uses_customer'   		=> '1',
											'status'		  		=> '1');
											$this->{$this->moduleModel}->addCoupon($CouponData);
										} else if ($mailtemplate['DiscountApply']=='cart_products') {
											$cart_products			= array();
											foreach ($result['cart'] as $product) { 
												$cart_products[] 	= $product['product_id'];
											}
											$DiscountCode	 		= $this->{$this->moduleModel}->generateuniquerandomcouponcode();
											$TimeEnd		  		= time() + $mailtemplate['DiscountValidity'] * 24 * 60 * 60;
											$CouponData	   			= array('name' => 'AbCart [' . $result['customer_info']['email'].']',
											'code'					=> $DiscountCode, 
											'discount'				=> $mailtemplate['Discount'],
											'type'					=> $mailtemplate['DiscountType'],
											'total'		   			=> $mailtemplate['TotalAmount'],
											'logged'		  		=> '0',
											'shipping'				=> '0',
											'coupon_product'  		=> $cart_products,
											'date_start'	 		=> date('Y-m-d', time()),
											'date_end'				=> date('Y-m-d', $TimeEnd),
											'uses_total'	 		=> '1',
											'uses_customer'  		=> '1',
											'status'		  		=> '1');
											$this->{$this->moduleModel}->addCoupon($CouponData);
										}
									}
						
									$patterns = array();
									$patterns[0] = '{firstname}';
									$patterns[1] = '{lastname}';
									$patterns[2] = '{cart_content}';
									if (!($mailtemplate['DiscountType']=='N')) {
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
									if (!($mailtemplate['DiscountType']=='N')) {
										$replacements[3] = $DiscountCode;
										$replacements[4] = $mailtemplate['Discount'];
										$replacements[5] = $mailtemplate['TotalAmount'];
										$replacements[6] = date($moduleData['DateFormat'], $TimeEnd);
									}
									$replacements[7] = '<a href="'.$catalog_link.'index.php?route=module/'.$this->moduleName.'/removeCart&id='.$result['id'].'">'.$this->language->get('text_unsubscribe').'</a>';
									$HTMLMail = str_replace($patterns, $replacements, $Message);
									$MailData = array(
										'email' =>  $result['customer_info']['email'],
										'message' => $HTMLMail, 
										'subject' => $Subject,
										'store_id' => $store['store_id']);
									
									if (!in_array($result['customer_info']['email'], $usedEmails,true)) {	
										$emailResult = $this->{$this->moduleModel}->sendMail($MailData);
										$usedEmails[] = $result['customer_info']['email'];
									}
									$run_query = $this->db->query("UPDATE `" . DB_PREFIX . "".$this->moduleName."` SET notified = (notified + 1) WHERE `id`=".(int)$result['id']);

									if (isset($mailtemplate['RemoveAfterSend']))
										$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "".$this->moduleName."` WHERE `id`=".(int)$result['id']);
								}
							} else {
								if (isset($mailtemplate['RemoveEmptyRecords']) && $mailtemplate['RemoveEmptyRecords']=='yes') {
									$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "abandonedcarts` WHERE `id`=".(int)$result['id']);
								}
							}
			
						}
					}					
				}
			}				
		}
    }
	
	private function getLanguages($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "language";

			$sort_data = array(
				'name',
				'code',
				'sort_order'
			);	

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY sort_order, name";	
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
		} else {
			$language_data = $this->cache->get('language');

			if (!$language_data) {
				$language_data = array();

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language ORDER BY sort_order, name");

				foreach ($query->rows as $result) {
					$language_data[$result['code']] = array(
						'language_id' => $result['language_id'],
						'name'        => $result['name'],
						'code'        => $result['code'],
						'locale'      => $result['locale'],
						'image'       => $result['image'],
						'directory'   => $result['directory'],
						'filename'    => $result['filename'],
						'sort_order'  => $result['sort_order'],
						'status'      => $result['status']
					);
				}

				$this->cache->set('language', $language_data);
			}

			return $language_data;			
		}
	}
	
	public function removeCart(){
		$this->language->load('module/'.$this->moduleName);
        if (isset($_GET['id']) && !empty($_GET['id'])) {
			$run_query = $this->db->query("DELETE FROM `" . DB_PREFIX . "".$this->moduleName."` WHERE `id`=".(int)$_GET['id']);
			echo '<center>'.$this->language->get('unsubscribe_success').'</center>';
        } else {
			echo '<center>'.$this->language->get('unsubscribe_error').'</center>';			
		}
    }
}
?>
