<?php
class HBActionOrders extends hbaction{
	
	public function save(){
		HBImporter::helper('date');
		$passengers = $this->input->get('passenger');
		foreach($passengers as &$p){
			$p['birthday'] = HBDateHelper::createFromFormatYmd($p['birthday']);
		}
		//debug($passengers);die;
		$model = new HBModel('#__fvn_passengers','id');
		if(!$model->batch_save($passengers)){
			hb_enqueue_message(__('Save passengers error'),'error');
		}
		parent::save();
		return;
	}
	
	
	public function deleteitem(){
        global $wpdb;
        $input = $_POST;
        $id = $input['itemID'];
        $resul = $wpdb->delete("{$wpdb->prefix}orders", array('id' => $id));

        if ($resul){
            HB_enqueue_message(__('Deleted item!','hb'));
        }else{
            HB_enqueue_message(__('Error!','hb'));
        }
        wp_redirect("admin.php?page=booking");
        exit;
    }
    public function deletes(){
        global $wpdb;
        $input = $_POST;
        $id = $input['id'];

        if (empty($id)){
            HB_enqueue_message(__('Vui lòng chọn ít nhất 1 booking','hb'));
            wp_redirect("admin.php?page=booking");
            exit;
        }
        $deleted = '';
        foreach ($id AS $value){
            $result = $wpdb->delete("{$wpdb->prefix}orders", array('id' => $value));
            if ($result){
                $deleted .= $value . ", ";
            }
        }

        if ($deleted){
            HB_enqueue_message(__('Đã xóa: ' . $deleted,'hb'));
        }else{
            HB_enqueue_message(__('Error!','hb'));
        }

        wp_redirect("admin.php?page=booking");
        exit;
    }
	
}