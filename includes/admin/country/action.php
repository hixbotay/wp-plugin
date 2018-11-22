<?php

class HBActionCountry extends hbaction{	
	
	
	function getInputData(){
		$data = parent::getInputData();
		$data['params'] = json_encode($data['params']);
		
		return $data;
	}
	
}