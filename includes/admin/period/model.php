<?php
class HBModelPeriod extends HbModel{
	public function __construct($table_name='#__fvn_periods', $primary_key = 'id'){
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
		->from('#__fvn_periods');
		if($this->getState('filter_title')){
			$query->where('name LIKE '.$query->quote('%'.$this->getState('filter_title').'%'));
		}
		return $query;		
	}
	
	public function get_Period_by_cat($cat_id){
		if(empty($cat_id)){
			return [];
		}
		global $wpdb;
		
		$query = "Select p.* from ".$this->get_table_name()." as p 
				left Join ".$wpdb->prefix."Period_categories as c ON c.id=p.category_id				
				where p.category_id= {$cat_id} OR c.parent_id={$cat_id} group by p.id ";
		
		$query .= ' order by created DESC ';
		if($this->get_state('list.limit')){
			$query .= 'LIMIT 0,'.$this->get_state('list.limit');
		}
		
		
				
		return $wpdb->get_results($query,OBJECT_K);
	}
}