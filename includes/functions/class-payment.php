<?php
/**
 * @package 	FVN-extension
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');
class HBActionPayment extends HBAction{
	
	/*
	 * Generate checkout page of payment gateway
	 */
	function process(){
		HBImporter::model('orders');
		$order = new HBModelOrders();
		$order->load($this->input->getInt('order_id'));
// 		HBHelper::check_nonce();				
		if($order->pay_status=='SUCCESS'){
			wp_redirect(HBHelper::get_order_link($order));exit;
		}
		$payment_plugin = $this->input->getString('pay_method','');
		
		$order->pay_method=$payment_plugin;
		$order->store();	
		
// 		debug($order);die;		
		do_action('fvn_order_process_checkout',$order);		
		$order_id = $order->id;
		//Trigger _preparePayment of payment gateway to generate checkout page
		//import core plugin
		$payment_plugin = 'hbpayment_'.$payment_plugin;
		HBImporter::corePaymentPlugin();
		$order_id = $order->id;
		$payment = new $payment_plugin();
		$payment->config = HBFactory::getConfig();
		$payment->return_url = site_url("index.php?hbaction=payment&task=confirm&method={$payment_plugin}&paction=display_message&order_id=$order_id");
		$payment->cancel_url = site_url("index.php?hbaction=payment&task=confirm&method={$payment_plugin}&paction=cancel&order_id=$order_id");
		$payment->notify_url = site_url("index.php?hbaction=payment&task=confirm&method={$payment_plugin}&paction=process&order_id=$order_id");
		$payment->order = $order;
		$result = $payment->_prePayment();		
		return;			
	}	
	
	/**
	 * Render form
	 * @param string $element
	 */
	function getPaymentForm($element='')
	{
		$values = $this->input->getPost();
		$html = '';
		$text = "";
		$element = $this->input->getString( 'element' );
		$core_payment = HBList::getCorePaymentMethod();
		foreach ($core_payment as $plugin){
			if($element == $plugin->name){
				$params= get_option($plugin->name,'{}');
				$params = json_decode($params);
				echo $params->description;
				exit;
			}
		}
		$payment = new $element(HBFactory::getConfig());
		$html = $payment->_renderForm($values);
		echo $html;
		exit;
	}	

	/**
	 * Process payment after return from 
	 */
	function confirm()
	{
		//import core plugin
		HBImporter::corePaymentPlugin();
		HBImporter::model('orders');		
		do_action('hb_order_process_execute_before');		
		$plugin = $this->input->getString('method');
		$config = HBFactory::getConfig();
		$payment = new $plugin();	
		$payment->config = $config;
		$payment->order = new HBModelOrders();
		$results = $payment->_postPayment();
		/// Send email
		
		if($results){
			if(!isset($results->sendemail)){
				//send email
				if($config->allow_curl){
					$url = site_url().'index.php?hbaction=payment&task=urlsendmail&order_id='.$results->id;
					HBHelper::pingUrl($url);
				}else{
					$this->sendMail($results->id);
				}
			}
		}		
		do_action('hb_order_process_execute_after',$results);
		if($results->order_status=='CONFIRMED'){
			wp_redirect(HBHelper::get_order_link($results));
		}else{			
			wp_redirect('index.php?view=message');
		}		
		exit;
	}	
	private function sendMail($order_id){	
		HBImporter::model('orders');
		HBImporter::helper('currency','email');
		$mail = new FvnMailHelper($order_id);
		$mail->sendCustomer();
        $mail->sendAdmin();        
	}	
	//send mail via post curl
	public function urlSendmail(){
		$order_id = $this->input->getInt('order_id');
		$this->sendMail($order_id);
		exit;
	}	
}