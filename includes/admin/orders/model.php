<?php
class HBModelOrders extends WP_List_Table{
	public function getItems(){
		global $wpdb;
		return $wpdb->get_results("
				Select o.*,t.post_title as tour_name from {$wpdb->prefix}orders as o
				LEFT JOIN {$wpdb->prefix}posts as t ON t.ID=o.tour_id 
				order by created DESC");
	}
}