<?php
/**
 * @package 	FVN-extension
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');

class HBActionHairsalon extends HBAction{
	
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
		if ( empty( $_REQUEST['hb_meta_nonce'] ) || ! wp_verify_nonce( $_REQUEST['hb_meta_nonce'], 'hb_meta_nonce' ) ) {
			$result['error']['msg'] = __('Session expired');
			return $this->ajax_process_order($result);
		}
		global $wpdb;
		
		
		$requires = array('fullname','mobile','salon_id','staff_id','timeframe_id');
		foreach($requires as $key){
			if(!isset($_REQUEST[$key]) || empty($_REQUEST[$key])){
				$result['error']['msg'] = 'Vui lòng điền đầy đủ thông tin';
				return $this->ajax_process_order($result);
			}
		}
		
		$data = array();
		foreach($requires as $field){
			$data[$field] = $_REQUEST[$field];
		}
		
		HBImporter::libraries('model');
		HBImporter::helper('hairsalon');
		
		$model = new HbModel('#__orders','id');	
		
		$time_frame = HBSalonHelper::get_timeframes($data['timeframe_id']);
		$data['order_status']="PENDING";
		$data['order_number'] = HBHelper::random_string(5);
		$data['type'] = 'SALON';
		$data['start'] = $time_frame->start;
		$data['end'] = $time_frame->end;
		$data['created']= (new DateTime())->format('Y-m-d H:i:s');
		//debug($data);
		$check = $model->save($data);
		if($check){
// 			debug($data);die;
			$result['status']=1;
			$result['url']= site_url('thank-you');
		}
		return $this->ajax_process_order($result);
		exit;
	}
}