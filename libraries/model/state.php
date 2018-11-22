<?php
//Store state of model
class FvnModelState extends HBObject{
	public $data;
	public function __construct($array=null){
		parent::__construct($array);
		$this->data = new stdClass();
	}
	public function set($key,$val){
		$this->data->$key = $val;
	}
	public function get($key,$default=''){
		if(isset($this->data->$key)){
			return $this->data->$key;
		}
		return $default;
	}
	//count number of state
	function getCount(){
		return count((array)$this->data);
	}
	
	function getData(){
		return (array)$this->data;
	}
}