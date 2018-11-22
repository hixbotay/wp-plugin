<?php
class HBModelOrders extends HbModel{
	public function __construct($table_name='#__fvn_orders', $primary_key = 'id'){
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
		->from('#__fvn_orders');
		if($this->getState('filter_title')){
			$search = '%'.$this->getState('filter_title').'%';
			$query->where('(CONCAT(firstname," ",lastname) LIKE '.$query->quote($search).' OR order_number LIKE '.$query->quote($search).' OR mobile LIKE '.$query->quote($search).' 
					OR email LIKE '.$query->quote($search).')');
		}
		if($this->getState('start')){
			$query->where('start = '.$this->quote($this->getState('start')));
		}
		$query->order('id DESC');
		return $query;		
	}
	
	function getComplexItem($id){
		$order = $this->getItem($id);
		$result = new stdClass();
		if($order->id){
			global $wpdb;
			$result->order = $order;
			HBImporter::model('period','country','airport','processing_time');
			HBImporter::helper('math','date','currency','price');
			$config = HBFactory::getConfig();
			$result->country = (new HBModelCountry())->getDataByCode($result->order->country_code);
			$result->period = (new HBModelPeriod())->getItem($result->order->period_id);		
			$result->airport = (new HBModelAirport())->getItem($result->order->airport_id);				
			$result->processing_time = (new HBModelProcessing_time())->getItem($result->order->processing_time);
			$result->order->params = json_decode($result->order->params,true);
			$result->order->price = $result->order->params['price'];
			$result->passengers = $wpdb->get_results('select * from '.$wpdb->prefix.'fvn_passengers where order_id='.$order->id);
			return $result;
		}else{
			return false;
		}		
	}
}