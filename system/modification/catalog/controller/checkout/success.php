<?php
class ControllerCheckoutSuccess extends Controller {
	public function index() {
		$this->load->language('checkout/success');

		if (isset($this->session->data['order_id'])) {

                $this->load->library('user');
                $this->user = new User($this->registry);
                $this->load->model('checkout/order');
                $data['orderDetails'] = $this->model_checkout_order->getOrder($this->session->data['order_id']);
                $data['orderProduct'] = $this->model_checkout_order->getOrderProduct($this->session->data['order_id']);
                $data['orderProductOptions'] = $this->model_checkout_order->getOrderProductOptions($this->session->data['order_id']);
                $data['orderDetails']['shipping_total'] = (isset($this->session->data['shipping_method']['cost'])) ? $this->session->data['shipping_method']['cost'] : 0;
                $data['user_logged'] = $this->user->isLogged();
                $data['route'] = $this->request->get['route'];
                
			$this->cart->clear();

			// Add to activity log
			$this->load->model('account/activity');

			if ($this->customer->isLogged()) {
				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
					'order_id'    => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_account', $activity_data);
			} else {
				$activity_data = array(
					'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
					'order_id' => $this->session->data['order_id']
				);

				$this->model_account_activity->addActivity('order_guest', $activity_data);
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		
			/* AbandonedCarts - Begin */
			$this->load->model('setting/setting');
			$abandonedCartsSettings = $this->model_setting_setting->getSetting('abandonedcarts', $this->config->get('store_id'));
			if (isset($abandonedCartsSettings['abandonedcarts']['Enabled']) && $abandonedCartsSettings['abandonedcarts']['Enabled']=='yes') { 
                if (isset($this->session->data['abanonedCart_ID']) & !empty($this->session->data['abanonedCart_ID'])) {
                    $id = $this->session->data['abanonedCart_ID'];
                } else if ($this->customer->isLogged()) {
                    $id = (!empty($this->session->data['abanonedCart_ID'])) ? $this->session->data['abanonedCart_ID'] : $this->customer->getEmail();
                } else {
                    $id = (!empty($this->session->data['abanonedCart_ID'])) ? $this->session->data['abanonedCart_ID'] : session_id();
                }

				$exists = $this->db->query("SELECT * FROM `" . DB_PREFIX . "abandonedcarts` WHERE `restore_id` = '$id'");
				if (!empty($exists->rows)) {
					foreach ($exists->rows as $row) {
                      if ($row['notified']!=0) {
                          $this->db->query("UPDATE `" . DB_PREFIX . "abandonedcarts` SET `ordered` = 1 WHERE `restore_id` = '".$id."'");
                      } else if ($row['notified']==0) {
                          $this->db->query("DELETE FROM `" . DB_PREFIX . "abandonedcarts` WHERE `restore_id` = '$id' AND `id`='".$row['id']."'");
                      }
					}
					$this->session->data['abanonedCart_ID']='';
 					unset($this->session->data['abanonedCart_ID']);
				}
			}
			/* AbandonedCarts - End */
   			
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}
}