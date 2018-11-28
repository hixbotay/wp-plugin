<?php
/*
Plugin Name: Hbpayment-onepay
Plugin URI: http://http://hbproweb.com/
Description: Payment plugin that help plugin of Joombooking can connect with online payment gateway
Version: 1.0
Author: Vuong Anh Duong
Author URI: http://example.com
Text Domain: prowp-plugin
License: GPLv2
*/
defined('ABSPATH') or die('Restricted access');
use PayPal\CoreComponentTypes\BasicAmountType;
use PayPal\EBLBaseComponents\AddressType;
use PayPal\EBLBaseComponents\BillingAgreementDetailsType;
use PayPal\EBLBaseComponents\PaymentDetailsItemType;
use PayPal\EBLBaseComponents\PaymentDetailsType;
use PayPal\EBLBaseComponents\SetExpressCheckoutRequestDetailsType;
use PayPal\PayPalAPI\SetExpressCheckoutReq;
use PayPal\PayPalAPI\SetExpressCheckoutRequestType;
use PayPal\Service\PayPalAPIInterfaceServiceService;
use PayPal\IPN\PPIPNMessage;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsReq;
use PayPal\PayPalAPI\GetExpressCheckoutDetailsRequestType;
use PayPal\EBLBaseComponents\DoExpressCheckoutPaymentRequestDetailsType;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentReq;
use PayPal\PayPalAPI\DoExpressCheckoutPaymentRequestType;

class HBPayment_Paypal
{

	public $_element = 'hbpayment_paypal';
	public $params;
	public $return_url;
	public $cancel_url;
	public $notify_url;
	public $config;
	/*
	 * Class Order 
	 */
	public $order;

	function __construct($main_config=array()) {
		$config = get_option($this->_element);
		$this->params = json_decode($config);
		$this->currency = HBFactory::getConfig()->main_currency;//'USD';
	}
	
	//get config options
	private function getParam($key,$default = null){
		return isset($this->params->$key) ? $this->params->$key : $default;
	}
	
	/*
	 * Get value from REQUEST
	 */
	private function getInput($key,$default = null){
		if (isset($_REQUEST[$key])){
			return $_REQUEST[$key];
		}
		$key = 'amp;'.$key;
	
		if (isset($_GET[$key])){
			return $_GET[$key];
		}
		return $default;
	}
	
	
	function formatNumber($total){
		$thousand		= $this->config->get('currency_seperator');
		$decimalpoint 	= $this->config->get('currency_decimalpoint',2);
		$result = number_format($total, $decimalpoint, '.','');
		return $result;
	}
	
	function getConfig(){
		
		return array (
				'mode' => $this->params->sandbox ? 'sandbox' : 'live' ,
				'acct1.UserName' => !$this->params->sandbox ? $this->params->api_username : 'vuonganhduong812-facilitator_api1.gmail.com',
				'acct1.Password' => !$this->params->sandbox ? $this->params->api_password : 'X5BGGRNZ5QVJ88CT',
				'acct1.Signature' => !$this->params->sandbox ? $this->params->api_signature : 'AmdJM2idWGXOdwYIH9emtICYgf9EAT5QS-9Cj3gIZ4kF1ZQhOJyUWUV6',
		);
	}
	
	function _prePayment( )
	{
		$data = $this->order->getProperties();
		$data['total'] = $this->formatNumber($data['total']);
		$this->_autoload();
		
		$config = $this->getConfig();
		$paypalService = new PayPalAPIInterfaceServiceService($config);
		$paymentDetails= new PaymentDetailsType();
		
		$itemDetails = new PaymentDetailsItemType();
		$itemDetails->Name = $data['order_number'];
		$itemDetails->Amount = $data['total'];
		$itemDetails->Quantity = 1;
		
		$paymentDetails->PaymentDetailsItem[0] = $itemDetails;
		$paymentDetails->Custom = $data['id'];
		
		$orderTotal = new BasicAmountType();
		$orderTotal->currencyID = $data['currency'];
		$orderTotal->value = $data['total'];
		
		$paymentDetails->OrderTotal = $orderTotal;
		$paymentDetails->PaymentAction = 'Sale';
		$paymentDetails->NotifyURL = $this->notify_url;
		
		$setECReqDetails = new SetExpressCheckoutRequestDetailsType();
		$setECReqDetails->PaymentDetails[0] = $paymentDetails;
		$setECReqDetails->CancelURL = $this->cancel_url;
		$setECReqDetails->ReturnURL = $this->return_url;
		$setECReqDetails->LocaleCode = 'US';
		$setECReqDetails->NoShipping = 1;
		$setECReqDetails->AddressOverride = 1;
		$setECReqDetails->ReqConfirmShipping = 0;
		
		$setECReqType = new SetExpressCheckoutRequestType();
		$setECReqType->Version = '104.0';
		$setECReqType->SetExpressCheckoutRequestDetails = $setECReqDetails;
		
		$setECReq = new SetExpressCheckoutReq();
		$setECReq->SetExpressCheckoutRequest = $setECReqType;
		
		try {
			/* wrap API method calls on the service object with a try catch */
			$setECResponse = $paypalService->SetExpressCheckout($setECReq);
		} catch (Exception $ex) {
			echo $ex->getMessage();
			exit;
		}
		wp_redirect($this->_getPostUrl($setECResponse->Token));
		die;
		return array('status'=>'1','url'=>$this->_getPostUrl($setECResponse->Token));

	}
	function _getPostUrl($token)
	{
	
		$url = $this->params->sandbox ? 'https://www.sandbox.paypal.com' : 'https://www.paypal.com';
		$payPalURL = $url.'/webscr?cmd=_express-checkout&token=' . $token;
		return $payPalURL;
	}
	
	
	public function _displayMessage(){		
		
		$this->_autoload();
		$config = $this->getConfig();
		$token =urlencode( $_REQUEST['token']);
		$payerId=urlencode( $_REQUEST['PayerID']);
		$input = HBFactory::getInput();
		//get express checkout token
		$getExpressCheckoutDetailsRequest = new GetExpressCheckoutDetailsRequestType($input->getString('token'));

		$getExpressCheckoutReq = new GetExpressCheckoutDetailsReq();
		$getExpressCheckoutReq->GetExpressCheckoutDetailsRequest = $getExpressCheckoutDetailsRequest;
		$paypalService = new PayPalAPIInterfaceServiceService($config);
		try {
			$getECResponse = $paypalService->GetExpressCheckoutDetails($getExpressCheckoutReq);
		} catch (Exception $ex) {
			echo $ex->getMessage();
			exit;
		}
		//------------DO direct checkout---------------------//		
		$order_id = $getECResponse->GetExpressCheckoutDetailsResponseDetails->Custom;
		$this->order->load($order_id);
		$order = $this->order;
		if($this->formatNumber($order->total) != $this->formatNumber($getECResponse->GetExpressCheckoutDetailsResponseDetails->PaymentDetails[0]->OrderTotal->value)){
		
			echo 'Order total is invalied';
			die();
		}
		
		$DoECRequestDetails = new DoExpressCheckoutPaymentRequestDetailsType();
		$DoECRequestDetails->PayerID = $payerId;
		$DoECRequestDetails->Token = $token;
		$DoECRequestDetails->PaymentDetails[0] = $getECResponse->GetExpressCheckoutDetailsResponseDetails->PaymentDetails[0];
		
		$DoECRequest = new DoExpressCheckoutPaymentRequestType();
		$DoECRequest->DoExpressCheckoutPaymentRequestDetails = $DoECRequestDetails;
		
		
		$DoECReq = new DoExpressCheckoutPaymentReq();
		$DoECReq->DoExpressCheckoutPaymentRequest = $DoECRequest;
		
		/*
		 * 	 ## Creating service wrapper object
		Creating service wrapper object to make API call and loading
		*/
		$paypalService = new PayPalAPIInterfaceServiceService($config);
		try {
			/* wrap API method calls on the service object with a try catch */
			$DoECResponse = $paypalService->DoExpressCheckoutPayment($DoECReq);
		} catch (Exception $ex) {
			echo $ex->getMessage();
			exit;
		}
		
		if($DoECResponse->Ack == 'Success'){
			$order->pay_status = 'SUCCESS';
			$order->order_status = 'CONFIRMED';
			$order->tx_id = $DoECResponse->PaymentInfo[0]->TransactionID;
			$order->store();
		}
// 		debug($order);die;
		return $order;
	}
	
	function _processSale()
	{
		$this->write_log('onepay.txt',json_encode($_REQUEST));
	
		$app = JFactory::getApplication();
		
	
		//$app->enqueueMessage($transStatus);
		return $order;
	}
	function null2unknown($data)
	{
		if ($data == "") {
			return "No Value Returned";
		} else {
			return $data;
		}
	}

	/**
	 * Processes the payment form
	 * and returns HTML to be displayed to the user
	 * generally with a success/failed message
	 *
	 * @param $data     array       form post data
	 * @return string   HTML to display
	 */
	function _postPayment( )
	{
		return $this->_displayMessage();
	}

	/**
	 * Prepares variables for the payment form
	 *
	 * @return unknown_type
	 */
	function _renderForm( $data )
	{
		$html = $this->_getLayout('form', $data);
		return $html;
	}
	//render layout 
	private function _getLayout($layout,$data=null){
		ob_start();
		include __DIR__.'/'.$this->_element.'/tmpl/'.$layout.'.php';		
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	
	private function _autoload(){
		require_once (HB_PATH.'/includes/gateways/hbpayment_paypal/lib/vendor/autoload.php');
	}
	
}
