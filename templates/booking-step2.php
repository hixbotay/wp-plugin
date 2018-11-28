<?php
// debug($_GET);
$input = HBFactory::getInput();
HBImporter::model('period','country','airport','processing_time');
HBImporter::helper('math','date','currency','price');
$config = HBFactory::getConfig();
$country = (new HBModelCountry())->getDataByCode($input->get('country_code'));
$periods = (new HBModelPeriod())->getList();		
$airport = (new HBModelAirport())->getItem($input->get('airport_id'));		

$processing_time = (new HBModelProcessing_time())->getItem($input->get('processing_time'));
// debug($processing_time);die;
$period = HBHelperMath::filterArrayObject($periods, 'id', $input->get('period_id'));

$data = [];
$params = array(
	'period'=>$period,
	'country'=> $country,
	'airport'=>$airport,
	'processing_time'=> $processing_time,
	'passenger_number' => $input->get('passenger_number'),
	'private_later'=> $input->get('private_later'),
	'airport_fast_track'=> $input->get('airport_fast_track'),
	'car_service'=> $input->getInt('car_service'),
	'purpose_of_visit'=> $input->get('purpose_of_visit'),
	'start' => HBDateHelper::createFromFormatYmd($input->get('start'))
);
$price = FvnPriceHelper::caculate($params);

FvnHtml::add_datepicker_lib();
add_filter('pre_get_document_title',function(){return __('Booking step 2');});
?>
<?php get_header();?>
<div class="container">
<div class="tab-step clearfix">
	<h1 class="note">Vietnam Visa Application Form</h1>
	<ul class="style-step hidden-xs">
		<li class="active"><font class="number">1.</font> <?php echo ('Visa Options')?></li>
		<li class="active"><font class="number">2.</font> <?php echo __('Applicant Details')?></li>
		<li><font class="number">3.</font> <?php echo __('Review and Payment')?></li>
	</ul>
</div>

<div class="applyform step2">
	<form id="frmApply" class="form-horizontal" role="form" action="index.php" method="POST" enctype="multipart/form-data">
		
		<div class="row clearfix">
			<div class="col-lg-9 col-sm-8">
				<div class="group passport-information">
					<h2>Passport Information</h2>
					<div class="group-content">
						<?php for($i=0;$i<$input->getInt('passenger_number');$i++){?>
							<div class="form-group row passport-detail">
								<div class="col-md-3">
									<label class="form-label">#<?php echo ($i+1)?>. <?php echo __('Full name')?><span class="required">*</span></label>
									<div>
										<input required type="text" id="fullname_<?php echo $i?>" name="person[<?php echo $i?>][fullname]" class="form-control fullname_1" value="">
									</div>
								</div>
								<div class="col-sm-1">
									<label class="form-label"><?php echo __('Gender')?><span class="required">*</span></label>
									<div>
										<select required id="gender_1" name="person[<?php echo $i?>][gender]" class="form-control gender_<?php echo ($i+1)?>">
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<label class="form-label">Birth date<span class="required">*</span></label>
									<div class="row row-sm">
										<?php echo FvnHtml::calendar(HBFactory::getDate('-18 Years')->format(HBDateHelper::getConvertDateFormat()),'person['.$i.'][birthday]', "birthday_{$i}",HBDateHelper::getConvertDateFormat('J'),' required readonly="true" class="form-control"',array('changeMonth'=> 1,'changeYear'=> true,'maxDate'=>'+0','yearRange'=>'c-50:c+30'))?>
									</div>
								</div>
								<div class="col-sm-2">
									<label class="form-label"><?php echo __('Nationality')?><span class="required">*</span></label>
									<div>
										<input type="hidden" name="person[<?php echo $i?>][country_code]" value="<?php echo $input->get('country_code')?>"/>
										<span class="country_name_t"><?php echo $country->country_name?></span>
									</div>
								</div>
								<div class="col-md-3">
									<label class="form-label">Passport number<span class="required">*</span></label>
									<div>
										<input required type="text" id="passportnumber_<?php echo $i?>" name="person[<?php echo $i?>][passport]" class="form-control passport" value="">	
										<?php if($processing_time->verify_image){?>
											<label class="form-label">Upload passport scan<span class="required">*</span></label>
											<input class="passport_image form-control" type="file" 
												value="<?php echo __('Upload')?>" required/>	
											<input type="hidden" required class="passport_image_input" name="person[<?php echo $i?>][passport_image]"/>
										<?php }?>
									</div>
								</div>
								
							</div>
						<?php }?>
																
						<div class="processing-note">
							<strong><?php echo __('Tips')?>:</strong>
							<ul>
								<li>The exact information includes full name, date of birth, passport number and nationality as your passport details.</li>
								<li>Passport expiration date must has at least 6 months validity when arriving to Vietnam.</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="group" id="flightinfo">
					<h2>Flight Information</h2>
					<div class="group-content">
						<p>Please fill out the flight information that we can pick you up on time at the airport.</p>
						<p>
							</p><div class="radio">
								<label for="flight_notbooked"><input type="radio" id="flight_notbooked" name="jform[flight]" class="flight_booking" value="0"> I have not booked yet</label>
							</div>
						<p></p>
						<p>
							</p><div class="radio">
								<label for="flight_booked"><input type="radio" id="flight_booked" name="jform[flight]" class="flight_booking" value="1" checked="checked"> I have booked (Recommended)</label>
							</div>
						<p></p>
						<div class="flight_table" name="flight_table" id="flight_table" style="display:block">
							<div class="form-group row">
								<label class="form-label col-md-3 col-xs-4 text-right">
									Flight number <span class="required">*</span>
								</label>
								<div class="col-sm-2 col-xs-8">
									<input type="text" id="flightnumber" name="params[flight_number]" class="form-control flightnumber" value="">
								</div>
							</div>
							<div class="form-group row">
								<label class="form-label col-md-3 col-xs-4 text-right">
									Arrival time <span class="required">*</span>
								</label>
								<div class="col-sm-2 col-xs-8">
									<input type="text" id="arrivaltime" name="jform[start_time]" class="form-control arrivaltime" value="">
									<span class="help-block">(ie. 23:30) 24 hour format</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="group">
					<h2>Contact Information</h2>
					<div class="group-content">
						<div class="form-group row">
							<label class="form-label col-md-3 text-right">
								Full name <span class="required">*</span>
							</label>
							<div class="col-sm-9">
								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4">
										<select id="contact_title" name="jform[title]" class="form-control">
											<option value="Mr" selected="selected">Mr</option>
											<option value="Ms">Ms</option>
											<option value="Mrs">Mrs</option>
										</select>
									</div>
									<div class="col-xs-8 col-sm-8 col-md-8" style="padding-left: 0">
										<input type="text" id="contact_fullname" name="jform[fullname]" class="form-control" value="">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-md-3 text-right">
								Email <span class="required">*</span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="contact_email" name="jform[email]" class="form-control" value="">
							</div>
						</div>
						
						<div class="form-group row">
							<label class="form-label col-md-3 text-right">
								Phone number
							</label>
							<div class="col-sm-9">
								<input type="text" id="contact_phone" name="jform[mobile]" class="form-control" value="">
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-md-3 text-right">
								Leave a message
							</label>
							<div class="col-sm-9">
								<textarea id="comment" name="jform[notes]" class="form-control" rows="5"></textarea>
								<div class="checkbox">
									<label for="information_confirm"><input type="checkbox" id="information_confirm" name="information_confirm" required /> I would like to confirm the above information is correct.</label>
								</div>
								<div class="checkbox">
									<label for="terms_conditions_confirm"><input required type="checkbox" id="terms_conditions_confirm" name="terms_conditions_confirm" > I have read and agreed <a title="Terms and Condition" class="terms_conditions_confirm" target="_blank" href="#">Terms and Condition</a>.</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="group">
					<div class="form-group" style="padding-top: 20px; padding-bottom: 20px;">
						<div class="text-center">
							<a class="btn btn-danger btn_back"  href="<?php echo site_url('booking')?>"><i class="icon-double-angle-left icon-large"></i> BACK</a>
							<button class="btn btn-danger btn_next" type="submit">NEXT <i class="icon-double-angle-right icon-large"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-4">
				<?php echo HBHelper::renderLayout('order_info',array('params'=>$params,'price'=>$price))?>
			</div>
		</div>
		<input type="hidden" name="jform[period_id]" value="<?php echo $input->getInt('period_id')?>">
		<input type="hidden" name="jform[country_code]" value="<?php echo $input->get('country_code')?>">
		<input type="hidden" name="jform[airport_id]" value="<?php echo $input->getInt('airport_id')?>">
		<input type="hidden" name="jform[private_later]" value="<?php echo $input->getInt('private_later')?>">
		<input type="hidden" name="params[airport_fast_track]" value="<?php echo $input->getInt('airport_fast_track')?>">
		<input type="hidden" name="params[car_service]" value="<?php echo $input->getInt('car_service')?>">
		<input type="hidden" name="jform[purpose_of_visit]" value="<?php echo $input->get('purpose_of_visit')?>">
		<input type="hidden" name="jform[processing_time]" value="<?php echo $input->getInt('processing_time')?>">
		<input type="hidden" name="jform[start]" value="<?php echo $input->getString('start')?>">
		<input type="hidden" name="jform[passenger_number]" value="<?php echo $input->getInt('passenger_number')?>">
		<input type="hidden" id="task" name="task" value="book">
		<input type="hidden" name="hbaction" value="order">
	</form>
</div>
</div>
<script>
jQuery(document).ready(function($){
	$('.passport_image').click(function(){
		var passport_number = jQuery(this).parent().find('.passport').val();
		if (passport_number == '') {
	        jnotice('<?php echo __('Please enter your passport number')?>');
	        return false;
	    } 
	});
	$('.passport_image').on('change',function(){
		var passport_number = jQuery(this).parent().find('.passport').val();

	    var file_data = jQuery(this).prop('files')[0];
	    
	    var form_data = new FormData();
	    
	    
		form_data.append("uploadfile", file_data);
		form_data.append("passport_number", passport_number);
		 
		var parent = $(this).parent();
		
		if(file_data.size>1000000){
			jnotice("<?php echo __('File upload must smaller than 1 Mb')?>");
			return false;
		}
		if(file_data.type!='image/jpeg' && file_data.type!='image/png'){
			jnotice("<?php echo __('File upload must is jpg or png file')?>");
			return false;
		}
		
	    jQuery.ajax({
	        url: '<?php echo site_url('?hbaction=order&task=upload_passport_image'); ?>',
	        type: 'post',
	        contentType: false,
	        processData: false,
	        data: form_data,
	        beforeSend: function(){display_processing_form(1);},
	        success: function (response) {
		        display_processing_form(0);
		        parent.find('.passport_image_input').val(response);
		        parent.append('<img src="<?php echo site_url()?>'+response+'" style="width:50px;float:left;"/>');
	        },
	        error: function (response) {
	        	display_processing_form(0);
	         	console.log(response);
	         	jnotice(response.responseText);
	        }

		    });
	});
});
</script>
<style>
input,select{background:#fff !important;}</style>
<?php get_footer() ?>