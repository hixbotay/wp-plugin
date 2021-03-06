<?php
HBImporter::helper('params');
//debug($this->item);
?>
<h3><?php echo __('Processing time')?></h3>
<div class="container">
	<form id="adminForm" action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=processing_time&task=save')?>" method="post">
		<div class="">
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"><?php echo __('Processing time name')?><span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input class="form-control input-medium required name" required type="text" id="name"
						name="data[name]" maxlength="150" value="<?php echo $this->item ? $this->item->name : ''?>"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"><?php echo __('Price tour')?><span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input class="form-control input-medium required name" required type="text" id="name"
						name="data[price_tour]" maxlength="150" value="<?php echo $this->item->price_tour?>"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"><?php echo __('Price business')?><span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input class="form-control input-medium required name" required type="text" id="name"
						name="data[price_bus]" maxlength="150" value="<?php echo $this->item->price_bus?>"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"><?php echo __('Verify passport image')?><span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<?php echo FvnHtml::booleanlist('data[verify_image]','class="form-control" ',$this->item->verify_image)?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label"><?php echo __('Description')?></label>
				<div class="col-sm-9">
					<?php wp_editor( $this->item->description, 'data_description', array('textarea_name'=>'data[description]') );?>
				</div>
			</div>	
			<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
		</div>
		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<input type="hidden" name="task" value="save"/>
		<center><button type="submit" class="btn btn-primary btn-lg"><?php echo __('Save')?></button></center>
		<center><button type="button" onclick="hb_submit_form('save_and_close')" class="btn btn-primary btn-lg"><?php echo __('Save and close')?></button></center>
	</form>
	
</div><!-- #primary -->
