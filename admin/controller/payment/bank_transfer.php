<?php
class ControllerPaymentBankTransfer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/bank_transfer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bank_transfer', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_bank'] = $this->language->get('entry_bank');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_ordrequest->post['bank_transfer_geo_zone_id'])) {
			$data['bank_transfer_geo_zone_id'] = $this->request->post['bank_transfer_geo_zone_id'];
		} else {
			$data['bank_transfer_geo_zone_id'] = $this->config->get('bank_transfer_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['bank_transfer_status'])) {
			$data['bank_transfer_status'] = $this->request->post['bank_transfer_status'];
		} else {
			$data['bank_transfer_status'] = $this->config->get('bank_transfer_status');
		}

		if (isset($this->request->post['bank_transfer_sort_order'])) {
			$data['bank_transfer_sort_order'] = $this->request->post['bank_transfer_sort_order'];
		} else {
			$data['bank_transfer_sort_order'] = $this->config->get('bank_transfer_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/bank_transfer.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/bank_transfer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (empty($this->request->post['bank_transfer_bank' . $language['language_id']])) {
				$this->error['bank' .  $language['language_id']] = $this->language->get('error_bank');
			}
		}

		return !$this->error;
	}
}