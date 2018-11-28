<?php
//load include file by Url
defined ( 'ABSPATH' ) or die ();
class HB_Admin_Autoload{
	
	public function __construct(){
		return true;
	}
	
	public function load(){
		if(is_file(ABSPATH.'/tmp/demo-mode.txt')){
			
		}
		//load require files when show list of post_type
		if(isset($_REQUEST['post_type'])){
			$view_name = substr($_REQUEST['post_type'], 8);
			//load list file if exist
			if($this->is_file('includes/admin/'.$view_name.'/list.php')){
				HBImporter::includes('admin/'.$view_name.'/list');
			}
			
		}
		add_action( 'admin_enqueue_scripts', array($this,'enque_scripts'));
		add_action( 'admin_init', array($this,'execute_action'));
	}
	function enque_scripts(){
		wp_enqueue_style( 'bootstrap', site_url(). '/wp-content/plugins/visa-fvn/assets/css/bootstrap.css', '', '1.0.0' );
		wp_enqueue_script( 'bootstrap', site_url(). '/wp-content/plugins/visa-fvn/assets/js/bootstrap.min.js', array('jquery'), '1.0.0' );
		wp_enqueue_script( 'hbpro-plg-js', site_url(). '/wp-content/plugins/visa-fvn/assets/js/hbpro.js', array('jquery'), '1.0.0', true );
	}
	
	public function is_file($filename){
		return is_file(HB_PATH.$filename);
	}
	function execute_action(){
		
		$input = HBFactory::getInput();
		$request_action = $input->get('hbaction');
	
		//$user = wp_get_current_user();
		//debug($user);die;
		$task = $input->get('task');
		if($request_action && $task){
			$meta_nonce = $input->get('hb_meta_nonce');
			if ( empty( $meta_nonce ) || ! wp_verify_nonce( $input->get('hb_meta_nonce'), 'hb_action' ) ) {
				//@TODO check nonce
			}
			//Import action by request
			HBImporter::viewaction($request_action);
			$class = 'hbaction'.$request_action;
	
			$action = new $class;
			$action->execute($task);
			exit;
		}
		return;
	}
	
	
	
}
