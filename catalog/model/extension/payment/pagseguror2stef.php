<?php 
class ModelExtensionPaymentPagSeguroR2STef extends Model {
	public function getMethod($address, $total) {
		$this->language->load('extension/payment/cod');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pagseguror2s_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('pagseguror2s_total_tef') > 0 && $this->config->get('pagseguror2s_total_tef') > $total) {
			$status = false;
		} elseif (!$this->config->get('pagseguror2s_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		if($this->config->get('pagseguror2s_status_tef')==false || $this->config->get('pagseguror2s_status')==false){
			$status = false;
		}

		$method_data = array();

		if ($status) {  
			$method_data = array(
				'code'       => 'pagseguror2stef',
				'terms'      => '',
				'title'      => $this->config->get('pagseguror2s_titulo_tef'),
				'sort_order' => $this->config->get('pagseguror2s_ordem_tef')
			);
		}

		return $method_data;
	}
}
?>