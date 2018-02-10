<?php
/**
 * @package 	Bookpro
 * @author 		Joombooking
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined('ABSPATH') or die('Restricted access');

class HBActionTour extends HBAction{
	
	function book(){ 
// 		debug($_REQUEST);
		global $wpdb;
		
		$result = array(
				'status' => 0,
				'error' => array(
						'code' => '',
						'msg' => 'Error'
				)
		);
		$requires = array('tour_id','fullname','email','mobile');
		foreach($requires as $key){
			if(!isset($_REQUEST[$key]) || empty($_REQUEST[$key])){
				$result['error']['msg'] = __('Please input').' '.__($key);
				return $this->ajax_process_order($result);
			}
		}
		
		$fields = array('tour_id','fullname','email','mobile','notes','pay_method','adult');
		$data = array();
		foreach($fields as $field){
			$data[$field] = $_REQUEST[$field];
		}
		
		HBImporter::libraries('model');
		$model = new HbModel('#__orders','id');	
		
		$tour=ThemexTour::getTour($_REQUEST['tour_id'], true);		
// 		debug($tour);die;
		$data['total'] = ($tour['total'])*$data['adult'];
		$data['pay_status']="PENDING";
		$data['order_status']="PENDING";
		$data['order_number'] = HBHelper::random_string(5);
		$data['currency'] = 'VND';
		$data['created']= (new DateTime())->format('Y-m-d H:i:s');
		//debug($data);
		$check = $model->save($data);
		if($check){
// 			debug($data);die;
			if($data['pay_method']=='offline'){
// 				die;
				$result['status']=1;
				$result['url'] = HBHelper::get_order_link((object)$data);
				hb_enqueue_message(__('Booking success'));
			}else{
				$result = array(
						'status' => 0,
						'error' => array(
								'code' => '',
								'msg' => 'Xử lí đến cổng Onepay. Đang hoàn thiện!'
						)
				);
			}
		}else{
			$result = array(
					'status' => 0,
					'error' => array(
							'code' => '',
							'msg' => $wpdb->last_error
					)
			);
		}
		
		return $this->ajax_process_order($result);
		exit;
	}
	private function ajax_process_order($result){
		echo json_encode($result);
		exit;
	}
	
}