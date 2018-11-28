<?php
HBImporter::helper('params');
//debug($this->item);
?>

<div class="container">
	<form id="adminForm" action="<?php echo admin_url('admin-post.php?action=hbaction&hbaction=airport&task=save')?>" method="post">
		<div class="row">
			<div class="col-md-7">
				<h3><?php echo __('Airport')?></h3>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label"><?php echo __("Airport name")?><span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input class="form-control input-medium required name" required type="text" id="name"
							name="data[name]" maxlength="150" value="<?php echo $this->item ? $this->item->name : ''?>"/>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label"><?php echo __("IATA code")?><span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input class="form-control input-medium required name" required type="text" id="name"
							name="data[iata]" maxlength="150" value="<?php echo $this->item->iata ? $this->item->iata : ''?>"/>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<h3><?php echo __('Car seat price')?></h3>
				<?php foreach(FvnParams::get_car_seat() as $seat=>$text){?>
					<div class="form-group row">
					<label class="col-sm-3 col-form-label"><?php echo __($text)?><span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input class="form-control input-medium required name" required type="number" 
							name="params[<?php echo $seat?>]" maxlength="150" value="<?php echo $this->item->params[$seat]?>"/>
					</div>
				</div>
				<?php }?>
			</div>
			
			
			
			
			<input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
			
			
		</div>
		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<input type="hidden" name="task" value="save"/>
		<center><button type="submit" class="btn btn-primary btn-lg">Lưu</button></center>
		<center><button type="button" onclick="hb_submit_form('save_and_close')" class="btn btn-primary btn-lg">Lưu & đóng</button></center>
	</form>
	
</div><!-- #primary -->
