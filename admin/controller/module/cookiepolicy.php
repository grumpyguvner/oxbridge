<?php
class ControllerModuleCookiePolicy extends Controller {
    private $error = array(); 
    
    public function index() {   

        $this->load->language('module/cookiepolicy');

        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('setting/setting');
        
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('cookiepolicy', $this->request->post);    
            
			$this->session->data['success'] = $this->language->get('text_success');
			if(empty($this->request->get['continue'])) {
				$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
        }
        
        $data['token'] = $this->session->data['token'];       

        $text_strings = array(
                'heading_title',
                'text_enabled',
                'text_disabled',
				'text_edit',
				'text_top',
				'text_bottom',
				'text_fullscreen',
                'button_save',
                'button_cancel',
				'button_apply',
                'entry_status',
				'entry_position',
				'theme_version',
				'tab_settings',
				'tab_the1path',
				'colour_caption',
				'hover_colour_caption',
				'background_caption',
				'background_hover_caption',
				'rounded_corners_caption',
				'accept_button',
				'cookie_text',
				'cookie_background',
				'cookie_url_text',
				'url_caption',
				'url_help',
				'opacity_caption'
        );
        
        foreach ($text_strings as $text) {
            $data[$text] = $this->language->get($text);
        }

        // store config data
        $config_data = array(
			'cookiepolicy_status',
			'cookiepolicy_position',
			'cookiepolicy_accept_button_colour',
			'cookiepolicy_accept_button_hover',
			'cookiepolicy_accept_text_colour',
			'cookiepolicy_accept_text_hover',
			'cookiepolicy_text_colour',
			'cookiepolicy_background_colour',
			'cookiepolicy_opacity',
			'cookiepolicy_url',
			'cookiepolicy_rounded_corners'
        );
        
        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $data[$conf] = $this->request->post[$conf];
            } else {
                $data[$conf] = $this->config->get($conf);
            }
        }
    
        //Create error and success messages
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
        
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/cookiepolicy', 'token=' . $this->session->data['token'], 'SSL')
        );
        
        $data['action'] = $this->url->link('module/cookiepolicy', 'token=' . $this->session->data['token'], 'SSL');
        
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        
		if (isset($this->request->post['cookiepolicy_module'])) {
            $data['cookiepolicy_module'] = $this->request->post['cookiepolicy_module'];
        } else {
            $data['cookiepolicy_module'] = $this->config->get('cookiepolicy_module');
        }  
		      
        $this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/cookiepolicy.tpl', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/cookiepolicy')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        return !$this->error;   
    }
}
?>