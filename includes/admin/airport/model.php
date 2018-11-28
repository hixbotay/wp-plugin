<?php
class HBModelAirport extends HbModel{
	public function __construct($table_name='#__fvn_airports', $primary_key = 'id'){
		return parent::__construct($table_name, $primary_key);
	}
	
	public function check(){
		if(!$this->id){
			$this->created = current_time( 'mysql' );
		}
		return true;
	}
	
	protected function getQueries(){
		$query = HBFactory::getQuery();
		$query->select('*')
		->from('#__fvn_airports');
		if($this->getState('filter_title')){
			$query->where('name LIKE '.$query->quote('%'.$this->getState('filter_title').'%'));
		}
		return $query;		
	}
	
	
}