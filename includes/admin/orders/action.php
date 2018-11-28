<?php
class HBActionOrders extends hbaction{
	function getInputData(){
		$data = parent::getInputData();
		if($data['id']){
			$this->model->load($data['id']);
			$params = json_decode($this->model->params,true);
			$params['image_result'] = $data['params']['image_result'];
			$data['params'] =json_encode($params);
		}
		return $data;
	}
	public function save(){
		HBImporter::helper('date');
		$passengers = $this->input->get('passenger');
		foreach($passengers as &$p){
			$p['birthday'] = HBDateHelper::createFromFormatYmd($p['birthday']);
		}
		//debug($passengers);die;
		$model = new HBModel('#__fvn_passengers','id');
		if(!$model->batch_save($passengers)){
			hb_enqueue_message(__('Save passengers error'),'error');
		}
		parent::save();
		return;
	}
	
	function exportCsv(){
		HBImporter::helper('csvfilehelper');
		$this->load_model();
		$items = $this->model->getItems();
		CsvFileHelper::download($items, 'order.csv');
		exit;
	}
	
	
}