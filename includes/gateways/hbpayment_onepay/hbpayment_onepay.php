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

class HBPayment_Onepay
{

	public $_element = 'hbpayment_onepay';
	public $params;
	public $returnUrl;
	public $cancelUrl;
	public $notifyUrl;
	public $config;
	/*
	 * Class Order 
	 */
	public $order;

	function __construct($main_config) {
		$this->config = $main_config;
		$config = get_option($this->_element);
		$this->params = json_decode($config);
		
		$currency = $this->config->main_currency;
		if(empty($currency)){
			$currency = trim($this->getParam('api_currency'));
		}
		$this->currency = $currency;//'USD';
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
	
	
	function _prePayment( $data )
	{
		$MID = $this->_getParam('sandbox')? $this->_getParam('test_merchant_id') : $this->_getParam('merchant_id');
		$access_code= $this->_getParam('sandbox')? $this->_getParam('test_access_code') : $this->_getParam('access_code');
		$SECURE_SECRET =$this->_getParam('sandbox')?  JString::trim($this->_getParam('test_merchant_key')) :JString::trim($this->_getParam('merchant_key'));
		
		
		//get language
		$lang=JFactory::getLanguage();
		$local=substr($lang->getTag(),0,2);
		
		$params=array('vpc_Merchant'=>$MID,
				'vpc_AccessCode'=>$access_code,
				'vpc_OrderInfo'=>$data['order_number'],
				'vpc_Amount'=> $this->formatNumber($data['total']),
				'vpc_ReturnURL'=>$successURL,
				//'vpc_Currency' => JComponentHelper::getParams('com_bookpro')->get('main_currency'),
				'vpc_Version'=>'2',
				'vpc_Command'=>'pay',
				'vpc_Locale'=>$local,
				'vpc_MerchTxnRef'=>date('YmdHis').rand(),
				'vpc_TicketNo' => $_SERVER['REMOTE_ADDR'],
				'Title' => $this->_getParam('gateway',JUri::root())
		);
		
		
		// add the start of the vpcURL querystring parameters
		$vpcURL = $this->_getPostUrl()."?";
		$params['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);
		$md5HashData = "";
		ksort ($params);
		
		// set a parameter to show the first pair in the URL
		$appendAmp = 0;
		
		foreach($params as $key => $value) {
		
			// create the md5 input and URL leaving out any fields that have no value
			if (strlen($value) > 0) {
		
				// this ensures the first paramter of the URL is preceded by the '?' char
				if ($appendAmp == 0) {
					$vpcURL .= urlencode($key) . '=' . urlencode($value);
					$appendAmp = 1;
				} else {
					$vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
				}
				//$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
				if ((strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
					$md5HashData .= $key . "=" . $value . "&";
				}
			}
		}
		//xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
		$md5HashData = rtrim($md5HashData, "&");
		// Create the secure hash and append it to the Virtual Payment Client Data if
		// the merchant secret has been provided.
		if (strlen($SECURE_SECRET) > 0) {
			//$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
			// Thay hàm mã hóa dữ liệu
			$vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$SECURE_SECRET)));
		}
		
		// FINISH TRANSACTION - Redirect the customers using the Digital Order
		// ===================================================================
		//echo '<pre>';
		//print_r(explode('&',$vpcURL));die;
		header("Location: ".$vpcURL);
		
		wp_redirect($this->returnUrl);
		return;

	}
	function _getPostUrl($full = true)
	{
	
		if($this->$this->params->get('international')){
			$url = $this->params->get('sandbox') ? 'https://mtf.onepay.vn/vpcpay/vpcpay.op' : 'https://onepay.vn/vpcpay/vpcpay.op';
		}else{
			$url = $this->params->get('sandbox') ? 'https://mtf.onepay.vn/onecomm-pay/vpc.op' : 'https://onepay.vn/onecomm-pay/vpc.op';
		}
	
	
		return $url;
	}
	
	public function _displayMessage(){		
		$this->order->load($this->getInput('order_id'));
		$this->order->pay_status = $this->getParam('pay_status','SUCCESS');
		$this->order->order_status = $this->getParam('order_status','CONFIRMED');
		$this->order->store();
		
		return $this->order;
	}
	
	function _processSale()
	{
		$this->write_log('onepay.txt',json_encode($_REQUEST));
	
		$app = JFactory::getApplication();
		$SECURE_SECRET =$this->_getParam('sandbox')?  JString::trim($this->_getParam('test_merchant_key')) :JString::trim($this->_getParam('merchant_key'));
	
		$vpc_Txn_Secure_Hash = $_GET ["vpc_SecureHash"];
		unset ( $_GET ["vpc_SecureHash"] );
	
		// set a flag to indicate if hash has been validated
		$errorExists = false;
	
		ksort ($_GET);
	
		if (strlen ( $SECURE_SECRET ) > 0 && $_GET ["vpc_TxnResponseCode"] != "7" && $_GET ["vpc_TxnResponseCode"] != "No Value Returned") {
				
			//$stringHashData = $SECURE_SECRET;
			//*****************************khởi tạo chuỗi mã hóa rỗng*****************************
			$stringHashData = "";
				
			// sort all the incoming vpc response fields and leave out any with no value
			foreach ( $_GET as $key => $value ) {
				//        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
				//            $stringHashData .= $value;
				//        }
				//      *****************************chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về*****************************
				if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
					$stringHashData .= $key . "=" . $value . "&";
				}
			}
			//  *****************************Xóa dấu & thừa cuối chuỗi dữ liệu*****************************
			$stringHashData = rtrim($stringHashData, "&");
				
				
			//    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $stringHashData ) )) {
			//    *****************************Thay hàm tạo chuỗi mã hóa*****************************
			if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*',$SECURE_SECRET)))) {
				// Secure Hash validation succeeded, add a data field to be displayed
				// later.
				$hashValidated = "CORRECT";
			} else {
				// Secure Hash validation failed, add a data field to be displayed
				// later.
				$hashValidated = "INVALID HASH";
			}
		} else {
			// Secure Hash was not validated, add a data field to be displayed later.
			$hashValidated = "INVALID HASH";
		}
	
		// Define Variables
		// ----------------
		// Extract the available receipt fields from the VPC Response
		// If not present then let the value be equal to 'No Value Returned'
		// Standard Receipt Data
		$amount = $this->null2unknown ( $_GET ["vpc_Amount"] );
		$locale = $this->null2unknown ( $_GET ["vpc_Locale"] );
		//$batchNo = $this->null2unknown ( $_GET ["vpc_BatchNo"] );
		$command = $this->null2unknown ( $_GET ["vpc_Command"] );
		//$message = $this->null2unknown ( $_GET ["vpc_Message"] );
		$version = $this->null2unknown ( $_GET ["vpc_Version"] );
		//$cardType = $this->null2unknown ( $_GET ["vpc_Card"] );
		$orderInfo = $this->null2unknown ( $_GET ["vpc_OrderInfo"] );
		//$receiptNo = $this->null2unknown ( $_GET ["vpc_ReceiptNo"] );
		$merchantID = $this->null2unknown ( $_GET ["vpc_Merchant"] );
		//$authorizeID = $this->null2unknown ( $_GET ["vpc_AuthorizeId"] );
		$merchTxnRef = $this->null2unknown ( $_GET ["vpc_MerchTxnRef"] );
		$transactionNo = $this->null2unknown ( $_GET ["vpc_TransactionNo"] );
		//$acqResponseCode = $this->null2unknown ( $_GET ["vpc_AcqResponseCode"] );
		$txnResponseCode = $this->null2unknown ( $_GET ["vpc_TxnResponseCode"] );
		//error message
		$error_msg = $this->null2unknown ( $_GET ["vpc_Message"] );
		if(!empty($error_msg)){
			$app->enqueueMessage($error_msg);
		}
	
		if($hashValidated=="CORRECT" && $txnResponseCode=="0"){
			JTable::addIncludePath( JPATH_ADMINISTRATOR.'/components/com_bookpro/tables' );
			$order_number = $app->input->getString('vpc_OrderInfo');
			$order = JTable::getInstance('Orders', 'Table');
			$order->load(array('order_number'=>$order_number));
			if($order){
				$order->tx_id       = $transactionNo;
				$order->pay_status   = 'SUCCESS';
				$order->order_status   = 'CONFIRMED';
				$order->store();
			}
			$transStatus = "PLG_ONE_PAY_TRANSACTION_SUCCESS";
		}elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
			$transStatus = "PLG_ONE_PAY_TRANSACTION_PENDING";
		}else {
			$transStatus = "PLG_ONE_PAY_TRANSACTION_FAILED";
		}
	
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
	function _postPayment( $data )
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
// 		require_once (JPATH_ROOT.'/plugins/bookpro/payment_cash/lib/vendor/autoload.php');
	}
	
}
