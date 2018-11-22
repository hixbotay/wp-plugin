<?php
class HBActionSetting extends hbaction{	
	
	public function save(){
		update_option('hb_params', json_encode($_POST['params']));
		HB_enqueue_message(__('Save success!','hb'));
		wp_redirect(admin_url('admin.php?page=setting'));
		return;
	}
	
	/**
	 * Save setting of gateway
	 */
	public function savegateway(){
		$gateway = $this->input->getString('gateway');
		update_option($gateway, json_encode($_POST['params']));
		HB_enqueue_message(__('Save success!','hb'));
		wp_redirect(admin_url("admin.php?page=setting&layout=checkout&gateway={$gateway}"));
		return;
	}
	
	function set_role(){
		
		$role_object = get_role( 'editor' );
		$role_object->add_cap( 'edit_theme_options' );
		wp_redirect(admin_url("admin.php?page=hb_setting&layout=role"));
		return;
	}
	
}