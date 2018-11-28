<?php
class FvnMailHelper{
	public $order_complex;
	public $from_name;
	public $from_email;
	
	function __construct($order_id){
		HBImporter::model('orders');
		HBImporter::helper('currency');
		$model = new HBModelOrders();
		$this->order_complex = $model->getComplexItem($order_id);		
		$config = HBFactory::getConfig();
// 		debug($config);
		$this->from_name = $config->get('company_name','Freelancerviet.net');
		$this->from_email = $config->get('company_email','vuonganhduong812@gmail.com');
	}
	
	static function getOrderKey(){
		return array('order_status','pay_status','id','email','mobile','total','order_number','firstname','lastname');
	}
	function sendCustomer(){
		$template = get_option('fvn_mail_customer');
		$template = json_decode($template);
		$template->description = $this->fillOrder($template->description);
// 		echo $template->description;die;
		return HBHelper::sendMail($this->order_complex->order->email,$template->title, $template->description,
				'','',
				$template->from_name? $template->from_name:$this->from_name,
				$template->from_email?$template->from_email:$this->from_email);
	}
	function sendAdmin(){
		$template = get_option('fvn_mail_admin');
		$template = json_decode($template);
		$template->description = $this->fillOrder($template->description);
// 		echo $template->description;die;

// debug($template);
		return HBHelper::sendMail($this->from_email,$template->title, $template->description,
				'','',
				$template->from_name? $template->from_name:$this->from_name,
				$template->from_email?$template->from_email:$this->from_email);
	}
	public function fillOrder($input){
		$fields = self::getOrderKey();
		foreach($fields as $field){
			$input = str_replace('{'.$field.'}', $this->order_complex->order->$field, $input);
		}
		$link = HBHelper::get_order_link($this->order_complex->order);		
		$input = str_replace('{link}', $link, $input);
		$input = str_replace('{order_info}', HBHelper::renderLayout('email_order_info',$this->order_complex), $input);
		$input = str_replace('{passengers}', HBHelper::renderLayout('email_passenger',$this->order_complex), $input);
		$input = str_replace('{sumarry}', HBHelper::renderLayout('email_summary',$this->order_complex), $input);
		return $input;
	}
	
	
}