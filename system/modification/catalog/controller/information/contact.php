<?php
class ControllerInformationContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/contact');

            $this->load->model('module/support_departaments');
            

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $installed = $this->model_module_support_departaments->checkInstalled();
            if($installed) {
            $to = $this->model_module_support_departaments->getDepartamentByEmail($this->request->post['subtopic_id']);
            $to_master = $this->model_module_support_departaments->getDepartamentByMasterEmail($this->request->post['departament_group_id']);
            $phone_number = $this->request->post['phone'];
            }


            
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			
            $mail->setTo(((!$to['email'])?$this->config->get('config_email'):$to['email']));
            
			$mail->setFrom($this->request->post['email']);
			$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
			$mail->setText($this->request->post['enquiry']);
			//$mail->send();

            if(isset($to_master['email']) && $to_master['email']!=''){
                $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->smtp_hostname = $this->config->get('config_mail_smtp_host');
                $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');			
                $mail->setTo($to_master['email']);
                $mail->setFrom($this->request->post['email']);
                $mail->setSender($this->request->post['name']);
                $mail->setSubject(sprintf($this->language->get('email_subject'), $this->request->post['name']));
                $mail->setText($this->request->post['enquiry'] . "\n\nPhone Number: " . $phone_number);
                //$mail->send();
            }
            



          $this->load->model('tool/pro_email');

          $email_params = array(
            'type' => 'admin.information.contact',
            'mail' => $mail,
            'data' => array(
                'enquiry_name' => html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'),
                'enquiry_mail' => html_entity_decode($this->request->post['email'], ENT_QUOTES, 'UTF-8'),
                'enquiry_message' => html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8'),
                'enquiry_phone' => html_entity_decode($this->request->post['phone'], ENT_QUOTES, 'UTF-8'),
              ),
          );


          //if (isset($this->model_module_support_departaments) && $this->model_module_support_departaments->checkInstalled()) {
          //  $email_params['data']['enquiry_phone'] =  html_entity_decode($this->request->post['phone'], ENT_QUOTES, 'UTF-8');
          //}

          $this->model_tool_pro_email->generate($email_params);
			
			$this->response->redirect($this->url->link('information/contact/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_location'] = $this->language->get('text_location');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_open'] = $this->language->get('text_open');
		$data['text_comment'] = $this->language->get('text_comment');

            $data['text_select'] = $this->language->get('text_select');
            $data['text_none'] = $this->language->get('text_none');
            

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_enquiry'] = $this->language->get('entry_enquiry');

            $data['entry_topic'] = $this->language->get('entry_topic');
            $data['entry_subtopic'] = $this->language->get('entry_subtopic');
            $data['entry_phone_number'] = $this->language->get('entry_phone_number');
            
        $data['entry_captcha'] = $this->language->get('entry_captcha');

		$data['button_map'] = $this->language->get('button_map');

            $installed = $this->model_module_support_departaments->checkInstalled();
            if($installed){
                $data['departaments'] = $this->model_module_support_departaments->getDepartaments();
            }
            
            if (isset($this->request->post['departament_group_id'])) {
                $data['departament_group_id'] = $this->request->post['departament_group_id'];
            } else {
                $data['departament_group_id'] = '';
            }

            if (isset($this->request->post['subtopic_id'])) {
                $data['subtopic_id'] = $this->request->post['subtopic_id'];
            } else {
                $data['subtopic_id'] = '';
            }

            if (isset($this->request->post['phone'])) {
                $data['phone_number'] = $this->request->post['phone'];
            } else {
                $data['phone_number'] = '';
            }

            if (isset($this->error['topic'])) {
                $data['error_topic'] = $this->error['topic'];
            } else {
                $data['error_topic'] = '';
            }

            if (isset($this->error['subtopic'])) {
                $data['error_subtopic'] = $this->error['subtopic'];
            } else {
                $data['error_subtopic'] = '';
            }

            if (isset($this->error['phone_number'])) {
                $data['error_phone_number'] = $this->error['phone_number'];
            } else {
                $data['error_phone_number'] = '';
            }
            

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

		if (isset($this->error['captcha'])) {
			$data['error_captcha'] = $this->error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/contact');

		$this->load->model('tool/image');

		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
		} else {
			$data['image'] = false;
		}

		$data['store'] = $this->config->get('config_name');
		$data['address'] = nl2br($this->config->get('config_address'));
		$data['geocode'] = $this->config->get('config_geocode');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['fax'] = $this->config->get('config_fax');
		$data['open'] = nl2br($this->config->get('config_open'));
		$data['comment'] = $this->config->get('config_comment');

		$data['locations'] = array();

		$this->load->model('localisation/location');

		foreach((array)$this->config->get('config_location') as $location_id) {
			$location_info = $this->model_localisation_location->getLocation($location_id);

			if ($location_info) {
				if ($location_info['image']) {
					$image = $this->model_tool_image->resize($location_info['image'], $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
				} else {
					$image = false;
				}

				$data['locations'][] = array(
					'location_id' => $location_info['location_id'],
					'name'        => $location_info['name'],
					'address'     => nl2br($location_info['address']),
					'geocode'     => $location_info['geocode'],
					'telephone'   => $location_info['telephone'],
					'fax'         => $location_info['fax'],
					'image'       => $image,
					'open'        => nl2br($location_info['open']),
					'comment'     => $location_info['comment']
				);
			}
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

		if (isset($this->request->post['enquiry'])) {
			$data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$data['enquiry'] = '';
		}


            $installed = $this->model_module_support_departaments->checkInstalled();

            if ($installed > 0 && (!isset($this->request->post['departament_group_id']) || $this->request->post['departament_group_id'] == ''))
            {
                $this->error['topic'] = $this->language->get('error_topic');
            }
            
            if ($installed > 0 && (!isset($this->request->post['subtopic_id']) || $this->request->post['subtopic_id'] == '')) {
                $this->error['subtopic'] = $this->language->get('error_subtopic');
            }

            if ($installed > 0 && (!isset($this->request->post['phone']) || $this->request->post['phone'] == '')) {
                $this->error['phone_number'] = $this->language->get('error_phone_number');
            }
            
		if ($this->config->get('config_google_captcha_status')) {
			$this->document->addScript('https://www.google.com/recaptcha/api.js');

			$data['site_key'] = $this->config->get('config_google_captcha_public');
		} else {
			$data['site_key'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/contact.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/contact.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/information/contact.tpl', $data));
		}
	}

	public function success() {
		$this->load->language('information/contact');

            $this->load->model('module/support_departaments');
            

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/success.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/success.tpl', $data));
		}
	}

	protected function validate() {
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}


            $installed = $this->model_module_support_departaments->checkInstalled();

            if ($installed > 0 && (!isset($this->request->post['departament_group_id']) || $this->request->post['departament_group_id'] == ''))
            {
                $this->error['topic'] = $this->language->get('error_topic');
            }
            
            if ($installed > 0 && (!isset($this->request->post['subtopic_id']) || $this->request->post['subtopic_id'] == '')) {
                $this->error['subtopic'] = $this->language->get('error_subtopic');
            }

            if ($installed > 0 && (!isset($this->request->post['phone']) || $this->request->post['phone'] == '')) {
                $this->error['phone_number'] = $this->language->get('error_phone_number');
            }
            
		if ($this->config->get('config_google_captcha_status')) {
			$recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('config_google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

			$recaptcha = json_decode($recaptcha, true);

			if (!$recaptcha['success']) {
				$this->error['captcha'] = $this->language->get('error_captcha');
			}
		}

		return !$this->error;
	}

            public function departament() {
                $json = array();

                $this->load->model('module/support_departaments');
                $installed = $this->model_module_support_departaments->checkInstalled();

                if($installed) {
                $departament_info = $this->model_module_support_departaments->getDepartament($this->request->get['departament_group_id']);
                }
            
                if ($departament_info) {

                    $json = array(
                        'departament_group_id'  => $departament_info['departament_group_id'],
                        'name'                  => $departament_info['name'],
                        'subtopic'              => $this->model_module_support_departaments->getDepartamentById($this->request->get['departament_group_id'])

                    ); 
                }
                $this->response->addHeader('Content-Type: application/json');
                $this->response->setOutput(json_encode($json));
            }
            
}