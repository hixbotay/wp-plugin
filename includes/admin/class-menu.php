<?php
/**
 * @package 	FVN-extension
 * @author 		Vuong Anh Duong
 * @link 		http://http://woafun.com/
 * @copyright 	Copyright (C) 2011 - 2012 Vuong Anh Duong
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: airport.php 66 2012-07-31 23:46:01Z quannv $
 **/

//namespace HB;

// Check to ensure this file is included in Joomla!
defined ( 'ABSPATH' ) or die ();

class HB_Menu {
	
	static function addMenu(){
		add_action( 'admin_menu', array( get_called_class(), 'admin_menu' ));
		
	}
	
	public static function admin_menu() {	
		
		add_menu_page( __('Booking'), __('Booking'), 'edit_posts', 'orders',  array( get_called_class(), 'booking' ), site_url().'/wp-content/plugins/visa-fvn/assets/images/logo.png', 5 );	
			
		add_submenu_page( 'orders', __('Country'), __('Country'),'edit_posts', 'country',  array( get_called_class(), 'country' ), site_url().'/wp-content/plugins/visa-fvn/assets/images/booking.png', 5 );
		add_submenu_page( 'orders', __('Period'), __('Period'),'edit_posts', 'period',  array( get_called_class(), 'price' ), site_url().'/wp-content/plugins/visa-fvn/assets/images/booking.png', 5 );
		add_submenu_page( 'orders', __('Processing time'), __('Processing time'),'edit_posts', 'processing_time',  array( get_called_class(), 'processing_time' ), site_url().'/wp-content/plugins/visa-fvn/assets/images/booking.png', 5 );
		add_submenu_page( 'orders', __('Airport'), __('Airport'),'edit_posts', 'airport',  array( get_called_class(), 'airport' ), site_url().'/wp-content/plugins/visa-fvn/assets/images/booking.png', 5 );
		add_submenu_page( 'orders', __('Setting'), __('Setting'),'manage_options', 'setting',  array( get_called_class(), 'dashboard' ), site_url().'/wp-content/plugins/visa-fvn/assets/images/booking.png', 5 );
		
	}
	
	public static function dashboard(){
	
		HBImporter::includes('admin/setting/view');
	}
		
	public static function booking(){	
		HBImporter::includes('admin/orders/view');
	}
	public static function country(){	
		HBImporter::includes('admin/country/view');
	}
	public static function price(){	
		HBImporter::includes('admin/period/view');
	}
	public static function airport(){	
		HBImporter::includes('admin/airport/view');
	}
	public static function processing_time(){
		HBImporter::includes('admin/processing_time/view');
	}
	
	
	public static function add_register_page(){
		HBImporter::includes('admin/register/view');
	}
		
	//setting page
	public static function add_setting_page(){
		HBImporter::includes('admin/setting/view');
	}
}
