<?php

class HBActionAirport extends hbaction{	
	function getInputData(){
		$data = parent::getInputData();
		$data['params'] = json_encode($this->input->get('params'));
		return $data;
	}
}