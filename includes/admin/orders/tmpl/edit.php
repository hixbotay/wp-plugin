<?php 
	
HBImporter::model('period','country','airport','processing_time','orders');
HBImporter::helper('math','date','currency','orderstatus','paystatus');
FvnHtml::add_datepicker_lib();
$config = HBFactory::getConfig();
$countries = (new HBModelCountry())->getList();
$periods = (new HBModelPeriod())->getList();
$airports = (new HBModelAirport())->getList();
$processing_times = (new HBModelProcessing_time())->getList();

$order_complex = (new HBModelOrders())->getComplexItem($this->item->id);
// debug($this->item->params);die;
?>

<h1>Quản lí đơn <a href="<?php echo admin_url('admin.php?page=orders')?>" class="page-title-action" >Quay lại</a></h1>
<form action="<?php echo admin_url('admin.php?hbaction=orders&task=save')?>" method="post">
<div class="container">
<div id="primary" class="row">
	<div class="col-md-8">
		
        <input type="hidden" value="<?php echo $this->input->get('id')?>" name="id"/>
			<div class="row form-group">
                <div class="col-md-5"><?php echo __('Firstname').': '.$this->item->title ?></div>
				<div class="col-md-7"><input type="text" value="<?php echo $this->item->firstname ?>" name="data[firstname]" class="regular-text ltr"></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5"><?php echo __('Lastname')?></div>
				<div class="col-md-7"><input type="text" value="<?php echo $this->item->lastname ?>" name="data[lastname]" class="regular-text ltr"></div>
			</div>
						
			<div class="row form-group">
                <div class="col-md-5">Mobile</div>
				<div class="col-md-7"><input type="text" value="<?php echo $this->item->mobile ?>" name="data[mobile]" class="regular-text ltr"></div>
			</div>
			
			<div class="row form-group">
                <div class="col-md-5">Email</div>
				<div class="col-md-7"><input type="text" value="<?php echo $this->item->email ?>" name="data[email]" class="regular-text ltr"></div>
			</div>
			
			<div class="row form-group">
                <div class="col-md-5">Notes</div>
				<div class="col-md-7"><textarea type="text" name="data[notes]" class="regular-text ltr"><?php echo $this->item->notes ?></textarea></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5">Passport holder</div>
				<div class="col-md-7"><?php echo FvnHtml::select($countries, 'data[country_code]', 'class="form-control change-price group_size"', 'country_code', 'country_name',$this->item->country_code,'country_code')?></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5">Number of visa</div>
				<div class="col-md-7"><?php echo count($order_complex->passengers)?></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5"><?php echo __('Type of visa')?> </div>
				<div class="col-md-7"><?php echo FvnHtml::select($periods, 'data[period_id]', 'class="form-control change-price visa_type"', 'id', 'name',$this->item->period_id,'period_id')?></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5"><?php echo __('Processing time')?> </div>
				<div class="col-md-7"><?php echo FvnHtml::select($processing_times, 'data[processing_time]', 'class="form-control change-price visa_type"', 'id', 'name',$this->item->processing_time,'processing_time')?></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5">Purpose of visit</div>
				<div class="col-md-7"><select id="purpose_of_visit" name="data[purpose_of_visit]" class="form-control change-price visit_purpose">
									
									<option value="tour" <?php echo $this->item->purpose_of_visit=='tour'?'selected="selected"':''?>>For tourist</option>
									<option value="bus" <?php echo $this->item->purpose_of_visit=='bus'?'selected="selected"':''?>>For business</option></select></div>
			</div>
			<div class="row form-group">
                <div class="col-md-5">Airport</div>
				<div class="col-md-7"><?php echo FvnHtml::select($airports, 'data[airport_id]', 'class="form-control change-price arrival_port"', 'id', 'name',$this->item->airport_id,'airport_id')?></div>
			</div>
			<div class="row form-group">
				<div class="col-md-5"><?php echo __('Arrival date')?></div>
				<div class="col-md-7"><?php echo HBDateHelper::display($this->item->start).' '.$this->item->start_time.'<br>';
				echo $this->item->params['flight_number']?__('Flight number').' '.$this->item->params['flight_number']:''?></div>
			</div>
			<h3>Passenger</h3>
			<?php foreach($order_complex->passengers as $i=>$p){?>
				<h4>Passenger <?php echo ($i+1)?></h4>
				<div class="row form-group">
					<div class="col-md-5">Firstname</div>
					<div class="col-md-7"><input type="text" value="<?php echo $p->firstname ?>" name="passenger[<?php echo $p->id?>][firstname]" class="regular-text ltr" /></div>
				</div>
				<div class="row form-group">
					<div class="col-md-5">Lastname</div>
					<div class="col-md-7"><input type="text" value="<?php echo $p->lastname ?>" name="passenger[<?php echo $p->id?>][lastname]" class="regular-text ltr"/></div>
				</div>
				<div class="row form-group">
					<div class="col-md-5">Birthday</div>
					<div class="col-md-7"><?php echo FvnHtml::calendar(HBDateHelper::display($p->birthday), 'passenger['.$p->id.'][birthday]','pss_'.$p->id, HBDateHelper::getConvertDateFormat('J'))?></div>
				</div>
				<div class="row form-group">
					<div class="col-md-5">Passport</div>
					<div class="col-md-7"><input type="text" value="<?php echo $p->passport ?>" name="passenger[<?php echo $p->id?>][passport]" class="regular-text ltr"/></div>
				</div>
				<?php if($p->passport_image){?>
				<div class="row form-group">
					<div class="col-md-5">Passport image</div>
					<div class="col-md-7"><a target="_blank" href="<?php echo site_url().$p->passport_image?>"><img style="width:50px" src="<?php echo site_url().$p->passport_image?>" /></a></div>
				</div>
				<?php }?>
				<input type="hidden" value="<?php echo $p->order_id ?>" name="passenger[<?php echo $p->id?>][order_id]" />
				<input type="hidden" value="<?php echo $p->id ?>" name="passenger[<?php echo $p->id?>][id]" />
			<?php }?>


		<?php wp_nonce_field( 'hb_action', 'hb_meta_nonce' );?>
		<center><button type="submit" class="btn btn-primary btn-lg">Lưu</button></center>
	
	</div>
	<div class="col-md-4">
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Order number')?></div>
			<div class="col-md-7"><?php echo $this->item->order_number?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Order status')?></div>
			<div class="col-md-7"><?php echo OrderStatus::getHtmlList('data[order_status]', '', $this->item->order_status)?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Pay status')?></div>
			<div class="col-md-7"><?php echo PayStatus::getHtmlList('data[pay_status]', '', $this->item->pay_status)?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Transaction id')?></div>
			<div class="col-md-7"><?php echo $this->item->pay_method.' '.($this->item->tx_id)?></div>
		</div>
		<h3><?php echo __('Extra service')?></h3>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Private visa later')?></div>
			<div class="col-md-7"><?php echo FvnHtml::booleanlist('data[private_later]','',$this->item->private_later)?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('AIrport fast track')?></div>
			<div class="col-md-7"><?php echo $this->item->params['airport_fast_track']?'Yes':'No'?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Car service')?></div>
			<div class="col-md-7"><?php echo $this->item->params['car_service']?'Car '.$this->item->params['car_service'].' seats':'No'?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Created')?></div>
			<div class="col-md-7"><?php echo HBDateHelper::display($this->item->created,'M d Y H:i')?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"><?php echo __('Scan visa result')?></div>
			<div class="col-md-7"></div>
		</div>
		<div>
			<?php echo FvnHtml::media_select('data[params][image_result]','image-p-result',isset($this->item->params['image_result'])?$this->item->params['image_result']:array(),true)?>
		</div>
	</div>
	
	
</div><!-- #primary -->
</div>
</form>
<style>
.upload-image-section{
border:1px solid #ccc;
padding:5px;
}</style>