<?php class WSSystempayAnalyzer extends WSTools {
	protected $SystempayResults;
	protected $systempay_results_array;	

	public function __construct() {
		parent::__construct();
		$this->set_results_array();
	}

	private function set_results_array(){
		$this->SystempayResults = new WSSystempayResults();
		$this->systempay_results_array=$this->SystempayResults->get_results();
	}


	public function get_or_post($key){
		if (isset($_GET[$key])){
			return $_GET[$key];
		}
		else if (isset($_POST["vads_result"])){
			return $_POST[$key];
		}
		return false;
	}

	public function get_vads_result() {
		$vads_result=$this->get_or_post("vads_result");
		if (!empty($vads_result)){
			$vads_results_array = $this->systempay_results_array["results"];
			return $vads_results_array[$vads_result];
		}
		return false;
	}

	public function get_vads_extra_results() {
		$result=$this->get_or_post("vads_result");
		$extra_result =$this->get_or_post("vads_extra_result");
		if (!empty($extra_result)&&!empty($result)) :
			switch($result):
				case "30" :
					$extra_results_array=$this->systempay_results_array["extra_results_30"];
					return $extra_results_array[$extra_result];
				break;
				default :
					$extra_results_array=$this->systempay_results_array["extra_results_default"];
					return $extra_results_array[$extra_result];
				break;
			endswitch;
		endif;
		return false;
	 }

	 public function get_vads_auth() {
		$vads_auth=$this->get_or_post("vads_auth_result");
		if (!empty($vads_auth)){
			$vads_auths_array = $this->systempay_results_array["auth_results"];
			return $vads_auths_array[$vads_auth];
		}
		return false;
	 }

	 public function get_vads_warranty_result() {
		$vads_warranty_result=$this->get_or_post("vads_warranty_result");
		if (!empty($vads_warranty_result)){
			$warranty_results_array = $this->systempay_results_array["warranty_results"];
			return $warranty_results_array[$vads_warranty_result];
		}
		return false;
	 }
	 public function showResult() {
	 	?>
	 	<p><?php echo $this->get_vads_result(); ?></p>
	 	<?php
	 }

	 public function get_cust_email($order_id) {
		global $wpdb;
		$mail = $wpdb->get_row("SELECT transaction_customer_email FROM $this->transactions_table_name  WHERE transaction_order_id = '$order_id'","ARRAY_N");
		return $mail[0];
	}

	public function get_form_id($order_id){
		global $wpdb;
		$formid = $wpdb->get_var("SELECT transaction_form_id FROM $this->transactions_table_name  WHERE transaction_order_id = '$order_id'");
		return $formid;
	}


	public function get_amount($order_id){
		global $wpdb;
		$amount = $wpdb->get_row("SELECT transaction_command_currency,transaction_command_amount FROM $this->transactions_table_name  WHERE transaction_order_id = '$order_id'","ARRAY_N");
		$the_amount=array(
			"amount"=>$amount[1]
			,"currency"=>$amount[0]
		);
		return $the_amount;
	}

	public function get_date($order_id) {
		global $wpdb;
		$the_date = $wpdb->get_row("SELECT transaction_command_date FROM $this->transactions_table_name  WHERE transaction_order_id = '$order_id'","ARRAY_N");
		return $the_date[0];
	}
} //end class

?>