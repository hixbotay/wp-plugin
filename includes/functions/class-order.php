<?php
/**
 * @package 	FVN-extension
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');

class HBActionOrder extends HBAction{
	function caculate_price(){
		HBImporter::model('period','country','airport','processing_time');
		HBImporter::helper('math','date','currency','price');
		$config = HBFactory::getConfig();
		$country = (new HBModelCountry())->getDataByCode($this->input->get('country_code'));
		$periods = (new HBModelPeriod())->getList();		
		$airport = (new HBModelAirport())->getItem($this->input->get('airport_id'));		
		
		$processing_time = (new HBModelProcessing_time())->getItem($this->input->get('processing_time'));
		$period = HBHelperMath::filterArrayObject($periods, 'id', $this->input->get('period_id'));
		
		$data = [];
		$params = array(
			'period'=>$period,
			'country'=> $country,
			'processing_time'=> $processing_time,
			'passenger_number' => $this->input->get('passenger_number'),
			'private_later'=> $this->input->get('private_later'),
			'airport_fast_track'=> $this->input->get('airport_fast_track'),
			'car_service'=> $this->input->getInt('car_service'),
			'airport'=>$airport,
			'purpose_of_visit'=> $this->input->get('purpose_of_visit'),
		);
		$price = FvnPriceHelper::caculate($params);
		
		$data['country']=$country->country_name ? $country->country_name : __('Please select country');
		$country_params = json_decode($country->params);
		//limit period for a country
		$data['country_limit_period'] = '';
		if($country_params){
			$data['country_limit_period'] = '';
			foreach($periods as $p){
				if(!isset($country_params->{$p->id}->status) || $country_params->{$p->id}->status){
					$data['country_limit_period'] .= "<option value='{$p->id}'>{$p->name}</option>";
				}	
			}
		}
		
		
		$data['country_notice'] = $country->description;
		$data['passenger_number']= $params['passenger_number'] ==1 ? '1 '.__('Applicant') : $params['passenger_number'].' '.__('Applicants');
		$data['period'] = $period->name.'<br>'.$period->description;
		$data['visa_service_fee'] = HBCurrencyHelper::displayPrice($price['single']).
			' X '.$data['passenger_number'].' '.
			($data['passenger_number']>1?__('applicants'):__('applicant')).
			' = '.HBCurrencyHelper::displayPrice($price['main']);
		
		$data['processing_time'] = HBCurrencyHelper::displayPrice($price['processing_time']['single']).
			' X '.$data['passenger_number'].($data['passenger_number']>1?__('persons'):__('person')).
			' = '.HBCurrencyHelper::displayPrice($price['processing_time']['total']);
		
		$data['purpose_of_visit'] = $this->input->get('purpose_of_visit')? __('For '.($this->input->get('purpose_of_visit')=='bus'?'business':'tourist')) : __('Please select');
		$data['airport_id'] = isset($airport->id) ? $airport->name : '';
		$data['start'] = $this->input->get('start');
		$data['private_later'] = isset($price['private_later']) ? HBCurrencyHelper::displayPrice($price['private_later']) : '';
		$data['total'] = HBCurrencyHelper::displayPrice($price['total']);
		$data['extra_service'] = HBHelper::renderLayout('extra_service',array('params'=>$params,'price'=>$price));		
		
// 		if($)
		
		$this->renderJson($data);
	}
	
	function book(){
		// 		debug($_REQUEST);
		$result = array(
				'status' => 0,
				'error' => array(
						'code' => '',
						'msg' => 'Error'
				)
		);
		//check nonce
		// 		if ( empty( $_REQUEST['hb_meta_nonce'] ) || ! wp_verify_nonce( $_REQUEST['hb_meta_nonce'], 'hb_meta_nonce' ) ) {
		// 			$result['error']['msg'] = __('Session expired');
		// 			return $this->ajax_process_order($result);
		// 		}
		//validate image
		
		HBImporter::model('period','country','airport','processing_time','orders');
		HBImporter::helper('math','date','currency','price');
		
		$data = $this->input->get('jform',array());
		$data['start'] = HBDateHelper::createFromFormatYmd($data['start']);
		
		$config = HBFactory::getConfig();
		$country = (new HBModelCountry())->getDataByCode($data['country_code']);
		$period = (new HBModelPeriod())->getItem($data['period_id']);		
		$airport = (new HBModelAirport())->getItem($data['airport_id']);		
		$processing_time = (new HBModelProcessing_time())->getItem($data['processing_time']);
		$passengers = $this->input->get('person');
		$input_params = $this->input->get('params');
		
		$params = array(
			'period'=>$period,
			'country'=> $country,
			'airport'=>$airport,
			'processing_time'=> $processing_time,
			'passenger_number' => count($passengers),
			'private_later'=> $data['private_later'],
			'airport_fast_track'=> $input_params['airport_fast_track'],
			'car_service'=> $input_params['car_service'],
			'purpose_of_visit'=> $data['purpose_of_visit'],
			'start' => $data['start']
		);
		$price = FvnPriceHelper::caculate($params);
	
		global $wpdb;
		
		// 		debug($tour);die;
		$name = explode(' ', $data['fullname'],2);
		$data['firstname'] = $name[0];
		$data['lastname'] = $name[1];		
		$data['total'] = $price['total'];
		$data['adult'] = count($passengers);
		$data['pay_status']="PENDING";
		$data['order_status']="PENDING";
		$data['order_number'] = strtoupper(HBHelper::random_string(5));
		$data['type'] = 'VISA';
		$data['currency'] = $config->main_currency;
		$data['created']= current_time( 'mysql' );
		
		
		$order_params = array();
		$order_params['price'] = $price;		
		if($data['flight']){
			$order_params['flight'] = ['number'=>$input_params['flight_number']];
		}else{
			$data['start_time'] = '';
		}
		$order_params['car_service'] = $input_params['car_service'];
		$order_params['airport_fast_track'] = $input_params['airport_fast_track'];
		$data['params'] = json_encode($order_params);
// 		debug($data);die;
		$order = new HBModelOrders();
		try{
			//@TODO cho nay dhs no ko chay
			$order->bind($data);
			$check = $order->batch_save(array($data));
			$order->id = $wpdb->insert_id;			
			$path = ABSPATH.'/wp-content/uploads/passports/';
			if(!is_dir($path)){
				mkdir($path);
			}
			if($check){
// 				$path .= $order->id.'/';
// 				if(!is_dir($path)){
// 					mkdir($path);
// 				}
				
				$passenger_model = new HbModel('#__fvn_passengers','id');
				foreach($passengers as &$p){
					$name = explode(' ', $p['fullname'],2);
					$p['firstname'] = $name[0];
					$p['lastname'] = $name[1];
					$p['birthday'] = HBDateHelper::createFromFormatYmd($p['birthday']);
					$p['order_id'] = $order->id;
					
				}
				$passenger_model->batch_save($passengers);
				
				//gui mail sau khi book
				HBImporter::model('orders');
				HBImporter::helper('currency','email');
				$mail = new FvnMailHelper($order->id);
				$mail->sendPayment();
				
				wp_redirect(site_url('payment?order_id='.$order->id));
				exit;
			}else{
				echo $order->getError();die;
				$result = array(
						'status' => 0,
						'error' => array(
								'code' => '',
								'msg' => $wpdb->last_error
						)
				);
			}
		}catch (Exception $e){
			echo $e->getMessage();die;
		}
		hb_enqueue_message(__('Booking error'),'error');
		wp_redirect(site_url('booking-step2?order_id='.$order->id.'&'.http_build_query($this->input->get('jform'))));
		return $this->ajax_process_order($result);
		exit;
	}
	
	function upload_passport_image(){
		$relative_path = 'wp-content/uploads/passports/';
		$path = ABSPATH.$relative_path;
		if(!is_dir($path)){
			mkdir($path);
		}
		$number = $this->input->get('passport_number');
		if(!$number){
			$this->renderError(__('Invalid passport number'));
		}
		$imageFileType = strtolower(pathinfo($_FILES['uploadfile']['name'],PATHINFO_EXTENSION));
		$target_file = $path.$number.'.'.$imageFileType;
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
		if($check == false || ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif")) {
			$this->renderError(__('File is not an image'));
		} 
		// override if exist
		if (file_exists($target_file)) {
			unlink($target_file);
		}
		// Check file size
		if ($_FILES["uploadfile"]["size"] > 1000000) {
			$this->renderError(__('Sorry, your file is too large'));
		}
		//upload
		if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
			echo '/'.$relative_path."{$number}.{$imageFileType}";
		} else {
			$this->renderError(__('Sorry, there was an error uploading your file'));
		}
		exit;
			
	}
}